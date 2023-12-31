<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>メッセージ</title>
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
        <h1 class="my-3 text-center">メッセージ</h1>
        <?php
        session_start();

        require '../../database_dbh.php';

        $mail = $_SESSION['mail']; 

        // Prepare statement
        $sql_bizdiverse = "SELECT id FROM bizdiverse_user WHERE mail = :mail";
        $stmt_bizdiverse = $dbh->prepare($sql_bizdiverse);
        $stmt_bizdiverse->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt_bizdiverse->execute();
        $bizdiverse_user = $stmt_bizdiverse->fetch(PDO::FETCH_ASSOC);
        if ($bizdiverse_user) {
            $id = $bizdiverse_user['id'];
        } else {
            die("No matching user found");
        }


        $sql = "SELECT DISTINCT session_id, user_send_id, company_send_id, MAX(send_at) as last_send_at FROM messages WHERE user_send_id = :id OR company_send_id = :id GROUP BY session_id ORDER BY last_send_at DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);


        ?>

        <ul class="list-group">
        <?php
        foreach ($sessions as $session) {
            $session_id = $session['session_id'];
            $user_send_id = $session['user_send_id'];
            $company_send_id = $session['company_send_id'];
            
            // Use prepared statement to get the company name
            $sql_company = "SELECT houjin FROM bizdiverse_company WHERE company_id = :company_send_id";
            $stmt_company = $dbh->prepare($sql_company);
            $stmt_company->bindParam(':company_send_id', $company_send_id, PDO::PARAM_INT);
            $stmt_company->execute();
            $company = $stmt_company->fetch(PDO::FETCH_ASSOC);
            if ($company) {
                $company_name = $company['houjin'];
            } else {
                $company_name = "Unknown Company";
            }

            // Get the last message date for the session
            $sql_date = "SELECT DATE(send_at) AS send_date FROM messages WHERE session_id = :session_id ORDER BY send_at DESC LIMIT 1";
            $stmt_date = $dbh->prepare($sql_date);
            $stmt_date->bindParam(':session_id', $session_id, PDO::PARAM_INT);
            $stmt_date->execute();
            $last_message = $stmt_date->fetch(PDO::FETCH_ASSOC);

            if ($last_message) {
                $date_now = new DateTime(date("Y-m-d"));
                $date_message = new DateTime($last_message['send_date']);
                $interval = $date_now->diff($date_message);

                if ($interval->days == 1) {
                    $last_message_date = "昨日";
                } elseif ($interval->days == 0) {
                    $last_message_date = "今日";
                } else {
                    $last_message_date = $last_message['send_date'];
                }
            } else {
                $last_message_date = "Unknown Date";
            }        

            echo "<a href='message_details.php?session_id=$session_id' class='list-group-item list-group-item-action'>施設名: $company_name<br>やり取り日: $last_message_date</a>";
        }           ?>
                    </ul>
                    <div class="button-group"> <!-- ボタンをラップする div -->
                    <button class="btn btn-primary my-3" onclick="location.href='dash.php'">Back</button>
                    </div>
                </div>
        <!-- フッターにサービス名を追加 -->
<footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>
</body>
</html>
