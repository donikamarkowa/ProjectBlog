<?php
include '../config.php';
include 'register.php';
include '../functions/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $registrationResult = registerUser($conn, $username, $email, $password);

    if ($registrationResult === true) {
        header("Location: /dashboard/ProjectBlog/login/login.php");
        exit();
    } else {
        echo "Registration error: " . $registrationResult;
    }
    
    mysqli_close($conn);
}
?>
