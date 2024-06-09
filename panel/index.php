<?php
require_once('../functions/pdo_connect.php');
session_start();
if (!isset($_SESSION['login'])) {
    header('location:http://localhost/php_basic/02-ex/login.php');
}
if(isset($_GET['logout'])){
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100vw;
            height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: gray;
            height: 70px;
            padding: 0 40px;
        }

        .logo {
            width: 60px;
            height: 50px;
        }

        .logo>img {
            width: 100%;
            height: 100%;
        }

        section {
            height: 100vh;
            display: flex;
            background-color: lightgray;
        }

        .dashboard {
            padding: 10px;
            width: 12%;
            background-color: skyblue;
        }

        a {
            display: block;
            margin: 5px;
            padding: 3px;
            border: 1px solid gray;
            background-color: #fff;
            border-radius: 5px;
            text-decoration: none;
            color: #000;
        }

        .context {
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <a href="#" class="logo">
            <img src="../assets/logo.jpg" alt="page logo">
        </a>
        <a href="../logout.php">logout</a>
    </header>
    <section>
        <div class="dashboard">
            <h3>you logged in</h3>
            <h4>welcom to admin panel </h4>
            <form method="get" class="show_btns">
                <a href="http://localhost/php_basic/02-ex/panel/category.php"> categories</a>
                <a href="http://localhost/php_basic/02-ex/panel/post.php" >posts</a>
            </form>
        </div>

        <div></div>
    </section>
</body>

</html>