<?php
session_start(); // セッションを開始
require '../../database.php';

$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        header('Location: dash.php');
        exit;
    }

    if (isset($_POST['update'])) {
        // All the other form fields
        $newName = $_POST['name'];
        $newKana = $_POST['kana'];
        $newMail = $_POST['mail'];
        $newTel = $_POST['tel'];
        $newBirthday = $_POST['birthday'];
        $newTypes = $_POST['types'];
        $newTecho = $_POST['techo'];
        $newInfo = $_POST['info'];
        $newZipcode = $_POST['zipcode'];
        $newAddress1 = $_POST['address1'];
        $newAddress2 = $_POST['address2'];
        $newAddress3 = $_POST['address3'];
        $newPass = $_POST['pass'];

        // DBの現在のパスワードを取得
        $stmt = $pdo->prepare("SELECT pass FROM bizdiverse WHERE mail = :mail");
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        $currentPass = $stmt->fetchColumn();

        // 入力されたパスワードがDBのパスワードと一致する場合
        if (password_verify($newPass, $currentPass)) {
            // パスワードをハッシュ化
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

            // Prepare the update statement with all the fields
            $stmt = $pdo->prepare("UPDATE bizdiverse SET name = :name, kana = :kana, mail = :mail, tel = :tel, birthday = :birthday, types = :types, techo = :techo, info = :info, zipcode = :zipcode, address1 = :address1, address2 = :address2, address3 = :address3, pass = :pass WHERE mail = :oldMail");
            $stmt->bindValue(':name', $newName, PDO::PARAM_STR);
            $stmt->bindValue(':kana', $newKana, PDO::PARAM_STR);
            $stmt->bindValue(':mail', $newMail, PDO::PARAM_STR);
            $stmt->bindValue(':tel', $newTel, PDO::PARAM_STR);
            $stmt->bindValue(':birthday', $newBirthday, PDO::PARAM_STR);
            $stmt->bindValue(':types', $newTypes, PDO::PARAM_STR);
            $stmt->bindValue(':techo', $newTecho, PDO::PARAM_STR);
            $stmt->bindValue(':info', $newInfo, PDO::PARAM_STR);
            $stmt->bindValue(':zipcode', $newZipcode, PDO::PARAM_STR);
            $stmt->bindValue(':address1', $newAddress1, PDO::PARAM_STR);
            $stmt->bindValue(':address2', $newAddress2, PDO::PARAM_STR);
            $stmt->bindValue(':address3', $newAddress3, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $hashedPass, PDO::PARAM_STR);
            $stmt->bindValue(':oldMail', $mail, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['mail'] = $newMail; // Update the session email
            $mail = $newMail; // Update the local email variable
            $msg = '登録を更新しました。';
        } else {
            $msg = 'パスワードが間違っています。';
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
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
                <?php if (!empty($msg)) { echo '<div class="alert alert-danger">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>'; } ?>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="name">名前：</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userData['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="kana">カナ：</label>
                                <input type="text" class="form-control" id="kana" name="kana" value="<?php echo htmlspecialchars($userData['kana'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mail">Eメール：</label>
                                <input type="email" class="form-control" id="mail" name="mail" value="<?php echo htmlspecialchars($userData['mail'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="tel">電話：</label>
                                <input type="number" class="form-control" id="tel" name="tel" value="<?php echo htmlspecialchars($userData['tel'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="birthday">誕生日：</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($userData['birthday'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="types">タイプ：</label>
                                <input type="text" class="form-control" id="types" name="types" value="<?php echo htmlspecialchars($userData['types'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="techo">手帳：</label>
                                <input type="text" class="form-control" id="techo" name="techo" value="<?php echo htmlspecialchars($userData['techo'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="info">情報：</label>
                                <input type="text" class="form-control" id="info" name="info" value="<?php echo htmlspecialchars($userData['info'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="zipcode">郵便番号：</label>
                                <input type="number" class="form-control" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($userData['zipcode'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address1">住所1：</label>
                                <input type="text" class="form-control" id="address1" name="address1" value="<?php echo htmlspecialchars($userData['address1'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address2">住所2：</label>
                                <input type="text" class="form-control" id="address2" name="address2" value="<?php echo htmlspecialchars($userData['address2'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address3">住所3：</label>
                                <input type="text" class="form-control" id="address3" name="address3" value="<?php echo htmlspecialchars($userData['address3'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="pass">パスワード：</label>
                            <input type="password" class="form-control" id="pass" name="pass" required>
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
