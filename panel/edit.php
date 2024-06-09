<?php
require_once('../functions/pdo_connect.php');
session_start();
if ($_SESSION['login'] === false) {
    echo "<h1>page not found</h1>";
}
// categories
$query = "SELECT * FROM categories";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();



// edit button
if (isset($_GET['edit_id']) && $_GET['edit_id'] != '') {
    $query = "SELECT * FROM posts WHERE id = ?";
    $sql = $conn->prepare($query);
    $sql->execute([$_GET['edit_id']]);
    $res = $sql->fetch();
    if ($res) {
        $db_post_id = $res['id'];
        $db_category_id = $res['category_id'];
        $db_title = $res['title'];
        $db_summary = $res['summary'];
        $db_content = $res['content'];
        $db_status = $res['status'];
        $db_address = $res['img_address'];
    } else {
        echo "<h1>page not found</h1>";
        exit;
    }
}

// enter new inputs in database
if ((isset($_POST['title']) && $_POST['title'] != '') &&
    (isset($_POST['summary']) && $_POST['summary'] != '') &&
    (isset($_POST['content']) && $_POST['content'] != '') &&
    (isset($_FILES['file']) && $_FILES['file'] != '') &&
    (isset($_POST['status']) && $_POST['status'] != '') &&
    (isset($_POST['categories']) && $_POST['categories'] != '') &&
    ($_SERVER['REQUEST_METHOD'] == 'POST')
) {
    // check status
    if ($_POST['status'] === "active") $status = 1;
    if ($_POST['status'] === "disable") $status = 0;


    // check category name and id
    $cat_name_sql = "SELECT * FROM categories WHERE name = ?";
    $cat_name_stm = $conn->prepare($cat_name_sql);
    $cat_name_stm->execute([$_POST['categories']]);
    $cat_name_res = $cat_name_stm->fetch();
    $new_category_id = $cat_name_res['category_id'];

    // check file address
    $tmpfile = $_FILES['file']['tmp_name'];
    $newfile = '../assets/' . $_FILES['file']['name'];
    move_uploaded_file($tmpfile, $newfile);
    $fileaddress = "http://localhost/php_basic/02-ex/assets/" . $_FILES['file']['name'];


    $post_id = $_GET['edit_id'];
    $editsql = "UPDATE posts set category_id = ? , title = ? , summary = ? , content=? , status = ? , img_address = ? WHERE id =$db_post_id";
    $editstm = $conn->prepare($editsql);
    $editstm->execute([$new_category_id, $_POST['title'], $_POST['summary'], $_POST['content'], $status, $fileaddress]);
    header('locatin: http://localhost/php_basic/02-ex/panel/post.php');
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
            width: 600px;
            height: 650px;
            border: 1px solid gray;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: flex-start;
            padding: 5px;
        }

        textarea {
            width: 100%;

        }

        .img {
            width: 80px;
            height: 80px;
        }

        .img>img {
            width: 100%;
            height: 100%;
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
                <textarea name="title" placeholder="post title"><?= $db_title ?></textarea>
                <textarea name="summary" placeholder="post summary"> <?= $db_summary ?></textarea>
                <textarea name="content" id="content" placeholder="post content"> <?= $db_content ?></textarea>

                <?php
                if ($db_address != NULL) { ?>

                    <div class="img">
                        <img src="<?= $db_address ?>" alt="post image">
                    </div>

                <?php } ?>
                <input type="file" name="file" id="file" placeholder="post image">

                <label for="status">define post status</label>
                <select name="status" id="status">
                    <option value="active" <?php if ($db_status == 1) { ?> selected <?php } ?>>active</option>
                    <option value="disable" <?php if ($db_status == 0) { ?> selected <?php } ?>>disable</option>
                </select>

                <label for="categories">select category </label>
                <select name="categories" id="categories">
                    <?php
                    foreach ($result as $rr) {
                        $category_name = $rr['name'];
                        $category_id = $rr['category_id']; ?>
                        <option value="<?= $category_name ?>" <?php if ($db_category_id === $category_id) { ?> selected <?php } ?>><?= $category_name ?></option>
                    <?php } ?>
                </select>
                <input type="submit" value="enter" name="submit">
            </form>
        </div>
    </section>
</body>

</html>