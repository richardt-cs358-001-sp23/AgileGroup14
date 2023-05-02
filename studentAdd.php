<?php 
$servername = "localhost"; 
$username = "admin3"; 
$password = "mild14reach"; 
$dbname = "AgileExpG3";
$data = array();

try {
    // get the name of the file that was posted to the server
    $studentsFile = $_FILES['filename']['tmp_name'];
    // Prepare the sql 
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    // change to correct table and columns when those are created 
    // not sure about inserting id yet have to deal with duplicates (insert might just deal with it) 
    $insertStudent = $conn->prepare("INSERT INTO student (firstName, lastName, email) VALUES (:firstName, :lastName, :email);"); 
    $getInsertedId = $conn->prepare("SELECT studentId FROM student WHERE firstName = :firstName AND lastName = :lastName AND email = :email LIMIT 1"); 
    $connectWorksOn = $conn->prepare("INSERT INTO worksOn (projectId, studentId) VALUES (:projectId, :studentId);");

    // Splitting of file might change based on format of file 
    if (($open = fopen($studentsFile, "r")) !== FALSE) 
    {
        fgetcsv($open, 1000, ",");
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
        {        
            // Insert the student into the database
            $insertStudent->bindParam(':firstName', $data[2], PDO::PARAM_STR, strlen($data[2]));
            $insertStudent->bindParam(':lastName', $data[3], PDO::PARAM_STR, strlen($data[3]));
            $insertStudent->bindParam(':email', $data[4], PDO::PARAM_STR, strlen($data[4]));

            if ($insertStudent->execute())
            {
                // Get the Id of the newly inserted Student
                $getInsertedId->bindParam(':firstName', $data[2], PDO::PARAM_STR, strlen($data[2]));
                $getInsertedId->bindParam(':lastName', $data[3], PDO::PARAM_STR, strlen($data[3]));
                $getInsertedId->bindParam(':email', $data[4], PDO::PARAM_STR, strlen($data[4]));

                if ($getInsertedId->execute())
                {
                    $Id = $getInsertedId->fetch()[0];
                
                    // Link the student to a project in the worksOn table
                    $connectWorksOn->bindParam(':projectId', $data[0], PDO::PARAM_INT);
                    $connectWorksOn->bindParam(':studentId', $Id, PDO::PARAM_INT);
                    $connectWorksOn->execute();
                }
            }
        }
    
        fclose($open);
    }
    else
    {
        echo "Error Opening file";
        print_r($_FILES);
    }

} 
catch(PDOException $e) { 
    echo "Error: " . $e->getMessage();
    echo "\n";
    print_r($_FILES);
    print_r($data);
} 
$conn = null; 
header('Location: studentAdd.html'); ?>