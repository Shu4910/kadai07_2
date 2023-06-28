<?php

//1. POSTデータ取得 ここは同じ
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

$pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);


//2. DB接続します
require "database.php";


// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO
                        bizdiverse(id, name, kana, email, tel, birthday, types, techo, info, zipcode, address1, address2, address3, pass)
                        VALUES (
                        NULL, :name, :kana, :email, :tel, :birthday, :types, :techo, :info, :zipcode, :address1, :address2, :address3,:pass)");


//  2. バインド変数を用意
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':types', $types, PDO::PARAM_STR);
$stmt->bindValue(':techo', $techo, PDO::PARAM_STR);
$stmt->bindValue(':info', $info, PDO::PARAM_STR);
$stmt->bindValue(':zipcode', $zipcode, PDO::PARAM_STR);
$stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
$stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
$stmt->bindValue(':address3', $address3, PDO::PARAM_STR);
$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);


//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    //５．index.phpへリダイレクト
    echo "<script type='text/javascript'>alert('登録が完了しました。'); location.href='index.php';</script>";
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title>File書き込み</title>
</head>

</html>
