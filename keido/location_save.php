<?php
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$pdo = new PDO('mysql:host=localhost;dbname=あなたのDB名;charset=utf8', 'ユーザ名', 'パスワード');
$sql = "INSERT INTO tableName (latitude, longitude) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$lat, $lng]);
?>


<?php
// POSTデータから経度と緯度を取得します
$lat = isset($_POST['lat']) ? (float) $_POST['lat'] : null;
$lng = isset($_POST['lng']) ? (float) $_POST['lng'] : null;

// データベースへの接続を確立します
$pdo = new PDO('mysql:host=localhost;dbname=あなたのDB名;charset=utf8', 'ユーザ名', 'パスワード');

// SQL文を準備します
$sql = "INSERT INTO tableName (latitude, longitude) VALUES (:lat, :lng)";

// プリペアードステートメントを準備します
$stmt = $pdo->prepare($sql);

// パラメータをバインドします
$stmt->bindValue(':lat', $lat, PDO::PARAM_STR);
$stmt->bindValue(':lng', $lng, PDO::PARAM_STR);

// SQLを実行します
$stmt->execute();
?>
