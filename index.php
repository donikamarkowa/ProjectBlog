<?php
include 'config.php';
include 'functions/functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin: 0;
        }
        a {
            display: inline-block;
            padding: 10px;
            margin: 10px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #555;
        }
        div {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 20px;
            margin: 10px;
        }
        #blog-description {
            margin-bottom: 20px;
        }
        #blog-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
        }
        #register-link,
        #login-link {
            display: block;
            margin: 10px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Welcome to the TV series blog!</h1>
    <div id="blog-description">
        <p>This is a fantastic blog where you can share and explore things about your most favorite series and movies. Feel free to create and read posts from our talented community! It's time to make new friendships through our hobby!</p>
    </div>
    <img id="blog-image" src="/dashboard/ProjectBlog/image.jpg" alt="Blog Image">
    <a href="/dashboard/ProjectBlog/registration/register.php">Register</a>
    <a href="/dashboard/ProjectBlog/login/login.php">Login</a>
</body>
</html>