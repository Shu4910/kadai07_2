<?php
session_start(); // セッションを開始
$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
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
            $stmt = $conn->prepare("SELECT company_id FROM bizdiverse_company WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $sender_id = $row['company_id'];

            $message_body = $_POST['message_body'];

            // Generate a unique session_id
            $session_id = $sender_id . "_" . $receiver_id;

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

            echo "<div class='alert alert-success'>Message sent successfully</div>";

            $stmt->close();
            $update_stmt->close();
            $conn->close();
        } else {
            // Show the form
        ?>
            <form method="post" class="bg-white p-4 rounded shadow">
                <div class="form-group">
                    <label for="message_body">Message:</label>
                    <textarea class="form-control" id="message_body" name="message_body" rows="4"></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="Send">
            </form>
        <?php
        }
        ?>
        <div class="mt-3">
            <button onclick="location.href='cus_search.php'" class="btn btn-secondary">Back</button>
            <button onclick="location.href='dash_com.php'" class="btn btn-info">ホームに戻る</button>
        </div>
    </div>
</body>

</html>
