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

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得

        // Get city from bizdiverse_company with specified mail
        $sql_company = "SELECT city FROM bizdiverse_company WHERE com_email = '$com_email'";
        $result_company = $conn->query($sql_company);
        ?>

        <ul class="list-group">
        <?php
        if ($result_company->num_rows > 0) {
            $row_company = $result_company->fetch_assoc();
            $cities = explode(',', $row_company["city"]); // Split cities by comma

            foreach ($cities as $city) {
                // Trim spaces
                $city = trim($city);

                // Get users from bizdiverse that their city matches with $city
                $sql = "SELECT * FROM bizdiverse WHERE city LIKE '%$city%'";
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
            echo "<li class='list-group-item'>No city found in bizdiverse_company with mail: " . $com_email . "</li>";
        }
        ?>
        </ul>

        <button class="btn btn-primary my-3" onclick="location.href='dash_com.php'">Back</button>

    </div>
</body>
</html>
