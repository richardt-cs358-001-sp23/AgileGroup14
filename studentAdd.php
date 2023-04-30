<?php
$servername = "localhost";
$username = "user3";
$password = "pwd14";
$dbname = "AgileExpG3"; 

try {
    $students_file = $_POST['studentsFile'];
    // Splitting of file migth change based on format of file
    $rows = explode("\n", $students_file);
    // Getting rid of the first row (the format row)
    array_shift($rows)

    // Prepare the sql
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // change to correct table and columns when those are created
    // not sure about inserting id yet have to deal with duplicates (insert might just deal with it)
    $insertStudent = $conn->prepare("INSERT INTO student (studentId, firstName, lastName, email) VALUES (?, ?, ?, ?);");
    $connectWorksOn = $conn->prepare("INSERT INTO student (projectId, studentId) VALUES (?, ?);");

    // Split up the file into an array of students
    $students = array()
    foreach($rows as $row => $data)
    {
        $row_data = explode(",", $data);
        $student[$row]['projectId'] = $row_data[0];
        $student[$row]['studentId'] = $row_data[1];
        $student[$row]['firstname'] = $row_data[2];
        $student[$row]['lastname']  = $row_data[3];
        $student[$row]['email']     = $row_data[4];

        $insertStudent->bind_param("isss", $student[$row]['studentId'], $student[$row]['firstname'], $student[$row]['lastName'], $student[$row]['email']);
        $connectWorksOn->bind_param("ii", $student[$row]['projectId'], $student[$row]['studentId']);
        $insertStudent->execute();
        $connectWorksOn->execute();
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
header('Location: studentAdd.html');
?>
