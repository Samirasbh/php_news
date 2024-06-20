<?php
require_once('../functions/pdo_connect.php');
session_start();
if (!isset($_SESSION['login'])) {
    header('location:http://localhost/php_basic/02-ex/login.php');
}
// select posts and category name
$query = "SELECT * FROM posts as p INNER JOIN categories as c WHERE p.category_id = c.category_id AND deleted_at IS NULL ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();
$res = $stmt->fetchAll();

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

        button,
        .active,
        .disable {
            display: block;
            padding: 2px;
            margin: 5px;
            padding: 5px;
            border: 1px solid gray;
            background-color: #fff;
            border-radius: 5px;
        }

        .active {
            color: green;
        }

        .disable {
            color: red;
        }

        a:hover {
            cursor: pointer;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
</head>

<body>
    <header>
        <a href="./index.php" class="logo">
            <img src="../assets/logo.jpg" alt="page logo">
        </a>
        <a href="../login.php">logout</a>
    </header>
    <section>
        <!-- left side in panel -->
        <div class="dashboard">
            <h3>you logged in</h3>
            <h4>welcom to admin panel </h4>
            <form method="get" class="show_btns">
                <a href="http://localhost/php_basic/02-ex/panel/category.php"> categories</a>
                <a href="http://localhost/php_basic/02-ex/panel/post.php">posts</a>
            </form>
        </div>
        <!-- main section - right side in panel -->
        <div class="context">
            <div class="post_heading">
                <h2 id="get">posts</h2>
                <a href="http://localhost/php_basic/02-ex/panel/create.php">create</a>
            </div>

            <table>
                <!-- table headings -->
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
                <!-- make dynamic table rows for each row in database -->
                <?php
                $count = 1;
                foreach ($res as $r) {
                    $id = $r['id'];
                    $title = $r['title'];
                    $summary = $r['summary'];
                    $content = $r['content'];
                    $img_address = $r['img_address'];
                    $category_name = $r['name'];
                    $status = $r['status'];
                ?>
                    <tr id="row-<?= $id ?>">
                        <td><?= $count ?></td>
                        <td><?= $title ?></td>
                        <td><?= $summary ?></td>
                        <td><?= $content ?></td>
                        <td class="image">
                            <img src="<?= $img_address ?>" alt="post image">
                        </td>
                        <td><?= $category_name ?></td>
                        <!-- status column of each row -->
                        <td>
                            <div <?php if ($status === 1) { ?> class="active" id="active-<?= $id ?>" <?php }
                                if ($status === 0) { ?> class="disable" id="disable-<?= $id ?>" <?php } ?>>

                                <?php if ($status === 1) { ?>active<?php } ?>
                                <?php if ($status === 0) { ?>disable<?php } ?>
                            </div>


                        </td>
                        <!-- function column -->
                        <td>
                            <a href="http://localhost/php_basic/02-ex/panel/edit.php?edit_id=<?= $id ?>">edit</a>
                            <a href="http://localhost/php_basic/02-ex/panel/delete.php?post_id=<?=$id?>">delete</a>
                            <a class="sts-btn" id="sts-<?= $id ?>">change status</a>
                        </td>
                    </tr>
                <?php 
                  $count++;
                } ?>
            </table>
        </div>
    </section>

    <script>
        // axios code for change status
        var status_list = document.querySelectorAll('.sts-btn');
        status_list.forEach((el) => {
            el.addEventListener('click', (e) => {
                change_status(el.id);
            })
        })
        // change status function
        function change_status(id) {

            axios.get(`http://localhost/php_basic/02-ex/functions/change_status.php?id=${id}`)
                .then(function(response) {
                    console.log(response);
                    if (response.data.status == "disable") {
                        idd = id.split("-");
                        post_id = idd[1];
                        a = document.getElementById(`active-${post_id}`);
                        a.id = `disable-${post_id}`;
                        a.innerText = "disable";
                        a.className = "disable";
                    }
                    if (response.data.status == "active") {
                        idd = id.split("-");
                        post_id = idd[1];
                        b = document.getElementById(`disable-${post_id}`);
                        b.id = `active-${post_id}`;
                        b.innerText = "active";
                        b.className = "active";
                    }
                })
        }
    </script>
</body>

</html>