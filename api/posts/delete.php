<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'post_delete')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $post_id = $data['post_id'];
        $author_type = $data['author_type'];
        $author_id = $data['author_id'];
        $time = time();

        $delete = "delete from tbl_post where id='" . $post_id . "'";
        $run_delete = mysqli_query($db, $delete);
        if (mysqli_affected_rows($db) > 0) {
            
            $delete_post_like       = "delete from tbl_post_like where post_id='" . $post_id . "'";
            $run_delete_post_like   = mysqli_query($db, $delete_post_like);
            
            $delete_comment       = "delete from tbl_post_comment where post_id='" . $post_id . "'";
            $run_delete_comment   = mysqli_query($db, $delete_comment);
            
            echo json_encode(['status' => 'true', 'msg' => 'Post Deleted Successfully', 'result' => 'Operation Complete']);
        }

    }
}
?>
