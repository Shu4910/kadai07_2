<?php
session_start(); // セッションを開始
$mail = $_SESSION['mail']; // セッションからメールアドレスを取得

function loadEnv() {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();
}

require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client; 

loadEnv();

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Message Sending</title>
    <meta charset="utf-8">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require '../../dbconfig.php'; 

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $receiver_id = $_GET['id'];
            $stmt = $conn->prepare("SELECT company_id FROM bizdiverse_company WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $sender_id = $row['company_id'];
            $message_body = $_POST['message_body'];
            $session_id = $sender_id . "_" . $receiver_id;

            $stmt = $conn->prepare("INSERT INTO messages (session_id, company_send_id, user_send_id, message_body, sender_type) VALUES (?, ?, ?, ?, 'company')");
            $stmt->bind_param("ssis", $session_id, $sender_id, $receiver_id, $message_body);
            $stmt->execute();

            $last_id = $conn->insert_id;
            $update_stmt = $conn->prepare("UPDATE messages SET last_id = ? WHERE session_id = ?");
            $update_stmt->bind_param("is", $last_id, $session_id);
            $update_stmt->execute();


            if($stmt->execute()) {
                echo "<div class='alert alert-success'>Message sent successfully</div>";
            
                // 受信者のメールアドレスを取得
    $sql = "SELECT mail, tel FROM bizdiverse_user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receiver_id);
    $stmt->execute();
    $contacts_result = $stmt->get_result();
    $contacts = $contacts_result->fetch_assoc();
    $receiver_email = $contacts['mail'];
    

            
            // Send email to the receiver
            $mailer = new PHPMailer(true);
            try {
                $mailer->isSMTP();
                $mailer->Host = $_ENV['SMTP_HOST']; 
                $mailer->Port = $_ENV['SMTP_PORT']; 
                $mailer->SMTPAuth = true; 
                $mailer->Username = $_ENV['SMTP_USER'];
                $mailer->Password = $_ENV['SMTP_PASS']; 
                $mailer->setFrom('postmaster@komaki0910.sakura.ne.jp', 'BizDiverse');
                $url = "http://komaki0910.sakura.ne.jp/user/message_details.php?session_id=$session_id";
                $mailer->isHTML(true);
                $mailer->Subject = "New_Message_from_company(BizDiverse)";
                $mailer->Body    = "新着メッセージがあります。\n\nメッセージ内容: " . $message_body . "\n\nメッセージやり取りページ: <a href='$url'>$url</a>";
                $mailer->AltBody = strip_tags($mailer->Body);
                $mailer->addAddress($receiver_email); // 受信者のメールアドレスを使用
                $mailer->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mailer->ErrorInfo}";
            }


        //SMS送信
        // $sid = $_ENV['TWILIO_SID'];
        // $token = $_ENV['TWILIO_AUTH_TOKEN'];
        // $twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];
        // $twilio = new Client($sid, $token);
        
        // $sms_body = "（BizDiverse）新着メッセージが届いています。";
        // $phoneNumber = $contacts['tel'];
        // $internationalPhoneNumber = '+81' . substr($phoneNumber, 1);
        // $twilio->messages->create(
        //     $internationalPhoneNumber,
        //     [
        //         'from' => $twilio_number,
        //         'body' => $sms_body
        //     ]
        // );

        } else {
            echo "<div class='alert alert-danger'>Receiver email not found.</div>";
        }
    } else 
        ?>
            <form method="post" class="bg-white p-4 rounded shadow">
                <div class="form-group">
                    <label for="message_body">Message:</label>
                    <textarea class="form-control" id="message_body" name="message_body" rows="4"></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="送信">
            </form>
        <?php
        ?>
        <div class="mt-3">
            <button onclick="location.href='cus_search.php'" class="btn btn-secondary">戻る</button>
            <button onclick="location.href='dash_com.php'" class="btn btn-info">ホームに戻る</button>
        </div>
    </div>
</body>

</html>
