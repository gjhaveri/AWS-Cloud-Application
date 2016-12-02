<?php
session_start();

require 'vendor/autoload.php';
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);


// have to hard code this here because index.php doesn't exist
$_SESSION['email']=$_SESSION['usernames'];

echo "\n Welcome to Uploader Page \n" . $_SESSION['email'] ."\n<br>";

// To upload the file and giving temporary name.


$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$_SESSION['objectname']=$uploadfile;
#echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "<br>File is valid, and was successfully uploaded.\n<br>";
} else {
    echo "<br>Possible file upload attack!\n";
}

echo '<br>Here is some more debugging info:<br>';
print_r($_FILES);

// To push the file into the bucket

$s3result = $s3->putObject([
    'ACL' => 'public-read',
     'Bucket' => 'raw-gjh',
      'Key' =>  basename($_FILES['userfile']['name']),
      'SourceFile' => $uploadfile


// Retrieve URL of uploaded Object
]);
$url=$s3result['ObjectURL'];
echo "\n". "This is your URL: " . $url ."\n<br>";



//Insert sql information


$rdsclient = new Aws\Rds\RdsClient([
  'region'            => 'us-west-2',
    'version'           => 'latest'
]);

$rdsresult = $rdsclient->describeDBInstances([
    'DBInstanceIdentifier' => 'clouddatabases'
]);


//$endpoint = $rdsresult['DBInstances'][0]['Endpoint']['Address'];
//echo $endpoint . "\n";

$link = mysqli_connect("clouddatabases.clbbdifdgtxm.us-west-2.rds.amazonaws.com:3306","awsdatabase","awsdatabase","school") or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//$delete = "DROP DATABASE school";
//if ($link->query($delete)=== TRUE){
//echo "Database Dropped";
//} else {
//echo "error" . $link->error;
//}

$sql1 = "CREATE DATABASE IF NOT EXISTS school";
if ($link->query($sql1) === TRUE) {
echo "Database created successfully<br>";

} else {
echo "Error creating database: " . $link->error;
}


//$delete = "DROP TABLE recordings";
//if ($link->query($delete)=== TRUE){
//echo "Table Dropped";
//} else {
//echo "error" . $link->error;
//}


$create_tbl = "CREATE TABLE recordings
(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(32),
phone VARCHAR(32),
s3rawurl VARCHAR(300),
s3finishedurl VARCHAR(300),
status INT(1),
receipt VARCHAR(256)
)";

$link->query($create_tbl);

// code to insert new record
/* Prepared statement, stage 1: prepare */

$email = $_SESSION['email'];
$phone = '2248177955';
//$s3finishedurl = ' ';
$s3rawurl = $url;
$s3finishedurl = ' ';
$status = 0;
$receipt = md5($url);


if (!($stmt = $link->prepare("INSERT INTO recordings (id, email, phone, s3rawurl, s3finishedurl, status,receipt) VALUES (NULL,?,?,?,?,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}


//$email = $_SESSION['email'];
//$phone = '2248177955';
//$s3-finished-url = ' ';
//$s3-raw-url = ' ';
//$status = 0;
//$receipt = md5($url);
// prepared statements will not accept literals (pass by reference) in bind_params, you need to declare variables
//$stmt->bind_param("ssssii",$email,$phone,$s3-raw-url,$s3finishedurl,$status,$receipt);

$stmt->bind_param("ssssii",$email,$phone,$s3rawurl,$s3finishedurl,$status,$receipt);

$_SESSION['receipts']=$receipt;
echo $_SESSION['receipts'];
if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);

/* explicit close recommended */
$stmt->close();


// SELECT *

$link->real_query("SELECT * FROM recordings");
$res = $link->use_result();

echo "<br>Result set order...\n<br>";
while ($row = $res->fetch_assoc()) {
    echo " id = \n" . $row['id'] . "\n email =" . $row['email'] . "\n phone = " . $row['phone'] . "s3rawurl = \n" . $row['s3rawurl'] . "\n s3finishedurl = \n" . $row['s3finishedurl'] . "\n status = \n" . $row['status'] . "\n receipt =" . $row['receipt'] . "\n";
}

$_SESSION['rawurl']=$row['s3rawurl'];
echo $_SESSION['rawurl'];

$link->close();

require 'vendor/autoload.php';

$sqsclient = new Aws\Sqs\SqsClient([
    'region'  => 'us-west-2',
    'version' => 'latest
]);
    
$sqsresult = 'https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue';
$queueUrl = $sqsresult;
echo $queueUrl;
$sqsresult = $sqsclient->sendMessage([
'MessageBody' => $_SESSION['receipts'],
'QueueUrl' =>$queueUrl]);

echo $sqsresult['MessageId'];
echo "message sent to queue";
?>

<html lang="en">
<head>
<meta charset="UTF-8">

<link href="styles.css" rel="stylesheet" type="text/css">

</head>
<body>
<form action="upload.php" method="post">
 <input type="submit" value="Go Back">
</form>
</body>
</html>

