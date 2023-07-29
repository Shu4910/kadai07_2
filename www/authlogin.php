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
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>認証エラー</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        // 認証エラーの場合は適切な処理を行う（例: エラーメッセージの表示など）
                        echo '<p class="text-danger">認証番号が異なっているか、すでにこのコードを使って認証が完了しています。</p>';
                        ?>
                        <button onclick="location.href='forgot1.php'" class="btn btn-primary">認証コード発行に戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
