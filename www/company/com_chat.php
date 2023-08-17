<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session Details</title>
    <style>
        .list-group-item-action:hover {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-3">会員やり取り</h1>
        <?php
        session_start();
        
        require '../../database_dbh.php';

        $mail = $_SESSION['mail']; // セッションからメールアドレスを取得

        // ログインしているユーザーのcompany_idとhoujinを取得
        $sql_company = "SELECT company_id, houjin FROM bizdiverse_company WHERE mail = :mail";
        $stmt_company = $dbh->prepare($sql_company);
        $stmt_company->bindParam(':mail', $mail);
        $stmt_company->execute();
        $company = $stmt_company->fetch(PDO::FETCH_ASSOC);
        $company_id = $company['company_id'];

        // SQLを準備
        $sql = "SELECT DISTINCT session_id, user_send_id, company_send_id, send_at FROM messages WHERE company_send_id = :company_id ORDER BY session_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':company_id', $company_id);
        $stmt->execute();

        // 全ての結果をフェッチ（取得）する
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        function formatDate($send_at) {
            $today = new DateTime("today");
            $yesterday = new DateTime("yesterday");
        
            $send_date = new DateTime($send_at);
        
            if ($send_date->format('Y-m-d') == $today->format('Y-m-d')) {
                return '今日';
            } elseif ($send_date->format('Y-m-d') == $yesterday->format('Y-m-d')) {
                return '昨日';
            } else {
                return $send_date->format('Y-m-d');
            }
        }
        ?>


        <ul class="list-group">
            <?php 
foreach ($sessions as $session):
    $session_id = $session['session_id'];
    $user_send_id = $session['user_send_id'];
    $company_send_id = $session['company_send_id'];
    $send_at = formatDate($session['send_at']); // こちらを追加

               // user_send_idに対応するニックネーム(kana)とtypesを取得
$sql_user = "SELECT kana, types, techo,work, jigyousho,techo_num FROM bizdiverse_user WHERE id = :user_send_id";
$stmt_user = $dbh->prepare($sql_user);
$stmt_user->bindParam(':user_send_id', $user_send_id);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);
$kana = $user['kana'];
$types = $user['types']; 
$techo = $user['techo'];
$techo_num = $user['techo_num'];
$work = $user['work'];
$jigyousho = $user['jigyousho'];


?>
<a href="message_details.php?session_id=<?= $session_id ?>" class="list-group-item list-group-item-action">
    ニックネーム: <?= $kana ?><br>
    障害種別: <?= $types ?><br>  <!-- Typeも表示 -->
    手帳: <?= $techo ?><br>  <!-- Typeも表示 -->
    やり取り: <?= $send_at ?> <!-- この行を追加 -->
            </a>
            <?php endforeach; ?>
        </ul>

        <button onclick="location.href='dash_com.php'" class="btn btn-primary mt-3">Back</button>
    </div>
        <!-- フッターにサービス名を追加 -->
        <footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>

</body>
</html>
