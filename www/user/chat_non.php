<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Session Details</title>
    <style>
        .list-group-item-action:hover {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-3">Session Details</h1>
        <?php
        session_start();

        require '../../database_dbh.php';

        $mail = $_SESSION['mail']; // セッションからメールアドレスを取得

        // メールアドレスと一致したbizdiverseのidを取得
        $sql_bizdiverse = "SELECT id FROM bizdiverse WHERE mail = '$mail'";
        $stmt_bizdiverse = $dbh->query($sql_bizdiverse);
        $bizdiverse = $stmt_bizdiverse->fetch(PDO::FETCH_ASSOC);
        $id = $bizdiverse['id'];

        // SQLを準備
        $sql = "SELECT DISTINCT session_id, user_send_id, company_send_id FROM messages WHERE user_send_id = '$id' OR company_send_id = '$id' ORDER BY session_id";

        // SQLを実行
        $stmt = $dbh->query($sql);

        // 全ての結果をフェッチ（取得）する
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <ul class="list-group">
        <?php
        // session_idを表示
        foreach ($sessions as $session) {
            $session_id = $session['session_id'];
            $user_send_id = $session['user_send_id'];
            $company_send_id = $session['company_send_id'];
        
            echo "<a href='message_details.php?session_id=$session_id' class='list-group-item list-group-item-action'>Session ID: $session_id<br>User Send ID: $user_send_id<br>Company Send ID: $company_send_id</a>";
        }
        ?>
        </ul>
        
        <button class="btn btn-primary my-3" onclick="location.href='dash.php'">Back</button>
    </div>
</body>
</html>
