<?php
session_start();

// フォームからの入力値を取得
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$code = isset($_POST['code']) ? $_POST['code'] : '';

// セッションにメールアドレスを保存
$_SESSION['mail'] = $mail;

// セッションから保存された認証コードを取得
$savedCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';

// ログインの検証処理
// ここでデータベースやファイルから保存された認証コードとの比較を行います

// 例: 正しいメールアドレスと認証コードが一致する場合
if ($mail === $_SESSION['mail'] && $code === $savedCode) {
    // ログイン状態をセッションに保存
    $_SESSION['loggedin'] = true;

    // ログイン後のリダイレクト先を指定（a.phpにリダイレクトする場合）
    header('Location:info2.php');
    exit();
} else {
    // 認証エラーの場合は適切な処理を行う（例: エラーメッセージの表示など）
    echo 'ログイン失敗';
}
?>
