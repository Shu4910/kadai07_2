<?php
session_start(); // セッションを開始

require 'database.php'; // データベース接続のスクリプト

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
        $newPass = $_POST['pass'];
        $prefecture = $_POST['prefecture'];
        $area = $_POST['area'];
        $newPass = $_POST['pass'];
        $confirmPass = $_POST['confirm_pass'];
        $cities = is_array($_POST['city']) ? implode(",", $_POST['city']) : $_POST['city'];


        

        if ($newPass === $confirmPass) {
            // パスワードをハッシュ化
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

            // Prepare the update statement with all the fields
            $stmt = $pdo->prepare("UPDATE bizdiverse SET mail = :mail, pass = :pass, prefecture = :prefecture, area = :area, city = :city WHERE mail = :oldMail");
            $stmt->bindValue(':mail', $newMail, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $hashedPass, PDO::PARAM_STR);
            $stmt->bindValue(':oldMail', $mail, PDO::PARAM_STR);
            $stmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
            $stmt->bindValue(':area', $area, PDO::PARAM_STR);
            $stmt->bindValue(':city', $cities, PDO::PARAM_STR);
            $stmt->execute();
            

            $_SESSION['mail'] = $newMail; // Update the session email
            $mail = $newMail; // Update the local email variable
            $msg = '登録を更新しました。';
        } else {
            $msg = 'パスワードが一致しません。';
        }
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
    <title>都道府県と市区町村の選択</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="form.js"></script>
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
                                <label for="mail">Eメール：</label>
                                <input type="email" class="form-control" id="mail" name="mail" value="<?php echo htmlspecialchars($userData['mail'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">パスワード：</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_pass">パスワード確認：</label>
                                <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" required>
                            </div>
                            <div class="form-group">
            <label for="prefecture">都道府県:</label>
            <select class="form-control" id="prefecture" name="prefecture">
                <option value="">選択してください</option>
                <option value="tokyo">東京都</option>
                <option value="kanagawa">神奈川県</option>
                <option value="saitama">埼玉県</option>
            </select>
        </div>
        <div class="form-group">
        <select class="form-control" id="area" name="area">
                <option value="">選択してください</option>
            </select>
        </div>


        <div class="form-group">
    <p>都市選択:</p>
    <div id="city">
        <!-- Default option is blank. Update this with JS -->
    </div>
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

<script>
$(document).ready(function(){
    $('#prefecture').change(function(){
        var prefecture = $(this).val();
        if(prefecture == 'tokyo'){
            $('#area').html('<option value="">選択してください</option><option value="inside">23区内</option><option value="outside">23区外</option>');
        } else {
            $('#area').html('<option value="">選択してください</option>');
        }
    });
    $('#area').change(function(){
    var area = $(this).val();
    var cityOptions = '';
    if(area == 'inside'){
        cityOptions = '<input type="checkbox" id="chiyoda" name="city[]" value="chiyoda"> <label for="chiyoda">千代田区</label><br>' +
                      '<input type="checkbox" id="minato" name="city[]" value="minato"> <label for="minato">港区</label><br>' //+ ... 東京23区の全ての区をここにリストアップしてください
    } 
    else if(area == 'outside'){
        cityOptions = '<input type="checkbox" id="hachi" name="city[]" value="hachi"> <label for="hachi">八王子</label><br>' +
                      '<input type="checkbox" id="minato" name="city[]" value="minato"> <label for="minato">港区</label><br>' //+ ... 東京23区の全ての区をここにリストアップしてください
    } 
    else {
        cityOptions = '';
    }
    $('#city').html(cityOptions);
});

});




</script>


</body>
</html>