<!DOCTYPE html>
<html>
<head>
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
            background-color: #00B900;
        }

        .message-user {
            background-color: #8A8A8A;
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

            .message-user {
                margin-left: auto;
            }

            .message-company {
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
    session_start(); // セッションを開始

    if (isset($_GET['session_id'])) {
        $session_id = $_GET['session_id'];

        
        // session_idをcompany_send_idとuser_send_idに分割
        $ids = explode('_', $session_id);
        $company_send_id = $ids[0];
        $user_send_id = $ids[1];

        require '../../database_dbh.php';

        // SQLを準備
        $sql = "SELECT * FROM messages WHERE session_id = :session_id ORDER BY send_at";

        // SQLを実行
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();

        // 全ての結果をフェッチ（取得）する
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);


        
        // 最新のメッセージのIDを取得
        $last_message_id = end($messages)['id'];

        // last_idカラムに最新のメッセージIDを保存
        $sql = "UPDATE messages SET last_id = :last_id WHERE session_id = :session_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':last_id', $last_message_id);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
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


    <form method="post" action="sm_detail_com.php">
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
