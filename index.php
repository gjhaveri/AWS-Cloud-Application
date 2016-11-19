<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>
<form action="dbtest.php" method="post">
    <p>
        <label for="userid">User Name:</label>
        <input type="text" name="userid" id="userid">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="text" name="password" id="password">
    </p>
    <p>
        <label for="account">Account:</label>
        <input type="text" name="email" id="account">
    </p>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php
session_start();
require 'vendor/autoload.php';


$client = new Aws\Rds\RdsClient([
  'region'            => 'us-west-2',
    'version'           => 'latest'
]);


$result = $client->describeDBInstances([
    'DBInstanceIdentifier' => 'clouddatabases'
]);


$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
echo $endpoint . "\n";

$link = mysqli_connect($endpoint,"awsdatabase","awsdatabase","school") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$sql1 = "CREATE DATABASE IF NOT EXISTS school";
if ($link->query($sql1) === TRUE) {
echo "Database created successfully";

} else {
echo "Error creating database: " . $link->error;
}
$sql = "CREATE TABLE login
(
userid VARCHAR(255),
password VARCHAR(30),
account VARCHAR(20)
)";

$link->query($sql);
$sql2 = "INSERT INTO `login` (`userid`,`password`,`account`) VALUES ('gjhaveri@hawk.iit.edu','gaurav','controller'),('jhajek@iit.edu','ilovebunnies','user'),('a@iit.edu','iit','user')";
if ($link->query($sql2) === TRUE) {
echo "Data inserted successfully";
} else {
echo "Error creating database: " . $link->error;
}
?>
