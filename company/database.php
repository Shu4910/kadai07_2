<?php
try {
    //pass:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=bizdiverse;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {

    exit('DBConnectError'.$e->getMessage());
}
?>