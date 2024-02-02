<?php
session_start();

include '../config.php';
include '../functions/functions.php';
include 'login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

    $loginResult = loginUser($conn, $username, $password);

    if ($loginResult === true) {
        $_SESSION['username'] = $username;
        header("Location: ../blog.php");
        exit();
    } else {
        echo "Login error: " . $loginResult;
    }

}
?>
