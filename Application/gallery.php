<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css">

</head>
<body>
<br>

<div style="width:400px;">
<div style="float: left; width: 130px">

<form action="upload.php">
<head>
<link href="styles.css" rel="stylesheet" type="text/css">
</head><button>Upload</button>
</form>
</div>

<div style="float: right; width: 225px">
<form action="admin.php">
<button>Admin Page</button>
</form>
</div>
</div>

<div style="float: center; width: 225px">

<form action="logout.php">
<button>Logout</button>
</form>
</div>
</head>
</body>
</html>


<?php

session_start();

echo " <b>Welcome to your gallery, Monsieur! <b> " .  $_SESSION['username'] . "<br>";
$email = $_SESSION['email'];
//echo "\n<br>" . md5($email) . "<br>";

$_SESSION['receipt'] = md5($email);

require 'vendor/autoload.php';
$rdsclient = new Aws\Rds\RdsClient([
  'region'            => 'us-west-2',
    'version'           => 'latest'
]);
$rdsresult = $rdsclient->describeDBInstances([
    'DBInstanceIdentifier' => 'clouddatabases'
]);
$endpoint = $rdsresult['DBInstances'][0]['Endpoint']['Address'];
//echo $endpoint . "\n";
$link = mysqli_connect("$endpoint","awsdatabase","awsdatabase","school") or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$link->real_query("SELECT * FROM recordings");

$res = $link->use_result();
//echo "<br>Result set order...\n<br>";

while ($row = $res->fetch_assoc()) {
echo "<br>" . "BEFORE" . "<br>";
    echo "<img src =\" " . $row['s3rawurl'] . "\" />" . "<br>";


echo "<br>" . "AFTER" . "<br>";

echo "<img src =\"" . $row['s3finishedurl'] . "\"/>" . "<br>";
//    echo "<img src =\" " . "This is the raw image " . $row['s3rawurl'] . "\" /><img src =\"" . "This is the finished image" . $row['s3finishedurl'] . "\"/>";

}

require 'vendor/autoload.php';
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$s3result = $s3->getObject([
'Bucket' => 'raw-gjh',
'Key' => $_SESSION['objectname'] ,
]);

echo $s3result;

$link->close();


?>
<?php
if ($_SESSION['usernames']!="gjhaveri@hawk.iit.edu")
{
?>

<html>
<head><body>

<form action="upload.php">
<button>Upload</button>
</form>

</head></body></html>

<?php
}
?>
