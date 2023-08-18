<?php
session_start(); // セッションを開始
require '../../database.php';


$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';


$typesHandiOptions = [
    "" => "選択してください",
    "精神" => "精神",
    "発達" => "発達",
    "身体" => "身体",
    "その他" => "その他"
];

$techoOptions = [
    "" => "選択してください",
    "申請中" => "申請中",
    "有り" => "有り",
    "無し" => "無し"
];

$techoNumOptions = [
    "" => "選択してください",
    "1級" => "1級",
    "2級" => "2級",
    "3級" => "3級",
    "4級" => "4級",
    "5級" => "5級",
    "6級" => "6級",
    "軽度" => "軽度",
    "中度" => "中度",
    "重度" => "重度",
    "最重度" => "最重度"
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        header('Location: dash_com.php');
        exit;
    }

    if (isset($_POST['update'])) {
        // All the other form fields
        $newMail = empty($_POST['mail']) ? $mail : $_POST['mail']; // Check if the new email is empty
 
        $types_handi = $_POST['types_handi'];
        $techo = $_POST['techo'];
        $techo_num = $_POST['techo_num'];

        // Prepare the update statement with all the fields
        $stmt = $pdo->prepare("UPDATE bizdiverse_company 
        SET mail = :mail, types_handi = :types_handi, techo = :techo, techo_num = :techo_num 
        WHERE mail = :oldMail");
        $stmt->bindValue(':mail', $newMail, PDO::PARAM_STR);
        $stmt->bindValue(':oldMail', $mail, PDO::PARAM_STR);
        $stmt->bindValue(':types_handi', $types_handi, PDO::PARAM_STR);
        $stmt->bindValue(':techo', $techo, PDO::PARAM_STR);
        $stmt->bindValue(':techo_num', $techo_num, PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['mail'] = $newMail; // Update the session email
        $mail = $newMail; // Update the local email variable
        $msg = '登録を更新しました。';
    }
}

$stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>






<!DOCTYPE html>
<html>
<head>
    <title>エリア設定</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="form.js"></script>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h2 class="text-center mb-4">エリア設定</h2>
            <?php if (!empty($msg)) { echo '<div class="alert alert-danger">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>'; } ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST">

                    <div class="form-group">
                            <label for="types_handi">障害種別:</label>
                            <select class="form-control" id="types_handi" name="types_handi">
                                <?php
                                foreach ($typesHandiOptions as $value => $label) {
                                    $selected = ($userData['types_handi'] === $value) ? 'selected' : '';
                                    echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="techo">手帳:</label>
                            <select class="form-control" id="techo" name="techo">
                                <?php
                                foreach ($techoOptions as $value => $label) {
                                    $selected = ($userData['techo'] === $value) ? 'selected' : '';
                                    echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="techo_num">手帳の等級:</label>
                            <select class="form-control" id="techo_num" name="techo_num">
                                <?php
                                foreach ($techoNumOptions as $value => $label) {
                                    $selected = ($userData['techo_num'] === $value) ? 'selected' : '';
                                    echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
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