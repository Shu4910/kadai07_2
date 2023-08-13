<?php
session_start(); // セッションを開始
require '../../database.php';

$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';

// ユーザデータの取得
$stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$works = !empty($userData['work']) ? explode(',', $userData['work']) : [];
$jigyoushos = !empty($userData['jigyousho']) ? explode(',', $userData['jigyousho']) : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ログアウトが押された場合
    if (isset($_POST['logout'])) {
        header('Location: dash_com.php');
        exit;
    }

    if (isset($_POST['update'])) {
        // All the other form fields
        $newWork = isset($_POST['work']) ? (is_array($_POST['work']) ? implode(',', $_POST['work']) : $_POST['work']) : '';
        $newJigyousho = isset($_POST['jigyousho']) ? (is_array($_POST['jigyousho']) ? implode(',', $_POST['jigyousho']) : $_POST['jigyousho']) : '';

            // Prepare the update statement with all the fields
            $stmt = $pdo->prepare("UPDATE bizdiverse_company SET work = :work, jigyousho = :jigyousho WHERE mail = :oldMail");
            $stmt->bindValue(':work', $newWork, PDO::PARAM_STR);
            $stmt->bindValue(':jigyousho', $newJigyousho, PDO::PARAM_STR);
            $stmt->bindValue(':oldMail', $mail, PDO::PARAM_STR);
            $stmt->execute();
            $msg = '登録を更新しました。';

            $stmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE mail = :mail");
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            $works = !empty($userData['work']) ? explode(',', $userData['work']) : [];
            $jigyoushos = !empty($userData['jigyousho']) ? explode(',', $userData['jigyousho']) : [];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <title>こだわり情報</title>
</head>
<body>

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">こだわり情報</h2>
                <?php if (!empty($msg)) { echo '<div class="alert alert-danger">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>'; } ?>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                            <label for="work">仕事・働く条件：</label><br>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="一般事務" <?php if (in_array('一般事務', $works)) echo 'checked'; ?>> 一般事務</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="WEBデザイナー" <?php if (in_array('WEBデザイナー', $works)) echo 'checked'; ?>> WEBデザイナー</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="ITエンジニア" <?php if (in_array('ITエンジニア', $works)) echo 'checked'; ?>> ITエンジニア</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="DTP・CADオペレーター" <?php if (in_array('DTP・CADオペレーター', $works)) echo 'checked'; ?>> DTP・CADオペレーター般事務</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="清掃・作業系" <?php if (in_array('清掃・作業系', $works)) echo 'checked'; ?>> 清掃・作業系</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="都心で働きたい" <?php if (in_array('都心で働きたい', $works)) echo 'checked'; ?>> 都心で働きたい</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="リモートワークで働きたい" <?php if (in_array('リモートワークで働きたい', $works)) echo 'checked'; ?>> リモートワークで働きたい</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="稼ぎたい" <?php if (in_array('稼ぎたい', $works)) echo 'checked'; ?>> 稼ぎたい</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="キャリアアップしたい" <?php if (in_array('キャリアアップしたい', $works)) echo 'checked'; ?>> キャリアアップしたい</label>
    </div>
    
    <div class="checkbox">
        <label><input type="checkbox" name="work[]" value="ワークライフバランスを重視" <?php if (in_array('ワークライフバランスを重視', $works)) echo 'checked'; ?>> ワークライフバランスを重視</label>
    </div>
    <br>
    <div class="form-group">
    <label for="jigyousho">事業所に求める条件：</label><br>
    <div class="checkbox">
        <label><input type="checkbox" name="jigyousho[]" value="同じ障害種別の通所者が多い" <?php if (in_array('同じ障害種別の通所者が多い', $jigyoushos)) echo 'checked'; ?>> 同じ障害種別の通所者が多い</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="jigyousho[]" value="当事者職員がいる" <?php if (in_array('当事者職員がいる', $jigyoushos)) echo 'checked'; ?>> 当事者職員がいる</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="jigyousho[]" value="在宅トレーニング一部可" <?php if (in_array('在宅トレーニング一部可', $jigyoushos)) echo 'checked'; ?>> 在宅トレーニング一部可</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="jigyousho[]" value="自己理解カリキュラムが充実" <?php if (in_array('自己理解カリキュラムが充実', $jigyoushos)) echo 'checked'; ?>> 自己理解カリキュラムが充実</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="jigyousho[]" value="スキルアップカリキュラムが充実" <?php if (in_array('スキルアップカリキュラムが充実', $jigyoushos)) echo 'checked'; ?>> スキルアップカリキュラムが充実</label>
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
</body>
</html>
