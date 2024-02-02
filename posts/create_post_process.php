<?php
session_start();
include '../config.php';
include '../functions/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username']; 

    $author_query = "SELECT id FROM users WHERE username = ?";
    $author_stmt = mysqli_prepare($conn, $author_query); //подготвителна заявка, вграждаме author_query в sql заявката
    mysqli_stmt_bind_param($author_stmt, "s", $username); //свързваме парам. , 's' имаме стринг и е предоставена от username
    mysqli_stmt_execute($author_stmt); //изпълняваме заявката
    mysqli_stmt_bind_result($author_stmt, $author_id); //свързване резултатите от заявката с id-то 

    mysqli_stmt_fetch($author_stmt); //извличаме резултата от заявката и го записва в author_id
    mysqli_stmt_close($author_stmt); //затваряме заявката, след като са извлечени резултатите

    if (!$author_id) {
        die("Error retrieving author ID.");
    }

    $creationResult = addPost($conn, $title, $content, $author_id);

    if ($creationResult === true) {
        mysqli_close($conn);
        header("Location: /dashboard/ProjectBlog/blog.php");
        exit();
    } else {
        echo "Post creation error: " . $creationResult;
        echo "MySQL Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
   
}
?>
