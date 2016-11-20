<?php
session_start();

require 'vendor/autoload.php';
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);


// have to hard code this here because index.php doesn't exist
$_SESSION['email']=$_SESSION['usernames'];

echo "\n Welcome to Uploader Page \n" . $_SESSION['email'] ."\n";

// To upload the file and giving temporary name.


$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

#echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "<br>File is valid, and was successfully uploaded.\n";
} else {
    echo "<br>Possible file upload attack!\n";
}

echo '<br>Here is some more debugging info:';
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
echo "\n". "This is your URL: " . $url ."\n";



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

// code to insert new record
/* Prepared statement, stage 1: prepare */

if (!($stmt = $link->prepare("INSERT INTO records (id, email, phone, s3-raw-url, s3-finished-url, status,reciept) VALUES (NULL,?,?,?,?,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}


$email = $_SESSION['email'];
$phone = '2248177955';
$s3finishedurl = ' ';
$s3rawurl = ' ';
$status = 0;
$receipt = md5($url);
// prepared statements will not accept literals (pass by reference) in bind_params, you need to declare variables
//$stmt->bind_param("ssssii",$email,$phone,$s3rawurl,$s3finishedurl,$status,$receipt);

$stmt->bind_param("ssssii",$email,$phone,$s3rawurl,$s3finsihedurl,$status,$reciept);


if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);

/* explicit close recommended */
//$stmt->close();


?>

<html>
<head><title>Hello app</title>
</head>
<body>
<hr />
<a href="admin.php"> Admin </a>
</body></html>

