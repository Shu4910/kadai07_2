<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<div class="container mt-5">
    <div class="justify-content-center">
        <div class="col-sm-4">
            <form action="info_com.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">基本情報修正画面</button>
            </form>
            <form action="com_scout_set.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">エリア条件設定画面</button>
            </form>
            <form action="com_kodawari.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">こだわり条件設定画面</button>
            </form>
            <form action="cus_search.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">会員検索画面</button>
            </form>
            <form action="com_chat.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">スカウトやり取り画面</button>
            </form>
            <form action="index_com.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">ログアウト</button>
            </form>
            <form action="result.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">数値</button>
            </form>
        </div>

        <div class="col-sm-8">
            <?php
            
            include '../../database_sakura_dbh.php';

            // 全体の総数を取得
            $query = 'SELECT COUNT(DISTINCT user_send_id) as total_unique_user_count, COUNT(*) as total_message_count FROM messages WHERE company_send_id = 3';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $total_counts = $stmt->fetch();

            // company_send_idが3のデータとuser_send_idとのやり取りの数を取得
            $query = 'SELECT user_send_id, COUNT(*) as count FROM messages WHERE company_send_id = 3 GROUP BY user_send_id';
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            // 結果をHTMLテーブルとして出力
            echo "<table class='table'>";
            echo "<thead><tr><th>User ID</th><th>Count</th></tr></thead>";
            echo "<tbody>";
            while ($row = $stmt->fetch())
            {
                echo "<tr>";
                echo "<td>" . $row['user_send_id'] . "</td>";
                echo "<td>" . $row['count'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

            echo "<br><br>"; // 空行を追加

            // ユニークなユーザーの総数と全メッセージの総数を別のテーブルで表示
            echo "<table class='table'>";
            echo "<thead><tr><th>Total unique users</th><th>Total messages</th></tr></thead>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td>" . $total_counts['total_unique_user_count'] . "</td>";
            echo "<td>" . $total_counts['total_message_count'] . "</td>";
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS and JQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-feJI7QwhOS+hwpX2zkaeJQjeiwlhOP+SdQDqhgvvo1DsjtiSQByFdThsxO669S2D" crossorigin="anonymous"></script>

</body>
</html>
