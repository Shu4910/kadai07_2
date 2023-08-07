<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Details</title>
    <style>
        .list-group-item-action:hover {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-3">User Details</h1>
        <?php
        
        require '../../dbconfig.php'; // require.phpファイルを2つ上の階層から読み込み
        session_start(); // セッションを開始

        
        // $conn = new mysqli($servername, $username, $password, $dbname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        
        // $mail = $_SESSION['mail']; // セッションからメールアドレスを取得 変わらない　
        
        // $sql_company = "SELECT city FROM bizdiverse_company WHERE mail = '$mail'";
        // $result_company = $conn->query($sql_company);
        

        

        require '../../dbconfig2.php';
        try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
        }


        $mail = $_SESSION['mail']; // セッションからメールアドレスを取得 変わらない　

        $mail = $_SESSION['mail']; 

        $stmt = $pdo->prepare("SELECT work, jigyousho, city FROM bizdiverse_company WHERE mail = :mail");
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();

        $result_company = $stmt->fetchAll(PDO::FETCH_ASSOC);


        ?>


        <ul class="list-group">
        <!-- <?php
        if ($result_company->num_rows > 0) {
            $row_company = $result_company->fetch_assoc();
            $cities = explode(',', $row_company["city"]); // Split cities by comma

            foreach ($cities as $city) {
                // Trim spaces
                $city = trim($city);

                // Get users from bizdiverse_user that their city matches with $city
                $sql = "SELECT * FROM bizdiverse_user WHERE city LIKE '%$city%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<a href='details.php?id=".$row["id"]."' class='list-group-item list-group-item-action'>id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["mail"]. " - City: " . $row["city"]. "</a>";
                    }
                } else {
                    echo "<li class='list-group-item'>0 results for city: " . $city . "</li>";
                }
            }
        } else {
            echo "<li class='list-group-item'>No city found in bizdiverse_company with mail: " . $mail . "</li>";
        }
        ?> -->

<?php      
if (count($result_company) > 0) {
    $uniqueResults = []; // Array to store unique results
    $noResultFlag = false; // Flag to indicate if there are any results
    foreach ($result_company as $row_company) {
        $cities = explode(',', $row_company["city"]); // Split cities by comma
        $works = explode(',', $row_company["work"]); // Split works by comma
        $jigyoushos = explode(',', $row_company["jigyousho"]); // Split jigyoushos by comma 

        // Process for each city, work, and jigyousho
        foreach ($cities as $city) {
            foreach ($works as $work) {
                foreach ($jigyoushos as $jigyousho) {
                    $city = trim($city);
                    $work = trim($work);
                    $jigyousho = trim($jigyousho);

                    // Get users from bizdiverse_user that their city, work and jigyousho matches
                    $stmt = $pdo->prepare("SELECT * FROM bizdiverse_user WHERE city LIKE :city AND work LIKE :work AND jigyousho LIKE :jigyousho");
                    $stmt->bindValue(':city', '%'.$city.'%', PDO::PARAM_STR);
                    $stmt->bindValue(':work', '%'.$work.'%', PDO::PARAM_STR);
                    $stmt->bindValue(':jigyousho', '%'.$jigyousho.'%', PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        $noResultFlag = true; // There are results, set flag to true
                        // output data of each row
                        foreach ($result as $row) {
                            // If the id does not exist in the uniqueResults array
                            if (!array_key_exists($row['id'], $uniqueResults)) {
                                $uniqueResults[$row['id']] = $row; // Add the row to the uniqueResults array
                                echo "<a href='details.php?id=".$row["id"]."' class='list-group-item list-group-item-action'>id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["mail"]. " - City: " . $row["city"]. " - Work: " . $row["work"]. " - Jigyousho: " . $row["jigyousho"]. "</a>";
                            }
                        }
                    }
                }
            }
        }
    }
    if ($noResultFlag === false) { // If no results were found for all cities, works, and jigyoushos
        echo "<li class='list-group-item'>0 results</li>";
    }
} else {
    echo "<li class='list-group-item'>No attributes found in bizdiverse_company with mail: " . $mail . "</li>";
}
?>







        </ul>

        <button class="btn btn-primary my-3" onclick="location.href='dash_com.php'">Back</button>

    </div>
</body>
</html>
