<?php
// 1. POSTデータ取得
$name = $_POST["name"];
$kana = $_POST["kana"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$birthday = $_POST["birthday"];
$types = $_POST["types"];
$techo = $_POST["techo"];
$info = $_POST["info"];
$zipcode = $_POST["zipcode"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$address3 = $_POST["address3"];
$pass = $_POST["pass"];
$confirm_pass = $_POST["confirm_pass"]; // 追加

$pass = password_hash($pass, PASSWORD_DEFAULT);

// 2. DB接続
require "../database.php";


// メール送信に必要なライブラリをロード
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$checkStmt = $pdo->prepare("SELECT * FROM bizdiverse_user WHERE mail = :mail OR tel = :tel");
$checkStmt->execute(['mail' => $email, 'tel' => $tel]);
$exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

if ($exists) {
    // Record exists, update it
    $stmt = $pdo->prepare("UPDATE bizdiverse_user 
                           SET name = :name, kana = :kana, mail = :mail, tel = :tel, 
                               birthday = :birthday, types = :types, techo = :techo, 
                               info = :info, zipcode = :zipcode, address1 = :address1, 
                               address2 = :address2, address3 = :address3, pass = :pass 
                           WHERE id = :id");
    $stmt->bindValue(':id', $exists['id'], PDO::PARAM_INT);
} else {
    // Record does not exist, insert new one
    $stmt = $pdo->prepare("INSERT INTO bizdiverse_user
                            (name, kana, mail, tel, birthday, types, techo, info, zipcode, address1, address2, address3, pass)
                           VALUES
                            (:name, :kana, :mail, :tel, :birthday, :types, :techo, :info, :zipcode, :address1, :address2, :address3, :pass)");
}

// Bind variables
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
$stmt->bindValue(':mail', $email, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':types', $types, PDO::PARAM_STR);
$stmt->bindValue(':techo', $techo, PDO::PARAM_STR);
$stmt->bindValue(':info', $info, PDO::PARAM_STR);
$stmt->bindValue(':zipcode', $zipcode, PDO::PARAM_INT);
$stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
$stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
$stmt->bindValue(':address3', $address3, PDO::PARAM_STR);
$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);

// Execute
$status = $stmt->execute();

if ($status === false) {
    // Error during SQL execution (get and display error object)
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    // ここからメール送信処理
    $mailer = new PHPMailer();
    $mailer->isSMTP();
    $mailer->Host = $_ENV['SMTP_HOST'];
    $mailer->Port = $_ENV['SMTP_PORT'];
    $mailer->SMTPAuth = true;
    $mailer->Username = $_ENV['SMTP_USER'];
    $mailer->Password = $_ENV['SMTP_PASS'];

    $mailer->setFrom('postmaster@komaki0910.sakura.ne.jp', 'テスト');
    $mailer->addAddress($email); // 1つ目のコードから$emailを使用

    $mailer->CharSet = 'UTF-8';  // 追加: 文字エンコーディングの設定
    $mailer->Subject = '=?UTF-8?B?' . base64_encode('登録完了のお知らせ') . '?=';  // 修正: 件名のエンコード
    $mailer->isHTML(true);
    $mailer->Body = '登録が完了しました。<br>
    ありがとうございます。登録が完了しました! 下記のURLからログインできます。<br>
    https://komaki0910.sakura.ne.jp/user/index_user.php?<br>
    ログイン後にエリア、こだわり条件は必ず設定してください。※レジュメ登録は任意です。<br>
    
    精神障害者に特化したスカウトメディアサービス BizDiverse';

    if (!$mailer->send()) {
        echo 'メールの送信に失敗しました。エラー: ' . $mailer->ErrorInfo;
        exit;
    }
    
    // メール送信後のリダイレクト処理
    header('Location: user/index_user.php');
    exit;
}
?>

<html>

<head>
    <meta charset="utf8_unicode_ci">
    <title>File書き込み</title>
</head>

</html>

</html>
