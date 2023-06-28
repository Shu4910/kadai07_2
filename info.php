<?php
session_start(); // セッションを開始

require 'database.php'; // データベース接続のスクリプト

$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newName = $_POST['name'];
    $newMail = $_POST['mail'];
    $newPass = $_POST['pass'];
    $confirmPass = $_POST['confirm_pass'];

    if ($newPass === $confirmPass) {
        $stmt = $pdo->prepare("UPDATE bizdiverse SET name = :name, mail = :mail, pass = :pass WHERE mail = :oldMail");
        $stmt->bindValue(':name', $newName, PDO::PARAM_STR);
        $stmt->bindValue(':mail', $newMail, PDO::PARAM_STR);
        $stmt->bindValue(':pass', $newPass, PDO::PARAM_STR);
        $stmt->bindValue(':oldMail', $mail, PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['mail'] = $newMail; // Update the session email
        $mail = $newMail; // Update the local email variable
        $msg = '登録を更新しました。';
    } else {
        $msg = 'パスワードが一致しません。';
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>登録情報</title>
</head>
<body>
    <?php if (!empty($msg)) { echo '<p style="color:red;">' . $msg . '</p>'; } ?>
    <form method="POST">
        <label>名前：</label><input type="text" name="name" value="<?php echo $userData['name']; ?>"><br>
        <label>Eメール：</label><input type="email" name="mail" value="<?php echo $userData['mail']; ?>"><br>
        <label>パスワード：</label><input type="password" name="pass" value="<?php echo $userData['pass']; ?>"><br>
        <label>パスワード確認：</label><input type="password" name="confirm_pass"><br>
        <input type="submit" value="更新">
    </form>
</body>
</html>
