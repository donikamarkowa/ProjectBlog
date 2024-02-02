<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';
include 'functions/functions.php';

$conn = mysqli_connect($host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$posts = getAllPosts($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #3498db;
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
    }

    form {
        max-width: 400px;
        width: 100%;
        text-align: left;
        margin: 20px;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        margin: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    small {
        display: block;
        margin-top: 10px;
        color: #555;
    }

    textarea {
        width: calc(100% - 20px);
        height: 100px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #2ecc71;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        box-sizing: border-box;
    }

    input[type="submit"]:hover {
        background-color: #27ae60;
    }

    a {
        display: inline-block;
        padding: 10px;
        margin: 10px;
        background-color: #3498db;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
    }

    a:hover {
        background-color: #2980b9;
    }
</style>

</style>


</head>
<body>
    <h1>Welcome to the blog, <?php echo $_SESSION['username']; ?>!</h1>

    <h2>Add new post</h2>
    <form action="posts/create_post_process.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea><br>

        <input type="submit" value="Add post">
    </form>

    <h2>Posts</h2>
    <?php if ($posts): ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><?php echo $post['title']; ?></h3>
                    <p><?php echo $post['content']; ?></p>
                    <small>Author: <?php echo $post['author_username']; ?> | Date: <?php echo $post['created_at']; ?></small>

                    <form action="add_comment_process.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <label for="comment_content">Comment:</label>
                        <textarea id="comment_content" name="comment_content" required></textarea><br>
                        <input type="submit" value="Add comment">
                    </form>

                    <?php
                        $post_id = $post['id'];
                        $comments = getCommentsForPost($conn, $post_id);
                    ?>
                    <ul>
                        <?php foreach ($comments as $comment): ?>
                            <li>
                                <p><?php echo $comment['content']; ?></p>
                                <small>Comment by: <?php echo $comment['author_username']; ?> | Date: <?php echo $comment['created_at']; ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No posts added yet.</p>
    <?php endif; ?>

    <a href="/dashboard/ProjectBlog/logout/logout.php">Logout</a>
</body>
</html>
