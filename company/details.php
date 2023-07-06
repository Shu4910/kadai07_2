<?php
session_start(); // セッションを開始
$com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得
?>

<!DOCTYPE html>
<html>
<head>
    <title>Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bizdiverse";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $id = $_GET['id']; // Get details of the person with the specified id
        $sql = "SELECT * FROM bizdiverse WHERE id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '  <div class="card-header">';
                echo '    Details for ID: ' . $row["id"];
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '    <h5 class="card-title">' . $row["name"] . '</h5>';
                echo '    <p class="card-text">Email: ' . $row["mail"] . '</p>';
                echo '    <p class="card-text">City: ' . $row["city"] . '</p>';
                echo '    <p class="card-text">Content: ' . nl2br($row["content"]) . '</p>';
                echo '  </div>';
                echo '</div>';
                // Update the following line
                echo '    <a href="send_message.php?id='.$row["id"].'" class="btn btn-primary">スカウトを打つ</a>';
                echo '  </div>';
                echo '</div>';
                echo 'Company email from session: ' . $com_email; // added line to display com_email
            }
        } else {
            echo "No results for id: " . $id . "<br>";
        }

        $conn->close();
        ?>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
