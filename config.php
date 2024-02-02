<?php

$host = 'localhost';
$db_user = 'root'; 
$db_password = ''; 
$db_name = 'blog'; 

$connеction = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$connеction) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
