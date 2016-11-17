
<?php

session_start();

echo "Your email is: " .  $_SESSION['email'];
$email = $_SESSION['email'];
echo "\n" . md5($email);

$_SESSION['receipt'] = md5($email);
?>

<html>
<head><title>Hello app</title>
</head>
<body>
Gallery PHP
<a href="gallery.php"> Gallery </a> <a href="upload.php"> Upload </a>

</body></html>


