<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    include 'config.php';
    include 'functions/functions.php';

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $post_id = $_POST['post_id'];
    $comment_content = $_POST['comment_content'];
    $author_username = $_SESSION['username'];

    $author_id_query = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $author_id_query);
    mysqli_stmt_bind_param($stmt, "s", $author_username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $author_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!$author_id) {
        die("Error getting author ID.");
    }

    $insertCommentQuery = "INSERT INTO comments (post_id, author, content, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $insertCommentQuery);
    mysqli_stmt_bind_param($stmt, "iss", $post_id, $author_id, $comment_content);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: /dashboard/ProjectBlog/blog.php");
        exit();
    } else {
        echo "Comment creation error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: /dashboard/ProjectBlog/login.php");
    exit();
}
?>
