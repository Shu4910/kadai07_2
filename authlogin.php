<?php
session_start();


// フォームからの入力値を取得
$email = isset($_POST['email']) ? $_POST['email'] : '';
$code = isset($_POST['code']) ? $_POST['code'] : '';

// セッションから保存されたメールアドレスと認証コードを取得
$savedEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$savedCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';

// ログインの検証処理
// ここでデータベースやファイルから保存されたメールアドレスと認証コードとの比較を行います

// 例: 正しいメールアドレスと認証コードが一致する場合
if ($email === $savedEmail && $code === $savedCode) {
    // ログイン状態をセッションに保存
    $_SESSION['loggedin'] = true;

    // ログイン後のリダイレクト先を指定（a.phpにリダイレクトする場合）
    header('Location:info.php');
    exit();
} else {
    // 認証エラーの場合は適切な処理を行う（例: エラーメッセージの表示など）
    echo 'ログイン失敗';
}
?>
