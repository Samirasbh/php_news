


<?php
require_once('pdo_connect.php');
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id = explode("-", $_GET['id']);
    $post_id = (int)$id[1];

    $query = "DELETE FROM posts WHERE id = ?";
    $stm = $conn->prepare($query);
    $stm->execute([$post_id]);
}
$data = [
    "status" => "deleted"
];
echo json_encode($data);
?>