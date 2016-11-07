<?php

echo "Hello world";
$link = mysqli_connect("clouddatabases.clbbdifdgtxm.us-west-2.rds.amazonaws.com:3306","awsdatabase","awsdatabase","gjhaverirds") or die("Error" . mysqli_error($link));

//echo "Here is the result: " . $link;


$sql = "CREATE TABLE school
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
PosterName VARCHAR(32),
Name VARCHAR(255),
Age int(3)
)";

$link->query($sql);

$sql2 = "INSERT INTO `school` (`name`,`age`) VALUES ('gj',8),('Pc',99),('Jam',7),('Ze',6),('Alem',12)";
if ($link->query($sql2) === TRUE) {
echo "Data inserted successfully";
} else {
echo "Error creating database: " . $link->error;
}


$retrieve="SELECT * FROM school";
#echo "Data is here" . $retrieve;

$result= mysqli_query($link,$retrieve);


if ($result->num_rows > 0) {
        // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ID"]."</td><td>".$row["Name"]." ".$row["Age"]."</td></tr>";
    }
}
$link->close();

?>
