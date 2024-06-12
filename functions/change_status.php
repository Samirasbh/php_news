


<?php
require_once('pdo_connect.php');
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id = explode("-", $_GET['id']);
    $post_id = (int)$id[1];

    $sql = "SELECT * FROM posts WHERE id=?";
    $stm = $conn->prepare($sql);
    $stm->execute([$post_id]);
    $res = $stm->fetch();

    if ($res['status'] === 1) {
        $q = $conn->prepare("UPDATE posts SET status = 0 WHERE id=$post_id");
        $q->execute();
           $value = [
            "status"=>"disable"
           ];
    }
    if ($res['status'] === 0) {
        $q = $conn->prepare("UPDATE posts SET status = 1 WHERE id=$post_id");
        $q->execute();
        $value = [
            "status"=>"active"
           ];

    }
}
echo json_encode($value);
?>