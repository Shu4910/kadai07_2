<?php
session_start(); // セッションを開始

require '../../database.php';


$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_user WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>都道府県から沿線/駅表示プルダウン表示</title>
<script type="text/javascript" src="https://express.heartrails.com/api/express.js"></script>
</head>
<body onload="HRELoadPrefecture('prefecture', 'line', 'station');">
<p>都道府県の、希望する駅・路線を入力してください。路線のみ記入でも可能です。</p>
        <select id="prefecture" name="prefecture" onchange="HREOnChangePrefecture();">
            <option value="">都道府県を選択してください</option>
        </select>
        <select id="line" name="line" onchange="HREOnChangeLine();">
        <option value="路線を選択してください">路線を選択してください</option>
        </select>
        <select id="station" name="station">
        <option value="駅を選択してください">駅を選択してください</option>
        </select>

</body>

</html>