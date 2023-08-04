<?php
session_start(); // セッションを開始

function loadEnv()
{    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();
}

require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client; // 追加

loadEnv();

if (isset($_POST['session_id']) && isset($_POST['message_body'])) {
    $session_id = $_POST['session_id'];
    $message_body = $_POST['message_body'];
    $sender_type = $_POST['sender_type'];

    $ids = explode('_', $session_id);
    $company_send_id = $ids[0];
    $user_send_id = $ids[1];

    require '../../database_dbh.php';

    $sql = "INSERT INTO messages (session_id, user_send_id, message_body, send_at, sender_type) VALUES (:session_id, :user_send_id, :message_body, NOW(), :sender_type)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':user_send_id', $user_send_id);
    $stmt->bindParam(':message_body', $message_body);
    $stmt->bindParam(':sender_type', $sender_type);
    $stmt->execute();

    $last_message_id = $dbh->lastInsertId();
    $sql = "UPDATE messages SET last_id = :last_id WHERE session_id = :session_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':last_id', $last_message_id);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $sql = "SELECT mail, tel FROM bizdiverse WHERE id = :user_send_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_send_id', $user_send_id);
        $stmt->execute();

        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get the company name using the $company_send_id
        $sql = "SELECT houjin FROM bizdiverse_company WHERE company_id = :company_send_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':company_send_id', $company_send_id);
        $stmt->execute();

        $company = $stmt->fetch(PDO::FETCH_ASSOC);
        $company_name = $company['houjin'];

        $subject = "New_Message(BizDiverse)";
        $message = "新着メッセージがあります。" . "企業名: " . $company_name . "\n\nメッセージ内容: " . $message_body;
        
        $mailer = new PHPMailer(true);
        try {
            $mailer->isSMTP();
            $mailer->Host = $_ENV['SMTP_HOST']; 
            $mailer->Port = $_ENV['SMTP_PORT']; 
            $mailer->SMTPAuth = true; 
            $mailer->Username = $_ENV['SMTP_USER'];
            $mailer->Password = $_ENV['SMTP_PASS']; 
            $mailer->setFrom('postmaster@komaki0910.sakura.ne.jp', 'Test');
            $url = "http://komaki0910.sakura.ne.jp/company/message_details.php?session_id=$session_id";
            $message .= "\n\nメッセージやり取りページ: <a href='$url'>$url</a>";
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body    = $message;
            $mailer->AltBody = strip_tags($message);

            $comEmails = array_filter($contacts, function ($contact) {
                return filter_var($contact['mail'], FILTER_VALIDATE_EMAIL);
            });

            foreach($comEmails as $contact) {
                $mailer->addAddress($contact['mail']);
            }

            $mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mailer->ErrorInfo}";
        }

        $sid = $_ENV['TWILIO_SID'];
        $token = $_ENV['TWILIO_AUTH_TOKEN'];
        $twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];
        $twilio = new Client($sid, $token);
    
        $sms_body = "（BizDiverse）新着メッセージが届いています。";

        $phoneNumbers = array_column($contacts, 'tel');

        foreach($phoneNumbers as $phoneNumber) {
            $internationalPhoneNumber = '+81' . substr($phoneNumber, 1);
            $twilio->messages->create(
                $internationalPhoneNumber,
                [
                    'from' => $twilio_number,
                    'body' => $sms_body
                ]
            );
        }
    }
    header("Location: message_details.php?session_id=$session_id");
} else {
    echo "No session_id or message_body specified.";
}
?>
