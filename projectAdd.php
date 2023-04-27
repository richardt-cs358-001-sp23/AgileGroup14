<?php
$servername = "localhost";
$username = "user3";
$password = "pwd14";
$dbname = "AgileExpG3"; 

try {
    $students_file = $_POST['projectsFile'];
    // Splitting of file migth change based on format of file
    $rows = explode("\n", $students_file);
    array_shift($rows)

    // Prepare the sql
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // change to correct table and columns when those are created
    // not sure about inserting id yet have to deal with duplicates (insert might just deal with it)
    $statement = $conn->prepare("INSERT INTO project (semesterId, projectId, projectName, projectDescription) VALUES (?, ?, ?, ?);");

    // Split up the file into an array of students and add them to the database
    foreach($rows as $row => $data)
    {
        $row_data = explode(",", $data);
        $project[$row]['semesterID'] = $row_data[0];
        $project[$row]['projectID']  = $row_data[1];
        $project[$row]['projectname']  = $row_data[2];
        $project[$row]['projectdescription']  = $row_data[3];

        $project->bind_param("iiss", $project[$row]['semesterID'], $project[$row]['projectID'], $project[$row]['projectname'], $project[$row]['projectdescription']);
        $project->execute();
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
header('Location: studentAdd.html');
?>
