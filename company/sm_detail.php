<?php
session_start(); // セッションを開始

if (isset($_POST['session_id']) && isset($_POST['message_body']) && isset($_POST['user_send_id']) && isset($_POST['company_send_id'])) {
    $session_id = $_POST['session_id'];
    $message_body = $_POST['message_body'];
    $user_send_id = $_POST['user_send_id'];
    $company_send_id = $_POST['company_send_id'];
    $sender_type = $_POST['sender_type'];
    

    $dbh = new PDO('mysql:dbname=bizdiverse;charset=utf8;host=localhost', 'root', '');

    // SQLを準備
    $sql = "INSERT INTO messages (session_id, user_send_id, company_send_id, message_body, send_at,sender_type) VALUES (:session_id, :user_send_id, :company_send_id, :message_body, NOW(),:sender_type)";

    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':user_send_id', $user_send_id);
    $stmt->bindParam(':company_send_id', $company_send_id);
    $stmt->bindParam(':message_body', $message_body);
    $stmt->bindParam(':sender_type', $sender_type);
    
    $stmt->execute();





    header("Location: message_details.php?session_id=$session_id");
} else {
    echo "No session_id or message_body or sender_id specified.";
}
?>
