<?php
session_start(); // セッションを開始

require __DIR__ . '/../../vendor/autoload.php';

// .envファイルのパスを設定
$dotenvPath = __DIR__ . '/../../.env';
if (file_exists($dotenvPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname($dotenvPath));
    $dotenv->load();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function loadEnv()
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

loadEnv();

if (isset($_POST['session_id']) && isset($_POST['message_body'])) {
    $session_id = $_POST['session_id'];
    $message_body = $_POST['message_body'];
    $sender_type = $_POST['sender_type'];

    // session_idをcompany_send_idとuser_send_idに分割
    $ids = explode('_', $session_id);
    $company_send_id = $ids[0];
    $user_send_id = $ids[1];

    require '../../database_dbh.php';

    // Check if there's any message with the same session_id and share_user = 1
    $sql_check = "SELECT COUNT(*) FROM messages WHERE session_id = :session_id AND share_user = 1";
    $stmt_check = $dbh->prepare($sql_check);
    $stmt_check->bindParam(':session_id', $session_id);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    // If a message with share_user = 1 exists, then set share_user for the new message as 1, else 0.
    $share_user = ($count > 0) ? 1 : 0;

    // SQLを準備
    $sql = "INSERT INTO messages (session_id, user_send_id, company_send_id, message_body, send_at, sender_type, share_user) VALUES (:session_id, :user_send_id, :company_send_id, :message_body, NOW(), :sender_type, :share_user)";

    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':user_send_id', $user_send_id);
    $stmt->bindParam(':company_send_id', $company_send_id);
    $stmt->bindParam(':message_body', $message_body);
    $stmt->bindParam(':sender_type', $sender_type);
    $stmt->bindParam(':share_user', $share_user); // This is added
    $stmt->execute();

    // 新しく追加されたメッセージのIDを取得
    $last_message_id = $dbh->lastInsertId();

    // last_idカラムに最新のメッセージIDを保存
    $sql = "UPDATE messages SET last_id = :last_id WHERE session_id = :session_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':last_id', $last_message_id);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->execute();

// If last_id was updated (a new message arrived), send a notification email
if($stmt->rowCount() > 0) {
    // Fetch the email associated with the company_send_id
    $sql = "SELECT mail FROM bizdiverse_company WHERE company_id = :company_send_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':company_send_id', $company_send_id);
    $stmt->execute();

    $emails = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); // Extract only the email column


        $subject = "New";
        $message = "新着メッセージがあります。チャットを確認してください。\n\nメッセージ内容: " . $message_body;
        
$mailer = new PHPMailer(true);
try {
    // SMTP設定
    $mailer->isSMTP();
    $mailer->Host = $_ENV['SMTP_HOST']; // SMTPサーバーのホスト名
    $mailer->Port = $_ENV['SMTP_PORT']; // SMTPサーバーのポート番号
    $mailer->SMTPAuth = true; // SMTP認証を使用するかどうか
    $mailer->Username = $_ENV['SMTP_USER']; // SMTP認証のユーザー名
    $mailer->Password = $_ENV['SMTP_PASS']; // SMTP認証のパスワード
    $mailer->setFrom('postmaster@komaki0910.sakura.ne.jp', 'User_reply(BizDiverse)'); // 送信元メールアドレスと送信者名
    $url = "http://komaki0910.sakura.ne.jp/company/message_details.php?session_id=$session_id";
    $message .= "\n\nメッセージやり取りページ: <a href='$url'>$url</a>";
    $mailer->isHTML(true);
    $mailer->Subject = $subject;
    $mailer->Body    = $message;
    $mailer->AltBody = strip_tags($message);

    $comEmails = array_filter($emails, function ($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    });

    foreach($comEmails as $email) {
        $mailer->addAddress($email);
    }

    $mailer->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mailer->ErrorInfo}";
}
    }

    header("Location: message_details.php?session_id=$session_id");
} else {
    echo "No session_id or message_body specified.";
}