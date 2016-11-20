
<html>
<head><title>Best Page Ever</title></head>
<body>
<h1> World</h1>


<form enctype="multipart/form-data" action="uploader.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

<input type="file" name="userfile" />
<input type="submit" value="submit" />
</form>

</body>
</html>


<?php

session_start();
$rdsclient = new Aws\Rds\RdsClient([
  'region'            => 'us-west-2',
    'version'           => 'latest'
]);


$rdsresult = $rdsclient->describeDBInstances([
    'DBInstanceIdentifier' => 'clouddatabases'
]);


$endpoint = $rdsresult['DBInstances'][0]['Endpoint']['Address'];
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


$create_table = "CREATE TABLE records
(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(32),
phone VARCHAR(32),
s3-raw-url VARCHAR(32),
s3-finished-url VARCHAR(32),
status INT(1),
receipt VARCHAR(256)
)";

$link->query($create_table);

?>
