<?php
$servername = "localhost";
$username = "user3";
$password = "pwd14";
$dbname = "AgileExpG3"; 

try {
    $newsStudentName= $_POST['studentName'];

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # change to correct table and columns when those are created
    $stmt = $conn->prepare("INSERT INTO Students FullName) VALUES ( :studentName );");
    $stmt->bindParam(':studentName', $newsStudentName, PDO::PARAM_STR, strlen($newsStudentName));

    $stmt->execute();

#  }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
header('Location: studentAdd.html');


?>
