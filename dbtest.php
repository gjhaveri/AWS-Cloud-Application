<?php
echo "Hello world";
$link = mysqli_connect("clouddatabases.clbbdifdgtxm.us-west-2.rds.amazonaws.com:3306","awsdatabase","awsdatabase","school") or die("Error" . mysqli_error($link));
//echo "Here is the result: " . $link;
$sql1 = "CREATE DATABASE IF NOT EXISTS school";
if ($link->query($sql1) === TRUE) {
echo "Database created successfully";
} else {
echo "Error creating database: " . $link->error;
}
$sql = "CREATE TABLE students
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Name VARCHAR(255),
Age int(3)
)";
$link->query($sql);
$sql2 = "INSERT INTO `students` (`name`,`age`) VALUES ('gaurav',21),('matthew',29),('alberto',27),('Zalewski',26),('Alem',32)";
if ($link->query($sql2) === TRUE) {
echo "Data inserted successfully";
} else {
echo "Error creating database: " . $link->error;
}
$retrieve="SELECT * FROM students";
#echo "Data is here" . $retrieve;
$result= mysqli_query($link,$retrieve);
if ($result->num_rows > 0) {
        // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td><t>".$row["ID"]."</t></td><td><t>".$row["Name"]." ".$row["Age"]."</t></td></tr>";
    }
}
$link->close();
 $result1 = mysqli_query('TRUNCATE TABLE school');
 if ($result1) {
   echo "Request ID table has been truncated";
 }
?>
