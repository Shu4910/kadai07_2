<?php
session_start(); // セッションを開始

require 'database.php'; // データベース接続のスクリプト

$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

$stmt = $pdo->prepare("SELECT * FROM bizdiverse WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<form action="info.php" method="get">
  <button type="submit">基本情報修正画面</button>
</form>

<form action="scout_set.php" method="get">
  <button type="submit">スカウト条件設定画面</button>
</form>

<form action="scout_line.php" method="get">
  <button type="submit">スカウト受信画面</button>
</form>

<form action="index.php">
  <button type="submit">ログアウト</button>
</form>

</body>
</html>
