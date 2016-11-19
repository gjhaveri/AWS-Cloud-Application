<?php
session_start();
echo $username . "\n";

$email = $_SESSION['usernames'];

echo "<b>Hello Cloud User, you are Welcomed to this world</b><br>" . "\n";
echo "<br>Your email is: " . $email . "\n";

$_SESSION['userid'] = $_POST['userid'];
?>

<html>
<head><title>Hello app</title>
</head>
<body>
<hr />
<a href="gallery.php"> Gallery </a> | <a href="upload.php"> Upload </a> | <a href="Uploader.php"> Uploader </a> | <a href="admin.php"> Admin </a>

</body></html>
