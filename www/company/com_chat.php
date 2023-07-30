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

        $dbh = new PDO('mysql:dbname=bizdiverse;charset=utf8;host=localhost', 'root', '');
require '../../database.php';




        $com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得

        // ログインしているユーザーのcompany_idを取得
        $sql_company = "SELECT company_id FROM bizdiverse_company WHERE com_email = '$com_email'";
        $stmt_company = $dbh->query($sql_company);
        $company = $stmt_company->fetch(PDO::FETCH_ASSOC);
        $company_id = $company['company_id'];

        // SQLを準備
        $sql = "SELECT DISTINCT session_id, user_send_id, company_send_id FROM messages WHERE company_send_id = '$company_id' ORDER BY session_id";

        // SQLを実行
        $stmt = $dbh->query($sql);

        // 全ての結果をフェッチ（取得）する
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <ul class="list-group">
            <?php 
            foreach ($sessions as $session):
                $session_id = $session['session_id'];
                $user_send_id = $session['user_send_id'];
                $company_send_id = $session['company_send_id'];
            ?>
            <a href="message_details.php?session_id=<?= $session_id ?>" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Session ID: <?= $session_id ?></h5>
                <p>User Send ID: <?= $user_send_id ?></p>
                <p>Company Send ID: <?= $company_send_id ?></p>
            </a>
            <?php endforeach; ?>
        </ul>

        <button onclick="location.href='dash_com.php'" class="btn btn-primary mt-3">Back</button>
    </div>
</body>
</html>
