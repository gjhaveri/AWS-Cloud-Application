
<?php
session_start();
echo "<b>Welcome to Admin  page, choose one of the following features.<b><br>";
?>

<!DOCTYPE html>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css">

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
</head>
<body>
<form action="backup.php" method="post">

    <input type="submit" value="Backup Database">
</form>

<form action="export.php" method="post">
    <input type="submit" value="Export Database">
</form>
  
 <form action="restore.php" method="post">
    <input type="submit" value="Restore Database">
</form>
  

<h2>Toggle Switch</h2>

<label class="switch">
  <input type="checkbox" checked>
  <div class="slider round"></div>
</label>

</body>
</html>
                                                                                                                                                                              1,0-1         Top
