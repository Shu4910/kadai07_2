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
            require '../../dbconfig.php'; // require.phpファイルを2つ上の階層から読み込み

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the form data
            $receiver_id = $_GET['id'];
            

            // Get sender_id based on email
            $stmt = $conn->prepare("SELECT company_id FROM bizdiverse_company WHERE com_email = ?");
            $stmt->bind_param("s", $com_email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $sender_id = $row['company_id'];

            $message_body = $_POST['message_body'];

            // Generate a unique session_id
            $session_id = $sender_id . "_" . $receiver_id;
            echo "Session ID: " . $session_id; // Add this line

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO messages (session_id, company_send_id, user_send_id, message_body) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $session_id, $sender_id, $receiver_id, $message_body);

            // Set parameters and execute
            $stmt->execute();

            // Get the auto-generated ID
$last_id = $conn->insert_id;

// Update the last_id column for the messages with the same session_id
$update_stmt = $conn->prepare("UPDATE messages SET last_id = ? WHERE session_id = ?");
$update_stmt->bind_param("is", $last_id, $session_id);
$update_stmt->execute();

            echo "Message sent successfully";

            $stmt->close();
$update_stmt->close(); // Add this line
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
<button onclick="location.href='cus_search.php'">Back</button>
<button onclick="location.href='dash_com.php'">ホームに戻る</button>

</body>
</html>
