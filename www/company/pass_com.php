<?php
session_start(); // セッションを開始
require '../../database.php';

$com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        header('Location: dash_com.php');
        exit;
    }

    if (isset($_POST['update'])) {
        $newMail = $_POST['com_email'];
        $newPass = $_POST['pass'];
        $confirmPass = $_POST['confirm_pass'];

        if ($newPass === $confirmPass) {
            // パスワードをハッシュ化
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("UPDATE bizdiverse_company SET com_email = :com_email, pass = :pass WHERE com_email = :oldMail");
            $stmt->bindValue(':com_email', $newMail, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $hashedPass, PDO::PARAM_STR);
            $stmt->bindValue(':oldMail', $com_email, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['com_email'] = $newMail; // Update the session email
            $com_email = $newMail; // Update the local email variable
            $msg = '登録を更新しました。';
        } else {
            $msg = 'パスワードが一致しません。';
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE com_email = :com_email");
$stmt->bindValue(':com_email', $com_email, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- HTML部分は以下に表示されます。-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <title>登録情報</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">登録情報</h2>
                <?php if (!empty($msg)) { echo '<div class="alert alert-danger">' . $msg . '</div>'; } ?>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="com_email">Eメール：</label>
                                <input type="email" class="form-control" id="com_email" name="com_email" value="<?php echo htmlspecialchars($userData['com_email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">新しいパスワード：</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_pass">新しいパスワードの確認：</label>
                                <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary btn-block">更新</button>
                        </form>
                        <form method="POST" style="margin-top: 10px;">
                            <button type="submit" name="logout" class="btn btn-secondary btn-block">戻る</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
