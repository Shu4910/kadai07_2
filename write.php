<?php

$name = $_POST["name"];
$kana = $_POST["kana"];
$mail = $_POST["mail"];
$tel = $_POST["tel"];
$birthday = $_POST["birthday"];
$type = $_POST["types"];
$techo = $_POST["techo"];
$info = $_POST["info"];
$zipcode = $_POST["zipcode"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$address3 = $_POST["address3"];

$data = $name . "," . $kana . "," . $mail ."," . $tel .  "," . $birthday . "," . $type. "," .  $techo. "," .  $info. "," . $zipcode. "," . $address1. "," . $address2. "," . $address3 . "\n";

$file_path = "data/data.csv";
$existing_data = file_get_contents($file_path);

$lines = explode("\n", $existing_data);
$found = false;

// 電話番号またはメールアドレスが既に存在する場合にデータを置き換える
foreach ($lines as &$line) {
    $fields = explode(",", $line);
    if ($fields[2] === $mail || $fields[3] === $tel) {
        $line = $data;
        $found = true;
        break;
    }
}

$updated_data = implode("\n", $lines);
file_put_contents($file_path, $updated_data);

if ($found) {
    $message = "データを置き換えました。";
} else {
    $message = "書き込みしました。";
}

?>

<html>

<head>
    <meta charset="utf-8">
    <title>File書き込み</title>
</head>

<body>

    <h1><?php echo $message; ?></h1>
    <h2>./data/data.csv を確認しましょう！</h2>

    <ul>
        <li><a href="read.php">確認する</a></li>
        <li><a href="input.php">戻る</a></li>
    </ul>
</body>

</html>
