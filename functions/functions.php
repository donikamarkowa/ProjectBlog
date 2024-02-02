<?php
//include '../config.php';

function registerUser($conn, $username, $email, $password) {
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $checkUsernameQuery);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        return "Username already exists. Please choose another.";
    }

    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmtEmail = mysqli_prepare($conn, $checkEmailQuery);
    mysqli_stmt_bind_param($stmtEmail, "s", $email);
    mysqli_stmt_execute($stmtEmail);

    $resultEmail = mysqli_stmt_get_result($stmtEmail);

    if (mysqli_num_rows($resultEmail) > 0) {
        return "Email already exists. Please choose another.";
    }

    $insertUserQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"; //деф. sql заявка за вмъкване, плейсхолдъри ?
    $stmtInsert = mysqli_prepare($conn, $insertUserQuery); //подготовка на подготвителната заявка 
    mysqli_stmt_bind_param($stmtInsert, "sss", $username, $email, $password); //свързване на стойностите

    if (mysqli_stmt_execute($stmtInsert)) {
        return true; 
    } else {
        return "Registration error: " . mysqli_error($conn);
    }
}


function loginUser($conn, $username, $password) {
    $loginQuery = "SELECT username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $loginQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) == 1) { //проверка за резултат от изпълнението на заявката и броя редовете дали е 1
            $row = mysqli_fetch_assoc($result); //извличаме данните и ги съхраняваме в асоциативен масив row 
            $dbPassword = $row['password'];
            if ($password == $dbPassword) {
                return true; 
            } else {
                return "Invalid username or password!!!";
            }
        } else {
            return "Invalid username or password";
        }

        mysqli_stmt_close($stmt);
    } else {
        return "Error preparing statement: " . mysqli_error($conn);
    }
}

function addPost($conn, $title, $content, $author_id) {
     $insertQuery = "INSERT INTO posts (title, content, author_id, created_at) VALUES (?, ?, ?, NOW())";
    
     $stmt = mysqli_prepare($conn, $insertQuery);
     if (!$stmt) {
         return "Error preparing statement: " . mysqli_error($conn);
     }
     mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $author_id);
 
     $result = mysqli_stmt_execute($stmt); //изпълняваме заявката
     if (!$result) {
         return "Error executing statement: " . mysqli_error($conn);
     }
     mysqli_stmt_close($stmt); //затваряме подготвителната заявка
 
     return true; 
}

function getAllPosts($conn) {
    $posts = array(); //празен масив за постовете

    $query = "SELECT posts.*, users.username as author_username FROM posts JOIN users ON posts.author_id = users.id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) { //обхождаме всички редове от резултата и ги + към масива
            $posts[] = $row;
        }
    }

    return $posts;
}


function addComment($conn, $post_id, $author_id, $content) {
    $insertQuery = "INSERT INTO comments (post_id, author_id, content, created_at) VALUES (?, ?, ?, NOW())";

    $stmt = mysqli_prepare($conn, $insertQuery);
    if (!$stmt) {
        return "Error preparing statement: " . mysqli_error($conn);
    }
    mysqli_stmt_bind_param($stmt, "iis", $post_id, $author_id, $content);

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        return "Error executing statement: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);

    return true;
}

function getCommentsForPost($conn, $post_id) {
    $comments = array();

    $query = "SELECT comments.*, users.username as author_username FROM comments
    INNER JOIN users ON comments.author = users.id
    WHERE comments.post_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
    }

    return $comments;
}



?>