<?php
// select items from database table categories
    $read_query = "SELECT * FROM categories";
    $read_stm = $conn->prepare($read_query);
    $read_stm->execute();
    $read_result = $read_stm->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        header{
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: gray;
            width: 100vw;
        }
        nav{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            width: 100vw;
            height: 70px;

        }

        .logo {
            width: 50px;
            height: 40px;
        }

        .logo>img {
            width: 100%;
            height: 100%;
        }

        nav>a , .user>a{
            display: inline-block;
            background-color: lightgray;
            border-radius: 5px;
            padding: 4px;
            margin: 5px;
            border: 1px solid gray;
            margin-left: 20px;
            text-decoration: none;
            color: #000;
        }
        .user{
            display: flex;
            margin-right: 40px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
                <a href="index.php" class="logo" name="logo">
                    <img src="./assets/logo.jpg" alt="">
                </a>
                <?php
                foreach ($read_result as $rr) {
                    $category_name = $rr['name'];
                    $category_id = $rr['category_id'];
                ?>
                <a name='category-$category_id' href='http://localhost/php_basic/02-ex/category.php?category_id=<?=$category_id?>'><?=$category_name?></a>
                <?php } ?>
        </nav>
        <div class="user">
            <a href="http://localhost/php_basic/02-ex/login.php">login</a>
            <a href="http://localhost/php_basic/02-ex/register.php">register</a>

        </div>
    </header>
</body>
</html>
   