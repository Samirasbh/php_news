<?php
require_once("./functions/pdo_connect.php");
require_once("./functions/header.php");
?>
<?php
// select items from database table categories
    $read_query = "SELECT * FROM categories";
    $read_stm = $conn->prepare($read_query);
    $read_stm->execute();
    $read_result = $read_stm->fetchAll();
?>

<?php
// select items from databace tables post and categories
$show_sql = "SELECT *,id FROM posts p INNER JOIN categories c ON p.category_id = c.category_id";
$show_stm = $conn->prepare($show_sql);
$show_stm->execute();
$show_result = $show_stm->fetchAll();
?>

<?php
// get posts of a category with url address
foreach ($read_result as $rr) {
    $category_name = $rr['name'];
    $category_id = $rr['category_id'];
    if (isset($_GET['category_id']) && $_GET['category_id'] != NULL && $_GET['category_id'] == $category_id) {
        $sql = "SELECT * from posts WHERE category_id=$category_id";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $stm_res = $stm->fetchAll();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        section {
            padding: 10px 40px;
            width: 100vw;
            height: auto;
            display: grid;
            grid-template-columns: repeat(4, 20%);

        }

        .news {
            width: 250px;
            height: 300px;
            text-decoration: none;
            color: #000;
        }

        .news:hover {
            cursor: pointer;
            opacity: 0.5;
        }

        .img {
            height: 10%;
            background-color: skyblue;
        }
    </style>
</head>

<body>
    <section>
        <?php
        foreach ($stm_res as $r) {
            $status = $r['status'];
            $post_id = $r['id'];
            $title = $r['title'];
            $summary = $r['summary'];
            if($status ===1){
        ?>
            <a class='news' href='http://localhost/php_basic/02-ex/posts.php?post_id=<?=$post_id?>'>
                <div class='img'></div>
                <h3><?= $title ?></h3>
                <p><?= $summary ?></p>
            </a>
        <?php } }
        ?>
    </section>
</body>

</html>