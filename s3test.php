<?php
echo"<b> IMAGE RETRIEVED!</b>";

require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

#$s3 = $sdk->createS3();
$result = $s3->listBuckets();

foreach ($result['Buckets'] as $bucket) {
    echo "\n" . $bucket['Name'] . "\n";
}

$key = 'switchonarex.png';
$result = $s3->putObject(array(
'ACL'=>'public-read',
'Bucket'=>'raw-gjh',
'Key' => $key,
'SourceFile'=> '/home/ubuntu/gjhaveri/switchonarex.png'
));
$url=$result['ObjectURL'];
echo $url;
?>

<!DOCTYPE html>
<html>
<body>

<h2>Hello Dino</h2>
<img src="https://s3-us-west-2.amazonaws.com/raw-gjh/switchonarex.png" alt="IIT">

</body>
</html>
