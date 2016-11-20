<?php
session_start();
echo $username . "\n";
$email = $_SESSION['usernames'];
echo "<b>Hello Cloud User, you are Welcomed to this world</b><br>" . "\n";
echo "<br>Your email is:" . $email . "\n" . "<br>";
$_SESSION['userid'] = $_POST['userid'];
if ($_SESSION['usernames']!="jhajek@iit.edu")
{
?>

<html>
<head><body>
<br><a href="gallery.php"> Gallery </a> | <a href="upload.php"> Upload </a> | <a href="uploader.php"> Uploader </a> | <a href="admin.php"> Admin </a> | <a href= "logout.php"> logout </a>
</head></body></html>

<?php
}
?>


<html>
<head><title>Hello app</title>
</head>
<body>
<hr />
</body></html>
