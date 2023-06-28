<?php
session_start(); // セッションを開始

require 'database.php'; // データベース接続のスクリプト

$mail = $_POST['mail']; // POSTからメールアドレスを取得
$pass = $_POST['pass']; // POSTからパスワードを取得

$stmt = $pdo->prepare("SELECT * FROM bizdiverse WHERE mail = :mail AND pass = :pass");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    // エラーハンドリング
} else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $_SESSION['mail'] = $mail; // セッションにメールアドレスを保存
        header('Location: info.php'); // ユーザーダッシュボードにリダイレクト
    } else {
        echo "メールアドレスまたはパスワードが間違っています。";
    }
}
?>
