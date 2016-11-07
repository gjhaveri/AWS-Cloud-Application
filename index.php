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
