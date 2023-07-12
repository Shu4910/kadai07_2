<?php
session_start(); // セッションを開始

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

$com_email = $_SESSION['com_email']; // セッションからメールアドレスを取得

// Get city from bizdiverse_company with specified mail
$sql_company = "SELECT city FROM bizdiverse_company WHERE com_email = '$com_email'";
$result_company = $conn->query($sql_company);

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
        echo "<a href='details.php?id=".$row["id"]."'>id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["mail"]. " - City: " . $row["city"]. "</a><br>";
      }
    } else {
      echo "0 results for city: " . $city . "<br>";
    }
  }
} else {
  echo "No city found in bizdiverse_company with mail: " . $com_email;
}

$conn->close();
?>



<button onclick="location.href='dash_com.php'">Back</button>
