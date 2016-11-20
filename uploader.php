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



?>

<html>
<head><title>Hello app</title>
</head>
<body>

<hr />
<a href="admin.php"> Admin </a>

</body></html>
