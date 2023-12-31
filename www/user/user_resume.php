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
        $newMail = $_POST['mail'];
        $newContent = $_POST['content'];

        $canUpdate = false;

        // If password is provided, verify it
        if (!empty($newPass)) {
            // DBの現在のパスワードを取得
            $stmt = $pdo->prepare("SELECT pass FROM bizdiverse_user WHERE mail = :mail");
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
            $currentPass = $stmt->fetchColumn();

            // 入力されたパスワードがDBのパスワードと一致する場合
            if (password_verify($newPass, $currentPass)) {
                $canUpdate = true;
            } else {
                $msg = 'パスワードが間違っています。';
            }
        } else {
            // No password provided, just update
            $canUpdate = true;
        }

        if ($canUpdate) {
            // Prepare the update statement with all the fields
            $stmt = $pdo->prepare("UPDATE bizdiverse_user SET mail = :newMail, content = :content WHERE mail = :mail");
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindValue(':newMail', $newMail, PDO::PARAM_STR);
            $stmt->bindValue(':content', $newContent, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['mail'] = $newMail; // Update the session email
            $mail = $newMail; // Update the local email variable
            $msg = '登録を更新しました。';
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_user WHERE mail = :mail");
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

    <title>レジュメ</title>
</head>
<body>

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">レジュメ</h2>
                <?php if (!empty($msg)) { echo '<div class="alert alert-danger">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>'; } ?>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                                <input type="hidden" name="mail" value="<?php echo htmlspecialchars($userData['mail'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="form-group">
                <label for="content">内容:</label>
                <textarea class="form-control" id="content" name="content" style="height: 300px;" required><?php echo htmlspecialchars($userData['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
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
        <!-- フッターにサービス名を追加 -->
<footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
