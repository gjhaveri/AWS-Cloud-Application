<?php
echo"<b> Welcome to the Cloud Native Application \n <b>";

require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

#$s3 = $sdk->createS3();
$result = $s3->listBuckets();

foreach ($result['Buckets'] as $bucket) {
    echo "\n". $bucket['Name'] . "\n";
}

?>

<!DOCTYPE html>
<form action="s3test.php">

<html>
<body>


<input type="submit" value="Load Image">
</form>

<form action="dbtest.php">
<input type="submit" value="Records">
</form>
</body>
</html>

#<?php session_start(); ?>
#<html>
#<head><title>Hello app</title>
#</head>
#<body>

#<!-- The data encoding type, enctype, MUST be specified as below -->
#<form enctype="multipart/form-data" action="welcome.php" method="POST">
 #   <!-- MAX_FILE_SIZE must precede the file input field -->
  #  <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
#    <!-- Name of input element determines name in $_FILES array -->
#    Send this file: <input name="userfile" type="file" /><br />
#Enter Email of user: <input type="email" name="email"><br />
#Enter Phone of user (1-XXX-XXX-XXXX): <input type="phone" name="phone">

#<input type="submit" value="Send File" />
#</form>
#<hr />
#</body>
#</html>
