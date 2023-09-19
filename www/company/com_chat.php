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
        .button-group {
            display: flex;
            justify-content: center; /* ボタンを中央に配置 */
            gap: 15px; /* ボタン間のスペース */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="my-3">会員やり取り</h1>
        <?php
        session_start();

        require '../../database_dbh.php';

        $mail = $_SESSION['mail'];

        $sql_company = "SELECT company_id, houjin FROM bizdiverse_company WHERE mail = :mail";
        $stmt_company = $dbh->prepare($sql_company);
        $stmt_company->bindParam(':mail', $mail);
        $stmt_company->execute();
        $company = $stmt_company->fetch(PDO::FETCH_ASSOC);
        $company_id = $company['company_id'];

        // セッションIDごとにデータを取得し、send_atの降順で並べます。
        $sql = "SELECT DISTINCT session_id, user_send_id, company_send_id, share_user, last_id, send_at, id FROM messages WHERE company_send_id = :company_id ORDER BY send_at DESC, session_id DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':company_id', $company_id);
        $stmt->execute();
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        function formatDate($send_at)
        {
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
            foreach ($sessions as $session) :
                $id = $session['id'];
                $last_id = $session['last_id'];

                if ($id !== $last_id) {
                    continue;
                }

                $session_id = $session['session_id'];
                $user_send_id = $session['user_send_id'];
                $company_send_id = $session['company_send_id'];
                $send_at = formatDate($session['send_at']);
                $share_user = $session['share_user'];

                $sql_user = "SELECT kana, types, techo, work, jigyousho, techo_num, mail, tel FROM bizdiverse_user WHERE id = :user_send_id";
                
        $sql = "SELECT DISTINCT session_id, user_send_id, company_send_id, share_user, last_id, send_at, id FROM messages WHERE company_send_id = :company_id ORDER BY send_at DESC, session_id DESC";
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
                $mail = $user['mail'];
                $tel = $user['tel'];
            ?>
                <a href="message_details.php?session_id=<?= $session_id ?>" class="list-group-item list-group-item-action">
                    <!-- id: <?= $id ?><br>
                    session_id: <?= $session_id ?><br>
                    company_send_id: <?= $company_send_id ?><br>
                    user_send_id: <?= $user_send_id ?><br>
                    last_id: <?= $last_id ?><br> -->
                    ニックネーム: <?= $kana ?><br>
                    <?php
                    if ($share_user == 1) {
                        echo "メール: " . $mail . "<br>";
                        echo "電話番号: " . $tel . "<br>";
                    }
                    ?>
                    障害種別: <?= $types ?><br>
                    手帳: <?= $techo ?><br>
                    やり取り: <?= $send_at ?>
                </a>
            <?php endforeach; ?>
        </ul>
        <div class="button-group"> <!-- ボタンをラップする div -->
        <button onclick="location.href='dash_com.php'" class="btn btn-primary mt-3">Back</button>
        </div>
    </div>
    <footer class="text-center mb-4 pt-3">
        <p>&copy; BizDiverse</p>
    </footer>

</body>

</html>
