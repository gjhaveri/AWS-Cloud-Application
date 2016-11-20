<?php

session_start();

echo "Your email is: " .  $_SESSION['email'];
$email = $_SESSION['email'];
echo "\n<br>" . md5($email);

$_SESSION['receipt'] = md5($email);

require 'vendor/autoload.php';


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

$link->real_query("SELECT * FROM recordings");

$res = $link->use_result();
echo "Result set order...\n";

while ($row = $res->fetch_assoc()) {
    echo "<img src =\" " . $row['s3rawurl'] . "\" /><img src =\"" .$row['s3finishedurl'] . "\"/>";
echo $row['id'];
}

$link->close();


?>

