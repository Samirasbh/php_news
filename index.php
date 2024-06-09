<?php
require_once("./functions/pdo_connect.php");
require_once("./functions/header.php");

?>
<?php
// select items from databace tables post and categories
$show_sql = "SELECT * , id FROM posts p INNER JOIN categories c ON p.category_id = c.category_id";
$show_stm = $conn->prepare($show_sql);
$show_stm->execute();
$show_result = $show_stm->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>news</title>

    <style>
        section {
            padding: 10px 40px;
            width: 100vw;
            height: auto;
            display: grid;
            grid-template-columns: repeat(4, 20%);

        }

        .news {
            display: block;
            width: 250px;
            height: 300px;
            text-decoration: none;
            color: #000;
            margin: 20px;
        }

        .news:hover {
            cursor: pointer;
            opacity: 0.5;
        }

        .img {
            height: 40%;
            background-color: skyblue;
        }
        .img>img{
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <section>
        <?php
        foreach ($show_result as $sr) {
            $status = $sr['status'];
            $post_id = $sr['id'];
            $title = $sr['title'];
            $summary = $sr['summary'];
            $address = $sr['img_address'];
            $category_name = $sr['name'];
            if($status ===1){
        ?>
            <a class='news' href='http://localhost/php_basic/02-ex/posts.php?post_id=<?=$post_id?>'>
                <div class='img'>
                    <img src="<?=$address?>" alt="post image">
                </div>
                <h3><?=$title?></h3>
                <p><?=$summary?></p>
                <h4><?="category: ".$category_name?></h4>
            </a>
        <?php } }?>
    </section>
</body>

</html>