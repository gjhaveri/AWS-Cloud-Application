<?php
session_start();
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);




// have to hard code this here because index.php doesn't exist
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
