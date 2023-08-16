<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <style>
        .message-company,
        .message-user {
            color: white;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
            width: 70%;
        }

        .message-company {
            background-color: #8A8A8A;
            text-align: right;
        }

        .message-user {
            background-color: #00B900;
        }

        .message-container {
            max-height: 400px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .message-company,
            .message-user {
                width: 70%;
            }

            .message-company {
                margin-left: auto;
            }

            .message-user {
                margin-right: auto;
            }
        }

        @media (min-width: 1200px) {
            .message-company,
            .message-user {
                width: 50%;
            }
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

        require '../../database_dbh.php';



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
        <input type="hidden" name="sender_type" value="user">
        <input type="submit" value="Send" class="btn btn-primary">
    </form>

    <button onclick="location.href='chat_non.php'" class="btn btn-secondary mt-3">Back</button>
        <!-- フッターにサービス名を追加 -->
<footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>
</body>
</html>
