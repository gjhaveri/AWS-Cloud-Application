

<?php
echo"Hello World";

require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

#$s3 = $sdk->createS3();
$result = $s3->listBuckets();

foreach ($result['Buckets'] as $bucket) {
    echo $bucket['Name'] . "\n";
}

?>

<!DOCTYPE html>
<form action="s3test.php">

<html>
<body>


<input type="submit" value="S3test">
</form>

<form action="dbtest.php">
<input type="submit" value="dbtest">
</form>
</body>
</html>

















