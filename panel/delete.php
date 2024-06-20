<?php

require_once('../functions/pdo_connect.php');
if (isset($_GET['post_id']) && $_GET['post_id'] != NULL) {
    $query = "UPDATE posts SET deleted_at = now() , status = 0 WHERE id = ?";
    $stm = $conn->prepare($query);
    $stm->execute([$_GET['post_id']]);
    header('location:http://localhost/php_basic/02-ex/panel/post.php');
}
?>