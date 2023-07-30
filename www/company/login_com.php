<?php
session_start(); // セッションを開始

// 2. DB接続

require '../../database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $com_email = $_POST['com_email'];
    $pass = $_POST['pass'];

    // メールアドレスに一致するユーザーを検索
    $stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE com_email = :com_email");
    $stmt->bindValue(':com_email', $com_email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーの存在を確認
    if ($user) {
        echo "User found.<br/>";
    } else {
        echo "User not found.<br/>";
    }

    // ユーザーが存在し、パスワードが一致するかを確認
    if ($user && password_verify($pass, $user['pass'])) {
        $_SESSION['com_email'] = $user['com_email']; // ユーザーをログイン状態にする
        header('Location: dash_com.php'); // ユーザーをダッシュボードまたはホームページにリダイレクト
        exit;
    } else {
        echo "Password not verified.<br/>";
        $msg = 'Eメールまたはパスワードが間違っています。';
    }
}
?>
