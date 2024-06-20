<?php
require_once('../functions/pdo_connect.php');
// categories
session_start();
if (!isset($_SESSION['login'])) {
    header('http://localhost/php_basic/02-ex/login.php');
}
$query = 'SELECT * FROM categories WHERE category_deleted_at IS NULL  ';
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();
?>
<!-- add to categories -->
 <?php
        if(isset($_POST['name']) && $_POST['name']!='' ){
            $statement = $conn->prepare('INSERT INTO categories SET name =?');
            $statement->execute([$_POST['name']]);
        }
        ?>
<!-- delete category -->
<?php
if (isset($_GET['post_id']) && $_GET['post_id'] != NULL) {
    $stm = $conn->prepare("UPDATE categories SET category_deleted_at = now() WHERE category_id = ?");
    $stm->execute([$_GET['post_id']]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
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

        .context {
            padding: 20px;
        }

        table {
            width: 500px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
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

        a:hover {
            cursor: pointer;
        }

        .category_heading {
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
        }

        .add_form {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            margin: 30px;
        }

        input {
            margin: 10px;
        }
    </style>
</head>

<body>
    <header>
        <a href="#" class="logo">
            <img src="../assets/logo.jpg" alt="page logo">
        </a>
        <a href="../login.php">logout</a>
    </header>
    <section>
        <div class="dashboard">
            <h3>you logged in</h3>
            <h4>welcom to admin panel </h4>
            <form method="get" class="show_btns">
                <a href="http://localhost/php_basic/02-ex/panel/category.php"> categories</a>
                <a href="http://localhost/php_basic/02-ex/panel/post.php">posts</a>
            </form>
        </div>
        <div class="context">
            <div class="category_heading">
                <h2>category</h2>
                <a id="add">add</a>
            </div>
            <table>
                <tr>
                    <th>#</th>
                    <th>category name</th>
                    <th>function</th>
                </tr>
                <?php
                $count = 1;
                foreach ($result as $r) {
                    $id = $r['category_id'];
                    $category_name = $r['name'];
                ?>
                    <tr id="row-<?= $id ?>">
                        <td><?= $count ?></td>
                        <td><?= $category_name ?></td>
                        <td>
                            <a class="edit-btn" id="edit<?= $id ?>">edit</a>
                            <a href="http://localhost/php_basic/02-ex/panel/category.php?post_id=<?= $id ?>">delete</a>
                        </td>
                    </tr>
                <?php
                    $count++;
                } ?>
            </table>
        </div>
        <!-- <form class="add_form" method="post">
            <label for="name">enter categoty name</label>
            <input type="text" name="name" id="name">
            <input type="submit" value="enter">
        </form> -->
       
    </section>
</body>

</html>