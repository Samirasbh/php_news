<?php
require_once('../functions/pdo_connect.php');
session_start();
if (!isset($_SESSION['login'])) {
    header('location:http://localhost/php_basic/02-ex/login.php');
}
// categories
$sqlc = "SELECT * FROM categories";
$statement = $conn->prepare($sqlc);
$statement->execute();
$result = $statement->fetchAll();
// create a new row in database
if ((isset($_POST['title']) && $_POST['title'] != '') &&
    (isset($_POST['summary']) && $_POST['summary'] != '') &&
    (isset($_POST['content']) && $_POST['content'] != '') &&
    (isset($_FILES['file']) && $_FILES['file'] != '') &&
    (isset($_POST['status']) && $_POST['status'] != '') &&
    (isset($_POST['categories']) && $_POST['categories'] != '') &&
    ($_SERVER['REQUEST_METHOD'] == 'POST')
) {
    // check category id
    $categories = $_POST['categories'];
    $query = "SELECT * FROM categories WHERE name=?";
    $stm = $conn->prepare($query);
    $stm->execute([$_POST['categories']]);
    $res = $stm->fetch();
    $category_id = $res['category_id'];

    // check other fields
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    // check status
    if ($_POST['status'] === "active") $status = 1;
    if ($_POST['status'] === "disable") $status = 0;

    // check image field
    $tmpfile = $_FILES['file']['tmp_name'];
    $newfile = '../assets/' . $_FILES['file']['name'];
    move_uploaded_file($tmpfile, $newfile);
    $fileaddress = 'http://localhost/php_basic/02-ex/assets/' . $_FILES['file']['name'];

    $sql = "INSERT INTO posts SET category_id=? , title=? , summary =? , content = ? , status = ? , img_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$category_id, $title, $summary, $content, $status, $fileaddress]);
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
            width: 88%;
            padding: 20px;
        }

        .create {
            width: 250px;
            height: 400px;
            border: 1px solid gray;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: flex-start;
            padding: 5px;
        }
    </style>
</head>

<body>
    <header>
        <a href="./index.php" class="logo">
            <img src="../assets/logo.jpg" alt="page logo">
        </a>
        <a href="../login.php">logout</a>
    </header>
    <section>
        <div class="dashboard">
            <h3>you logged in</h3>
            <h4>welcom to admin panel </h4>
            <form method="get" class="show_btns">
                <a href=""> categories</a>
                <a href="http://localhost/php_basic/02-ex/panel/post.php">posts</a>
            </form>
        </div>

        <div class="context">
            <form class="create" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="post title">
                <input type="text" name="summary" placeholder="post summary">
                <textarea name="content" id="content" placeholder="post content"></textarea>
                <input type="file" name="file" id="file" placeholder="post image">

                <label for="status">define post status</label>
                <select name="status" id="status">
                    <option value="active">active</option>
                    <option value="disable">disable</option>
                </select>

                <label for="categories">select category </label>
                <select name="categories" id="categories">
                    <?php
                    foreach ($result as $rr) {
                        $category_name = $rr['name'] ?>
                        <option value="<?= $category_name ?>"><?= $category_name ?></option>
                    <?php } ?>
                </select>
                <input type="submit" value="enter" name="submit">
            </form>
        </div>
    </section>
</body>

</html>