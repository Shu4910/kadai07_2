<?php



$dbh = new PDO('mysql:dbname=bizdiverse;charset=utf8;host=localhost', 'root', '');

// SQLを準備
$sql = "SELECT DISTINCT session_id FROM messages ORDER BY session_id";

// SQLを実行
$stmt = $dbh->query($sql);

// 全ての結果をフェッチ（取得）する
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// session_idを表示
foreach ($sessions as $session) {
    $session_id = $session['session_id'];
    echo "<a href='message_details.php?session_id=$session_id'>$session_id</a>";
    echo '<br>' . PHP_EOL;
}
?>


<button onclick="location.href='dash.php'">Back</button>
