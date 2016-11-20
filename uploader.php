<?php
session_start();
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);




// using Session Variable
$_SESSION['email']=$_SESSION['usernames'];

echo "\n" . $_SESSION['email'] ."\n";
?>

<html>
<head><title>Hello app</title>
</head>
<body>
Hello world
<hr />
<a href="admin.php"> Admin </a>

</body></html>
