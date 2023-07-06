<?php
session_start(); // セッションを開始
$com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message Sending</title>
    <meta charset="utf-8">
</head>
<body>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bizdiverse";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the form data
            $receiver_id = $_GET['id'];

            // Get sender_id based on email
            $stmt = $conn->prepare("SELECT id_com FROM bizdiverse_company WHERE com_email = ?");
            $stmt->bind_param("s", $com_email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $sender_id = $row['id_com'];

            $message_body = $_POST['message_body'];

            // Generate a unique session_id
            $session_id2 = $sender_id . "_" . $receiver_id;

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO messages (session_id2, company_send_id, user_send_id, message_body) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siis", $session_id2, $sender_id, $receiver_id, $message_body);


            // Set parameters and execute
            $stmt->execute();

            echo "Message sent successfully";

            $stmt->close();
            $conn->close();
        } else {
            // Show the form
            ?>
            <form method="post">
                <label for="message_body">Message:</label><br>
                <textarea id="message_body" name="message_body" rows="4" cols="50"></textarea><br>
                <input type="submit" value="Send">
            </form>
            <?php
        }
    ?>
</body>
</html>
