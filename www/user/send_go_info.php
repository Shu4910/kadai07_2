<?php
session_start();

require __DIR__ . '/../../vendor/autoload.php';

$dotenvPath = __DIR__ . '/../../.env';
if (file_exists($dotenvPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname($dotenvPath));
    $dotenv->load();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function loadEnv() {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

loadEnv();

if (isset($_POST['session_id'])) {
    $session_id = $_POST['session_id'];
    $sender_type = $_POST['sender_type'];

    $ids = explode('_', $session_id);
    $company_send_id = $ids[0];
    $user_send_id = $ids[1];

    require '../../database_dbh.php';

    // session_idが一致するデータでshare_userのステータスが1が存在するかチェック
    $sql_check = "SELECT COUNT(*) as count FROM messages WHERE session_id = :session_id AND share_user = 1";
    $stmt_check = $dbh->prepare($sql_check);
    $stmt_check->bindParam(':session_id', $session_id);
    $stmt_check->execute();
    $share_user_exists = $stmt_check->fetch(PDO::FETCH_ASSOC)['count'] > 0;

    if ($share_user_exists) {
        $sql_user_info = "SELECT name FROM bizdiverse_user WHERE id = :user_send_id";
        $stmt_user_info = $dbh->prepare($sql_user_info);
        $stmt_user_info->bindParam(':user_send_id', $user_send_id);
        $stmt_user_info->execute();

        $user_name = $stmt_user_info->fetch(PDO::FETCH_ASSOC)['name'];

        // message_bodyの内容を更新
        $message_body = $user_name . "が本通所を決めました。";

        // SQLを準備（go_userを追加）
        $sql = "INSERT INTO messages (session_id, user_send_id, company_send_id, send_at, sender_type, message_body, go_user, share_user) VALUES (:session_id, :user_send_id, :company_send_id, NOW(), :sender_type, :message_body, 1, 1)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->bindParam(':user_send_id', $user_send_id);
        $stmt->bindParam(':company_send_id', $company_send_id);
        $stmt->bindParam(':sender_type', $sender_type);
        $stmt->bindParam(':message_body', $message_body);
        $stmt->execute();

    if($stmt->rowCount() > 0) {
        $sql = "SELECT mail FROM bizdiverse_company WHERE company_id = :company_send_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':company_send_id', $company_send_id);
        $stmt->execute();

        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $subject = "New";
        $message = "新着メッセージがあります。チャットを確認してください。\n\nメッセージ内容: " . $message_body;

        $mailer = new PHPMailer(true);
        try {
            $mailer->isSMTP();
            $mailer->Host = $_ENV['SMTP_HOST'];
            $mailer->Port = $_ENV['SMTP_PORT'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $_ENV['SMTP_USER'];
            $mailer->Password = $_ENV['SMTP_PASS'];
            $mailer->setFrom('postmaster@komaki0910.sakura.ne.jp', 'User_reply(BizDiverse)');
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
        } 
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mailer->ErrorInfo}";
        }
    }
    header("Location: message_details.php?session_id=$session_id");
} else {
    echo '<script>';
    echo 'alert("名前・連絡先の共有が完了していません。メッセージに戻ります。");';
    echo 'window.location.href = "message_details.php?session_id=' . $session_id . '";';
    echo '</script>';
}
} else {
    echo '<script>';
    echo 'alert("No session_id provided!");';
    echo 'window.location.href = "message_details.php";';  // セッションIDが指定されていない場合のリダイレクト先を指定します。
    echo '</script>';
}
?>