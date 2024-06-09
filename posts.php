<?php
require_once('./functions/pdo_connect.php');
require_once('./functions/header.php');
?>

<?php
// select all items of posts table
$query = "SELECT * FROM posts";
$query_stm = $conn->prepare($query);
$query_stm->execute();
$query_result = $query_stm->fetchAll();
?>

<?php
// get content of a post with url adddress
foreach ($query_result as $qr) {
    $post_id = $qr['id'];
    if (isset($_GET['post_id']) && $_GET['post_id'] != NULL && $_GET['post_id'] == $post_id) {
        $sql = "SELECT * FROM posts WHERE id=$post_id";
        $sql_stm = $conn->prepare($sql);
        $sql_stm->execute();
        $sql_result = $sql_stm->fetchAll();
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
            grid-template-columns: repeat(2, 50%);

        }

        .news {
            width: 600px;
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
        foreach ($sql_result as $ss) {
            $title = $ss['title'];
            $summary = $ss['summary'];
            $content = $ss['content']; ?>
            <div class="news">
                <div class='img'></div>
                <h3><?= $title ?></h3>
                <p><?= $summary ?></p>
                <h4><?=$content?></h4>
            </div>
        <?php } ?>
    </section>
</body>

</html>