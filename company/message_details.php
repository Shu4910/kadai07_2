<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .message-company {
            color: white;
            background-color: #00B900;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
        }
        .message-user {
            color: white;
            background-color: #8A8A8A;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
        }
        .message-container {
            max-height: 400px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }
    </style>
    <script>
    window.onload = function() {
        var messageContainer = document.querySelector('.message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
</script>

</head>
<body class="p-3">
    <?php
    if (isset($_GET['session_id'])) {
        $session_id = $_GET['session_id'];

        $dbh = new PDO('mysql:dbname=bizdiverse;charset=utf8;host=localhost', 'root', '');

        // SQLを準備
        $sql = "SELECT * FROM messages WHERE session_id = :session_id ORDER BY send_at";

        // SQLを実行
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();

        // 全ての結果をフェッチ（取得）する
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="message-container">
        <?php foreach ($messages as $message): ?>
            <div class="message-<?php echo $message['sender_type']; ?>">
                <strong><?php echo ucfirst($message['sender_type']); ?></strong><br>
                <?php echo $message['message_body']; ?><br>
                <small><?php echo $message['send_at']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    } else {
        echo "No session_id specified.";
    }
    ?>

    <form method="post" action="sm_detail.php">
        <div class="form-group">
            <label for="message_body">Message:</label>
            <textarea class="form-control" id="message_body" name="message_body" rows="3"></textarea>
        </div>
        <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
        <input type="hidden" name="user_send_id" value="<?php echo $user_send_id; ?>">
        <input type="hidden" name="company_send_id" value="<?php echo $company_send_id; ?>">
        <input type="hidden" name="sender_type" value="company">
        <input type="submit" value="Send" class="btn btn-primary">
    </form>

    <button onclick="location.href='com_chat.php'" class="btn btn-secondary mt-3">Back</button>
</body>
</html>
