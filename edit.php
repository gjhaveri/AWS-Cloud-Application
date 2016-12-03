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

foreach($result->get('Messages') as $message){

    echo "<pre>";
    echo htmlentities( print_r($message['Body'], true ) );
    echo "</pre>";
    echo "<hr />";
}



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

$sql1 = "CREATE DATABASE IF NOT EXISTS school";
if ($link->query($sql1) === TRUE) {
echo "Database created successfully<br>";
} else {
echo "Error creating database: " . $link->error;
}

$receipt=md5($_SESSION['url']);
// Query the RDS database:  SELECT * FROM records WHERE RECEIPT = $receipt;

$link->real_query("SELECT * FROM recordings");
$res = $link->use_result();
echo "<br>Result set order...\n<br>";
while ($row = $res->fetch_assoc()) {
    echo " id = \n" . $row['id'] . "\n email =" . $row['email'] . "\n phone = " . $row['phone'] . "s3rawurl = \n" . $row['s3rawurl'] . "\n s3finishedurl = \n" . $row['s3finishedurl'] . "\n status = \n" . $row['status'] . "\n receipt =" . $row['receipt'] . "\n";

$s3rawurl = $row['s3rawurl'];

}



// For Images

//$rawurl = $row['s3rawurl'];

echo "hi prathameah". $s3awurl;

// load the "stamp" and photo to apply the water mark to
$stamp = imagecreatefrompng('https://s3-us-west-2.amazonaws.com/raw-gjh/IIT-logo.png');  // grab this locally or from an S3 bucket probably easier from an S3 bucket...
$im = imagecreatefromjpeg($s3rawurl);  // replace this path with $rawurl

//Set the margins for the stamp and get the height and width of the stamp image
$marge_right=10;
$marge_bottom=10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
echo $sy . "\n";

//Copy the stamp image onto our photo using the margin offsets and the photo
// width to calculate positioning of the stamp
imagecopy($im,$stamp,imagesx($im) - $sx -$marge_right, imagesy($im) - $sy -$marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

//output and free memory
//header('Content-type: image/png');
imagepng($im,'/tmp/rendered.png');
imagedestroy($im);

// place the rendred image into S3 finished-url bucket
// retreive the Object URL
// update the ROW in the RDS database - change the status to 1 (finished) and add the S3finshedURL

// Consume the message on the Queue (delete/consume it)

// Send SNS notification to the customer of succeess.
?>
