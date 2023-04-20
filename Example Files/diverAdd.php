<?php
$servername = "localhost";
$username = "diverTestUser";
$password = "diverTest0!a";
$dbname = "DiveCompetition";

try {
#  echo "in diver add php";
#  if(isset($_POST['diverName']) {

    $newDiverName = $_POST['diverName'];

  #  $newDiverName = "testing more";


    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("INSERT INTO Diver (FullName) VALUES ( :diverName );");
    $stmt->bindParam(':diverName', $newDiverName, PDO::PARAM_STR, strlen($newDiverName));

    $stmt->execute();

#  }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
header('Location: diverAdd.html');


?>
