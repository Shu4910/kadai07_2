<?php
session_start();

try {
    //pass:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=bizdiverse_user;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {

    exit('DBConnectError'.$e->getMessage());
}

$mail = $_SESSION['mail']; // セッションからメールアドレスを取得
$msg = '';
    

require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $db;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        // PDOを使ってDBに接続
        $this->db = new PDO('mysql:dbname=bizdiverse_user;charset=utf8;host=localhost', 'root', '');
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        // DBから過去のメッセージを取得し、新たに接続したクライアントに送信
        $stmt = $this->db->query("SELECT * FROM `chats` ORDER BY created_at ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $message = $row['content'];
            $conn->send($message);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }

        // メッセージと送信者情報をDBに保存
        $stmt = $this->db->prepare("INSERT INTO `chats` (content, sender) VALUES (:content, :sender)");
        $stmt->bindValue(':content', $msg, PDO::PARAM_STR);
        $stmt->bindValue(':sender', $from->resourceId, PDO::PARAM_STR);
        $stmt->execute();
    }
}

$server = Ratchet\Server\IoServer::factory(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();
