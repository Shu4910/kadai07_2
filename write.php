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
require "database.php";

// Check if record exists
$checkStmt = $pdo->prepare("SELECT * FROM bizdiverse WHERE mail = :mail OR tel = :tel");
$checkStmt->execute(['mail' => $email, 'tel' => $tel]);
$exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

if ($exists) {
    // Record exists, update it
    $stmt = $pdo->prepare("UPDATE bizdiverse 
                           SET name = :name, kana = :kana, mail = :mail, tel = :tel, 
                               birthday = :birthday, types = :types, techo = :techo, 
                               info = :info, zipcode = :zipcode, address1 = :address1, 
                               address2 = :address2, address3 = :address3, pass = :pass 
                           WHERE id = :id");
    $stmt->bindValue(':id', $exists['id'], PDO::PARAM_INT);
} else {
    // Record does not exist, insert new one
    $stmt = $pdo->prepare("INSERT INTO bizdiverse
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

// Data registration process after
if ($status === false) {
    // Error during SQL execution (get and display error object)
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    // Redirect to index2.php
    header('Location: index2.php');
    exit;
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title>File書き込み</title>
</head>

</html>
