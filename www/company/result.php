<?php
$host = 'localhost';
$db   = 'bizdiverse';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

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
echo "<table border='1'>";
echo "<tr><th>User ID</th><th>Count</th></tr>";
while ($row = $stmt->fetch())
{
    echo "<tr>";
    echo "<td>" . $row['user_send_id'] . "</td>";
    echo "<td>" . $row['count'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><br>"; // 空行を追加

// ユニークなユーザーの総数と全メッセージの総数を別のテーブルで表示
echo "<table border='1'>";
echo "<tr><th>Total unique users</th><th>Total messages</th></tr>";
echo "<tr>";
echo "<td>" . $total_counts['total_unique_user_count'] . "</td>";
echo "<td>" . $total_counts['total_message_count'] . "</td>";
echo "</tr>";
echo "</table>";
?>

<button onclick="location.href='dash_com.php'" class="btn btn-primary mt-3">Back</button>
