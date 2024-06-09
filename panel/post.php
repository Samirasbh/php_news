<?php
require_once('../functions/pdo_connect.php');
session_start();
// select posts and category name
$query = "SELECT * FROM posts as p INNER JOIN categories as c WHERE p.category_id = c.category_id ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();
$res = $stmt->fetchAll();
if ($_SESSION['login'] === false) {
    echo "<h1>page not found</h1>";
}
else{
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
            height: auto;
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
            height: auto;
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

        table {
            width: 90%;
            margin-bottom: 20px;
        }

        .post_heading {
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        .image>img {
            width: 100%;
            height: 100%;
        }

        button {
            display: block;
            padding: 2px;
            margin: 5px;
            border-radius: 5px;
        }

        .active {
            color: green;
        }

        .disable {
            color: red;
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
            <div class="post_heading">
                <h2>posts</h2>
                <a href="http://localhost/php_basic/02-ex/panel/create.php">create</a>
            </div>

            <table>
                <tr>
                    <th style="width:2%">#</th>
                    <th style="width:10%">title</th>
                    <th style="width:20%">summary</th>
                    <th style="width:38%">content</th>
                    <th style="width:10%">image</th>
                    <th style="width:5%">category_name</th>
                    <th style="width:5%">status</th>
                    <th style="width:10% ">function</th>
                </tr>
                <?php
                foreach ($res as $r) {
                    $id = $r['id'];
                    $title = $r['title'];
                    $summary = $r['summary'];
                    $content = $r['content'];
                    $img_address = $r['img_address'];
                    $category_name = $r['name'];
                    $status = $r['status'];

                    // change status button
                    if ((isset($_GET['status_id'])) && $_GET['status_id'] != null && $_GET['status_id'] == $id) {
                        $ch_query = "SELECT * FROM posts WHERE id=?";
                        $ch_stm = $conn->prepare($ch_query);
                        $ch_stm->execute([$_GET['status_id']]);
                        $ch_res = $ch_stm->fetch();
                        if ($ch_res['status'] === 1) {
                            $q = $conn->prepare("UPDATE posts SET status = 0 WHERE id=$id");
                            $q->execute();
                        }
                        if ($ch_res['status'] === 0) {
                            $q = $conn->prepare("UPDATE posts SET status = 1 WHERE id=$id");
                            $q->execute();
                        }
                    }

                    // delete button
                    if ((isset($_GET['delete_id'])) && $_GET['delete_id'] != NULL && $_GET['delete_id'] == $id) {
                        $del_query = "DELETE FROM posts WHERE id = ?";
                        $del_stm = $conn->prepare($del_query);
                        $del_stm->execute([$_GET['delete_id']]);
                    }
                ?>

                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $title ?></td>
                        <td><?= $summary ?></td>
                        <td><?= $content ?></td>
                        <td class="image">
                            <img src="<?= $img_address ?>" alt="post image">
                        </td>
                        <td><?= $category_name ?></td>
                        <td>
                            <?php
                            if ($status === 1) { ?><button class="active">active</button>
                            <?php }
                            if ($status === 0) { ?><button class="disable">disable</button>
                            <?php } ?>

                        </td>
                        <td>
                            <a href="http://localhost/php_basic/02-ex/panel/edit.php?edit_id=<?= $id ?>">edit</a>
                            <a href="http://localhost/php_basic/02-ex/panel/post.php?delete_id=<?= $id ?>">delete</a>
                            <a href="http://localhost/php_basic/02-ex/panel/post.php?status_id=<?= $id ?>">change status</a>
                        </td>
                    </tr>



                <?php } ?>
            </table>
        </div>
    </section>
</body>

</html>
<?php } ?>