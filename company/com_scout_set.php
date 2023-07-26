<?php
session_start(); // セッションを開始
require '../database.php';


$com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        header('Location: dash_com.php');
        exit;
    }

    if (isset($_POST['update'])) {
        // All the other form fields
        $newMail = $_POST['com_email'];
        $prefecture = $_POST['prefecture'];
        $area = $_POST['area'];
        $cities = isset($_POST['city']) ? (is_array($_POST['city']) ? implode(",", $_POST['city']) : $_POST['city']) : '';

        // Prepare the update statement with all the fields
        $stmt = $pdo->prepare("UPDATE bizdiverse_company SET com_email = :com_email, prefecture = :prefecture, area = :area, city = :city WHERE com_email = :oldMail");
        $stmt->bindValue(':com_email', $newMail, PDO::PARAM_STR);
        $stmt->bindValue(':oldMail', $com_email, PDO::PARAM_STR);
        $stmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
        $stmt->bindValue(':area', $area, PDO::PARAM_STR);
        $stmt->bindValue(':city', $cities, PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['com_email'] = $newMail; // Update the session email
        $com_email = $newMail; // Update the local email variable
        $msg = '登録を更新しました。';
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE com_email = :com_email");
$stmt->bindValue(':com_email', $com_email, PDO::PARAM_STR);
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
                                <label for="com_email">Eメール：</label>
                                <input type="email" class="form-control" id="com_email" name="com_email" value="<?php echo htmlspecialchars($userData['com_email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="form-group">
    <label for="prefecture">都道府県:</label>
    <select class="form-control" id="prefecture" name="prefecture" required>
        <option value="">選択してください</option>
        <option value="tokyo" <?php if($userData['prefecture'] == "tokyo") echo "selected";?>>東京都</option>
        <option value="kanagawa" <?php if($userData['prefecture'] == "kanagawa") echo "selected";?>>神奈川県</option>
        <option value="saitama" <?php if($userData['prefecture'] == "saitama") echo "selected";?>>埼玉県</option>
        <!-- 他の都道府県もここに追加 -->
    </select>
</div>

<div class="form-group">
    <label for="area">エリア:</label>
    <select class="form-control" id="area" name="area" required>
        <option value="">選択してください</option>
        <option value="inside" <?php if($userData['area'] == "inside") echo "selected";?>>23区内</option>
        <option value="outside" <?php if($userData['area'] == "outside") echo "selected";?>>23区外</option>
        <!-- 他のエリアもここに追加 -->
    </select>
</div>
<div class="form-group">
    <p>都市選択:</p>
    <div id="city">
        <!-- PHPで都市のチェックボックスを動的に生成 -->
        <?php
        $cities = explode(',', $userData['city']);
        $cityMappings = [
            "chiyoda" => "千代田区",
            "minato" => "港区",
            "hachi" => "八王子市",
            "tachi" => "立川市",
            // 他の都市もこの形式で追加していきます
        ];
        foreach ($cities as $city) {
            echo '<input type="checkbox" id="'.$city.'" name="city[]" value="'.$city.'" checked> <label for="'.$city.'">'.$cityMappings[$city].'</label><br>';
        }
        ?>
    </div>
</div>


</div>



                            <button type="submit" name="update" class="btn btn-primary btn-block">更新</button>
                        </form>
                        <form method="POST" style="margin-top: 10px;">
                            <button type="submit" name="logout" class="btn btn-secondary btn-block">ホーム画面に戻る</button>
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
                      '<input type="checkbox" id="tachi" name="city[]" value="tachi"> <label for="minato">立川市</label><br>' //+ ... 東京23区の全ての区をここにリストアップしてください
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