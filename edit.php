<?php
session_start();
// make sure you have php-gd installed and you may need to reload the webserver (apache2)

// get SQS queue name

require 'vendor/autoload.php';

$sqsclient = new Aws\Sqs\SqsClient([
    'region'  => 'us-west-2',
    'version' => 'latest'
]);

$sqsresult = $sqsclient->getQueueUrl([
    'QueueName' => 'assignmentqueue' // REQUIRED
]);

echo $sqsresult['QueueURL'];
$queueUrl = $sqsresult['QueueURL'];

// query to see if any messages




//if so then retreive the body of the first queue message and assign it to a variable
$result=$sqsclient->receiveMessage([
'QueueUrl'=>'https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue'
]);

//foreach ($result->getPath('Messages/*/Body') as $messageBody) {
  //  echo "<pre>";
    //echo htmlentities( print_r( $messageBody, true ) );
  //  echo "</pre>";
//}

foreach($result->get('Messages') as $message){


  echo "<pre>";
echo "<b>This is the message of the latest picture whihc is md5 Hashed <b>" . "<br>";
    echo htmlentities( print_r($message['Body'], true ) );
    echo "</pre>" . "<br>";
//echo "This is the message of the latest picture which is md5 Hashed";
    echo "<hr />";
}


$result_message = array_pop($result['Messages']);
    $queue_handle = $result_message['ReceiptHandle'];
    $message_json = $result_message['Body'];
// look up the RDS database instance name (URI)

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
echo "Image has finished processing, you can view it in Gallery." . "<br>";
$sql1 = "CREATE DATABASE IF NOT EXISTS school";
if ($link->query($sql1) === TRUE) {
//echo "<br>" . "Database created successfully<br>";
} else {
echo "Error creating database: " . $link->error;
}


// Query the RDS database:  SELECT * FROM records WHERE RECEIPT = $receipt;
$receipt = $_SESSION['receipts'];

//echo "REC : " . $receipt;
$link->real_query("SELECT * FROM recordings where receipt= '$receipt'");
$res = $link->use_result();
//echo "Result set order...";
while ($row = $res->fetch_assoc()) {
//        echo " id = \n" . $row['id'] . "\n email =" . $row['email'] . "\n phone = " . $row['phone'] . "s3rawurl = \n" . $row['s3rawurl'] . "\n s3finishedurl = \n" . $row['s3finishedurl'] . "\n status = \n" . $row['status'] . "\n receipt =" . $row['receipt'] . "\n";

$s3rawurl = $row['s3rawurl'];

}
// For Images


// load the "stamp" and photo to apply the water mark to
$stamp = imagecreatefrompng('https://s3-us-west-2.amazonaws.com/raw-gjh/IIT-logo.png');  // grab this locally or from an S3 bucket probably easier from an S3 bucket...
$im = imagecreatefromjpeg($s3rawurl);  // replace this path with $rawurl

//Set the margins for the stamp and get the height and width of the stamp image
$marge_right=10;
$marge_bottom=10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

//Copy the stamp image onto our photo using the margin offsets and the photo
// width to calculate positioning of the stamp
imagecopy($im,$stamp,imagesx($im) - $sx -$marge_right, imagesy($im) - $sy -$marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

//output and free memory
//header('Content-type: image/png');
imagepng($im,'/tmp/rendered.png');
imagedestroy($im);

// place the rendred image into S3 finished-url bucket

require 'vendor/autoload.php';
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$key = 'rendered.png';
$result = $s3->putObject(array(
'ACL'=>'public-read',
'Bucket'=>'finished-gjh',
'Key' => $key,
'SourceFile'=> '/tmp/rendered.png'
));


// retreive the Object URL

$url=$result['ObjectURL'];
//echo $url;

$finishedurl = $url;

// update the ROW in the RDS database - change the status to 1 (finished) and add the S3finshedURL
$statuses = 1;
$sql ="UPDATE recordings SET status='$statuses', s3finishedurl= '$finishedurl' WHERE receipt= '$receipt'";

if ($link->query($sql) === TRUE) {
  //  echo "Record updated successfully";
} else {
    echo "Error updating record: " . $link->error;
}
// Consume the message on the Queue (delete/consume it)

$queue= 'https://sqs.us-west-2.amazonaws.com/599404884853/assignmentqueue';

require 'vendor/autoload.php';

$sqsclient = new Aws\Sqs\SqsClient([
   'region'  => 'us-west-2',
   'version' => 'latest'
]);

$results = $sqsclient->deleteMessage([
  'QueueUrl' => $queue, // REQUIRED
  'ReceiptHandle' => $queue_handle // REQUIRED
]);







// Send SNS notification to the customer of succeess.

require 'vendor/autoload.php';

$snsclient = new Aws\Sns\SnsClient([

'region' => 'us-west-2',
'version' => 'latest'
]);


$snsresults = $snsclient->publish([
'Message' => 'Image Successfully uploaded &  Modified ',
//'TopicArn'=> 'arn:aws:sns:us-west-2:599404884853:cloudassignment',

//'MessageAttributes' => ['Image Successfully uploaded &  Modified' => ['DataType' => 'String'],],
'PhoneNumber'=>'2248177955',
]);

// Profit.

?>

<html lang="en">
<head>
<meta charset="UTF-8">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="gallery.php" method="post">
<br> <input type="submit" value="Gallery">
</form>
</body>
</html>
