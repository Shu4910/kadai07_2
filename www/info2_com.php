<?php
session_start(); // セッションを開始

require '../database.php'; // データベース接続のスクリプト

$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: company/index_com.php');
        exit;
    }
    
    if (isset($_POST['update'])) {
        $newName = $_POST['houjin'];
        $newMail = $_POST['com_email'];
        $newPass = $_POST['pass'];
        $confirmPass = $_POST['confirm_pass'];

        if ($newPass === $confirmPass) {
            // パスワードをハッシュ化
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("UPDATE bizdiverse_company SET houjin = :houjin, com_email = :com_email, pass = :pass WHERE com_email = :oldMail");
            $stmt->bindValue(':houjin', $newName, PDO::PARAM_STR);
            $stmt->bindValue(':com_email', $newMail, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $hashedPass, PDO::PARAM_STR);
            $stmt->bindValue(':oldMail', $mail, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['com_email'] = $newMail; // Update the session email
            $mail = $newMail; // Update the local email variable
            $msg = '登録を更新しました。';
        } else {
            $msg = 'パスワードが一致しません。';
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE com_email = :com_email");
$stmt->bindValue(':com_email', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
if ($userData === false) {
    $userData = ['houjin' => '', 'mail' => ''];
}
?>

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
                                <label for="name">名前：</label>
                                <input type="text" class="form-control" id="houjin" name="houjin" value="<?php echo $userData['houjin']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mail">Eメール：</label>
                                <input type="email" class="form-control" id="com_email" name="com_email" value="<?php echo $userData['com_email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">パスワード：</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_pass">パスワード確認：</label>
                                <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary btn-block">更新</button>
                        </form>
                        <form method="POST" style="margin-top: 10px;">
                            <button type="submit" name="logout" class="btn btn-secondary btn-block">ログアウト</button>
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
