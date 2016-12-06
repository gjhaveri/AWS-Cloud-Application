<?php
session_start();
require 'vendor/autoload.php';


$client = new Aws\Rds\RdsClient([
  'region'            => 'us-west-2',
    'version'           => 'latest'
]);


$result = $client->describeDBInstances([
    'DBInstanceIdentifier' => 'clouddatabases'
]);


$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
echo $endpoint . "\n";

$link = mysqli_connect($endpoint,"awsdatabase","awsdatabase","school") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$username= $_POST['userid'];
$pwd= $_POST['password'];

$_SESSION['usernames']=$username;



#$userid= (isset($_POST['userid'])    ? $_POST['userid']    : '');
 #      $password    = (isset($_POST['password'])    ? $_POST['password']    : '');
  #         $account= (isset($_POST['account'])    ? $_POST['account']    : '');
        $sql = "SELECT * FROM login WHERE userid = '$username' and password = '$pwd'";

                $result=mysqli_query($link,$sql);
        $count=mysqli_num_rows($result);


#echo "Data is here" . $retrieve;
#$result= mysqli_query($link,$retrieve);
if ($result->num_rows > 0) {
        // output data of each row
    #while($row = $result->fetch_assoc()) {
     #   echo "<tr><td><t>".$row["ID"]."</t></td><td><t>".$row["Name"]." ".$row["Age"]."</t></td></tr>";
 header("location:welcome.php");
        }
        else {


       echo ("incorrect password");
    }
?>
