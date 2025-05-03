<?php 
$dbcon = mysqli_connect('localhost', 'root', '', 'bloodBank_db', 3307) 
    or die('Could not connect to MySQL: ' . mysqli_connect_error());

mysqli_set_charset($dbcon, 'utf8');
?>
