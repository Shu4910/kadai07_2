<?php
session_start(); // セッションを開始


require __DIR__ . '/../../vendor/autoload.php';

// .envファイルのパスを設定
$dotenvPath = __DIR__ . '/../../.env';
if (file_exists($dotenvPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname($dotenvPath));
    $dotenv->load();
} else {
    // .envファイルが見つからない場合はエラー処理を行うか、適切なデフォルト値をセットします
    // エラー処理の例: die(".envファイルが見つかりません。");
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


if (isset($_POST['session_id'])) {
    $session_id = $_POST['session_id'];
    $sender_type = $_POST['sender_type'];

    // session_idをcompany_send_idとuser_send_idに分割
    $ids = explode('_', $session_id);
    $company_send_id = $ids[0];
    $user_send_id = $ids[1];

    require '../../database_dbh.php';


 // bizdiverse_userから該当ユーザーの情報を取得
 $sql_user_info = "SELECT name, mail, tel FROM bizdiverse_user WHERE id = :user_send_id";
 $stmt_user_info = $dbh->prepare($sql_user_info);
 $stmt_user_info->bindParam(':user_send_id', $user_send_id);
 $stmt_user_info->execute();

 $user_info = $stmt_user_info->fetch(PDO::FETCH_ASSOC);
 // message_bodyの内容を組み立て
 $message_body = "名前: " . $user_info['name'] . "\n\n" .
                 "メール: " . $user_info['mail'] . "\n\n" .
                 "電話: " . $user_info['tel'];

 // SQLを準備（message_bodyを追加）
 $sql = "INSERT INTO messages (session_id, user_send_id, company_send_id, send_at, sender_type, message_body) VALUES (:session_id, :user_send_id, :company_send_id, NOW(), :sender_type, :message_body)";

 // SQLを実行
 $stmt = $dbh->prepare($sql);
 $stmt->bindParam(':session_id', $session_id);
 $stmt->bindParam(':user_send_id', $user_send_id);
 $stmt->bindParam(':company_send_id', $company_send_id);
 $stmt->bindParam(':sender_type', $sender_type);
 $stmt->bindParam(':message_body', $message_body);  // こちらを追加
 $stmt->execute();

    // If last_id was updated (a new message arrived), send a notification email
    // if($stmt->rowCount() > 0) {
    //     $sql = "SELECT mail FROM bizdiverse_user WHERE id = :user_send_id UNION SELECT mail FROM bizdiverse_company WHERE company_id = :company_send_id";
    //     $stmt = $dbh->prepare($sql);
    //     $stmt->bindParam(':user_send_id', $user_send_id);
    //     $stmt->bindParam(':company_send_id', $company_send_id);
    //     $stmt->execute();
    //     $emails = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); // Extract only the email column

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
    echo "No session_id";
}