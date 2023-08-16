<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>会員検索</title>
    <style>
        .list-group-item-action:hover {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-3">会員検索</h1>
        <?php
        
        require '../../dbconfig.php'; 
        session_start(); 
        require '../../dbconfig2.php';
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        $mail = $_SESSION['mail'];
        $stmt = $pdo->prepare("SELECT work, jigyousho, city FROM bizdiverse_company WHERE mail = :mail");
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();

        $result_company = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <ul class="list-group">
<?php      
if (count($result_company) > 0) {
    $uniqueResults = [];
    $noResultFlag = false;
    foreach ($result_company as $row_company) {
        $cities = explode(',', $row_company["city"]);
        $works = explode(',', $row_company["work"]);
        $jigyoushos = explode(',', $row_company["jigyousho"]);

        foreach ($cities as $city) {
            foreach ($works as $work) {
                foreach ($jigyoushos as $jigyousho) {
                    $city = trim($city);
                    $work = trim($work);
                    $jigyousho = trim($jigyousho);

                    $stmt = $pdo->prepare("SELECT * FROM bizdiverse_user WHERE city LIKE :city AND work LIKE :work AND jigyousho LIKE :jigyousho");
                    $stmt->bindValue(':city', '%'.$city.'%', PDO::PARAM_STR);
                    $stmt->bindValue(':work', '%'.$work.'%', PDO::PARAM_STR);
                    $stmt->bindValue(':jigyousho', '%'.$jigyousho.'%', PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        $noResultFlag = true; 
                        foreach ($result as $row) {
                            if (!array_key_exists($row['id'], $uniqueResults)) {
                                $uniqueResults[$row['id']] = $row;
                                echo "<a href='details.php?id=".$row["id"]."' class='list-group-item list-group-item-action'>ニックネーム：" . $row["kana"]. " <br> エリア：" . $row["city"]. " <br> 希望職種・こだわり条件：" . $row["work"]. " <br> 施設条件：" . $row["jigyousho"]. "</a>";
                            }
                        }
                    }
                }
            }
        }
    }
    if ($noResultFlag === false) {
        echo "<li class='list-group-item'>0 results</li>";
    }
} else {
    echo "<li class='list-group-item'>No attributes found in bizdiverse_company with mail: " . $mail . "</li>";
}
?>
        </ul>
        <button class="btn btn-primary my-3" onclick="location.href='dash_com.php'">Back</button>
    </div>

<footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>
</body>
</html>
