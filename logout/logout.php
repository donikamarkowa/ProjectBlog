<?php

session_start();
session_destroy();

header("Location: /dashboard/ProjectBlog/login/login.php");
exit();

?>