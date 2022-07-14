<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'post_like') {
    extract($_POST);
    $time   =   time();

    $sql = "SELECT * FROM tbl_post_like where post_id='" . $id . "' and user_type='".$_SESSION['user_type']."' and user_id='".$_SESSION['school_id']."'";
    $run = mysqli_query($db, $sql);
    $count = mysqli_num_rows($run);
    if ($count > 0) {
         $delete =   "delete from tbl_post_like where post_id='" . $id . "' and user_type='".$_SESSION['user_type']."' and user_id='".$_SESSION['school_id']."'";
        $run_delete =   mysqli_query($db, $delete);
        if(mysqli_affected_rows($db)>0){
            $likes      =   give_count('tbl_post_like', 'post_id', $id);
            echo json_encode(['status' => 'true', 'likes' => $likes, 'msg' => 'You Disliked This Post', 'result' => 'Operation Complete']);
        }
    }else{
        $insert =   "insert into tbl_post_like(post_id,user_type,user_id,datetime,addedon)values('" . $id . "','" . $_SESSION['user_type'] . "','" . $_SESSION['school_id'] . "','" . date("Y-m-d H:i:s", $time) . "','" . $time . "')";
        $run_insert =   mysqli_query($db, $insert);
        if(mysqli_insert_id($db)>0){
            $likes      =   give_count('tbl_post_like', 'post_id', $id);
            echo json_encode(['status' => 'true', 'likes' => $likes, 'msg' => 'You Liked This Post', 'result' => 'Operation Complete']);
        }
    }
}
?>