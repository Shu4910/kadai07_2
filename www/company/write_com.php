<?php
// 1. POSTデータ取得
$houjin = $_POST["houjin"];
$tanto = $_POST["tanto"];
$mail = $_POST["mail"];
$tel = $_POST["tel"];
$types_fa = $_POST["types_fa"];
$zipcode = $_POST["zipcode"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$address3 = $_POST["address3"];
$pass = $_POST["pass"];
$confirm_pass = $_POST["confirm_pass"]; // 追加

$pass = password_hash($pass, PASSWORD_DEFAULT);

// 2. DB接続
require '../../database.php'; // require.phpファイルを2つ上の階層から読み込み




// Check if record exists
$checkStmt = $pdo->prepare("SELECT * FROM bizdiverse_company WHERE mail = :mail OR tel = :tel");
$checkStmt->execute(['mail' => $mail, 'tel' => $tel]);
$exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

if ($exists) {
    // Record exists, update it
    $stmt = $pdo->prepare("UPDATE bizdiverse_company
                           SET houjin = :houjin, tanto = :tanto, mail = :mail, tel = :tel, 
                               types_fa = :types_fa, zipcode = :zipcode, address1 = :address1, 
                               address2 = :address2, address3 = :address3, pass = :pass 
                           WHERE company_id = :company_id");
    $stmt->bindValue(':company_id', $exists['company_id'], PDO::PARAM_INT);
} else {
    // Record does not exist, insert new one
    $stmt = $pdo->prepare("INSERT INTO bizdiverse_company
                            (houjin, tanto, mail, tel, types_fa, zipcode, address1, address2, address3, pass)
                           VALUES
                            (:houjin, :tanto, :mail, :tel, :types_fa, :zipcode, :address1, :address2, :address3, :pass)");
}

// Bind variables
$stmt->bindValue(':houjin', $houjin, PDO::PARAM_STR);
$stmt->bindValue(':tanto', $tanto, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':types_fa', $types_fa, PDO::PARAM_STR);
$stmt->bindValue(':zipcode', $zipcode, PDO::PARAM_STR);
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
    header('Location: index_com.php');
    exit;
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title>File書き込み</title>
</head>

</html>
