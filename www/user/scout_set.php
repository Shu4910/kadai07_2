<?php
session_start(); // セッションを開始

require '../../database.php';


$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

$prefectureOptions = [
    "" => "選択してください",
    "東京都" => "東京都",
    "神奈川県" => "神奈川県",
    "埼玉県" => "埼玉県"
    // 他の都道府県もここに追加
];

$prefectureCityMapping = [
    "東京都" => [
        "千代田区" => "千代田区",
        "港区" => "港区",
    ],
    "神奈川県" => [
        "八王子" => "八王子",
        "立川市" => "立川市"
    ],
    "埼玉県" => [
        "pu" => "pu",
        "pi" => "pi"
    ],
    // 他の都道府県と都市のマッピングもここに追加
];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        header('Location: dash.php');
        exit;
    }

    if (isset($_POST['update'])) {
        // All the other form fields
        $newMail = empty($_POST['mail']) ? $mail : $_POST['mail']; // Check if the new email is empty
        $newPass = $_POST['pass'];
        $prefecture = $_POST['prefecture'];
        // $area = $_POST['area'];
        $cities = is_array($_POST['city']) ? implode(",", $_POST['city']) : $_POST['city'];

        
        // 既存のパスワードの取得
        $stmt = $pdo->prepare("SELECT pass FROM bizdiverse_user WHERE mail = :mail");
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        $existingPass = $stmt->fetchColumn();

        // 既存のパスワードと新しいパスワードが一致するかチェック
        if (password_verify($newPass, $existingPass)) {
            // パスワードをハッシュ化
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

                // ここでDBへの更新処理を追加
    $updateStmt = $pdo->prepare("
    UPDATE bizdiverse_user 
    SET mail = :newMail, pass = :hashedPass, prefecture = :prefecture, city = :cities 
    WHERE mail = :mail
");
$updateStmt->bindValue(':newMail', $newMail, PDO::PARAM_STR);
$updateStmt->bindValue(':hashedPass', $hashedPass, PDO::PARAM_STR);
$updateStmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
$updateStmt->bindValue(':cities', $cities, PDO::PARAM_STR);
$updateStmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$updateStmt->execute();

            $_SESSION['mail'] = $newMail; // Update the session email
            $mail = $newMail; // Update the local email variable
            $msg = '登録を更新しました。';
        } else {
            $msg = 'パスワードが間違っています。';
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_user WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>都道府県と市区町村の選択</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                        <!-- <div class="form-group">
                            <label for="mail">Eメール：</label>
                            <input type="email" class="form-control" id="mail" name="mail" value="<?php echo htmlspecialchars($userData['mail'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div> -->
                        <div class="form-group">
                            <label for="pass">パスワード：</label>
                            <input type="password" class="form-control" id="pass" name="pass" required>
                        </div>
                        <div class="form-group">
                            <label for="prefecture">都道府県:</label>
                            <select class="form-control" id="prefecture" name="prefecture">
                                <?php
                                foreach ($prefectureOptions as $value => $label) {
                                    $selected = ($userData['prefecture'] === $value) ? 'selected' : '';
                                    echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="area">エリア:</label>
                            <select class="form-control" id="area" name="area">
                                <?php
                                foreach ($areaOptions as $value => $label) {
                                    $selected = ($userData['area'] === $value) ? 'selected' : '';
                                    echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <p>都市選択:</p>
                            <div id="city">
                                <?php
                                $selectedCities = explode(',', $userData['city']);
                                // foreach ($prefectureCityMapping as $value => $label) {
                                //     $checked = in_array($value, $selectedCities) ? 'checked' : '';
                                //     echo '<input type="checkbox" id="' . $value . '" name="city[]" value="' . $value . '" ' . $checked . '>
                                //     <label for="' . $value . '">' . $label . '</label><br>';
                                // }
                                foreach ($prefectureCityMapping as $prefecture => $cities) {
                                    foreach ($cities as $cityValue => $cityLabel) {
                                        $checked = in_array($cityValue, $selectedCities) ? 'checked' : '';
                                        echo '<input type="checkbox" id="' . $cityValue . '" name="city[]" value="' . $cityValue . '" ' . $checked . '>
                                        <label for="' . $cityValue . '">' . $cityLabel . '</label><br>';
                                    }
                                }

                                ?>
                            </div>
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

<script>
$(document).ready(function(){
    
    // 都道府県に基づく都市の情報を更新する関数
    function updateCityOptions() {
        var prefecture = $('#prefecture').val();

        // 既に選択されている都市を取得
        var selectedCities = [];
        $('input[name="city[]"]:checked').each(function(){
            selectedCities.push($(this).val());
        });

        var cityOptions = '';
        switch (prefecture) {
            case "東京都":
                <?php
                foreach ($prefectureCityMapping["東京都"] as $city => $label) {
                    echo "cityOptions += '<input type=\"checkbox\" id=\"" . $city . "\" name=\"city[]\" value=\"" . $city . "\" ' + (selectedCities.includes('" . $city . "') ? 'checked' : '') + '> <label for=\"" . $city . "\">" . $label . "</label><br>';\n";
                }
                ?>
                break;
            case '神奈川県':
                <?php
                foreach ($prefectureCityMapping['神奈川県'] as $city => $label) {
                    echo "cityOptions += '<input type=\"checkbox\" id=\"" . $city . "\" name=\"city[]\" value=\"" . $city . "\" ' + (selectedCities.includes('" . $city . "') ? 'checked' : '') + '> <label for=\"" . $city . "\">" . $label . "</label><br>';\n";
                }
                ?>
                break;

            case '埼玉県':
                <?php
                foreach ($prefectureCityMapping['埼玉県'] as $city => $label) {
                    echo "cityOptions += '<input type=\"checkbox\" id=\"" . $city . "\" name=\"city[]\" value=\"" . $city . "\" ' + (selectedCities.includes('" . $city . "') ? 'checked' : '') + '> <label for=\"" . $city . "\">" . $label . "</label><br>';\n";
                }
                ?>
                break;


            // 他の都道府県の場合もここに追加
            default:
                cityOptions = ''; // 何も選択されていない場合は都市のオプションを空にする
                break;
        }
        $('#city').html(cityOptions);
    }
    
    // 都道府県が変更されたときのイベントハンドラ
    $('#prefecture').change(function(){
        updateCityOptions();
    });
    
    // ページが読み込まれたときに関数を呼び出して都市の情報を初期化
    updateCityOptions();
});


</script>

</body>
</html>
