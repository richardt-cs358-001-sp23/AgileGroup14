<?php
$servername = "localhost";
$username = "user3";
$password = "pwd14";
$dbname = "AgileExpG3"; 

try {
    $students_file = $_POST['studentsFile'];
    // Splitting of file migth change based on format of file
    $rows = explode("\n", $students_file);

    // Prepare the sql
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // change to correct table and columns when those are created
    // not sure about inserting id yet have to deal with duplicates (insert might just deal with it)
    $statement = $conn->prepare("INSERT INTO Student (firstname, lastName, email) VALUES (?, ?, ?);");

    // Split up the file into an array of students
    $students = array()
    foreach($rows as $row => $data)
    {
        $row_data = explode(",", $data);
        $student[$row]['firstname'] = $row_data[0];
        $student[$row]['lastname']  = $row_data[1];
        $student[$row]['email']     = $row_data[2];

        $statement->bind_param("sss", $student[$row]['firstname'], $student[$row]['lastName'], $student[$row]['email']);
        $statement->execute();
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
header('Location: studentAdd.html');
?>
