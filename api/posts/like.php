<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'post_like')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $post_id = $data['post_id'];
        $user_type = $data['user_type'];
        $user_id = $data['user_id'];
        $time   =   time();

        
//        $post_id = 44;
//        $user_type = 'my_type';
//        $user_id = 44;
        
        
        $query = "select * from tbl_post_like where post_id='" . $post_id . "' and user_type='" . $user_type . "' and user_id='" . $user_id . "'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            $delete =   "delete from tbl_post_like where post_id='" . $post_id . "' and user_type='" . $user_type . "' and user_id='" . $user_id . "'";
            $run_delete =   mysqli_query($db, $delete);
            if(mysqli_affected_rows($db)>0){
                $likes      =   give_count('tbl_post_like', 'post_id', $post_id);
                echo json_encode(['status' => 'true', 'likes' => $likes, 'msg' => 'You Disliked This Post', 'result' => 'Operation Complete']);
            }
        }else{
            $insert =   "insert into tbl_post_like(post_id,user_type,user_id,datetime,addedon)values('" . $post_id . "','" . $user_type . "','" . $user_id . "','" . date("Y-m-d H:i:s", $time) . "','" . $time . "')";
            $run_insert =   mysqli_query($db, $insert);
            if(mysqli_insert_id($db)>0){
                $likes      =   give_count('tbl_post_like', 'post_id', $post_id);
                echo json_encode(['status' => 'true', 'likes' => $likes, 'msg' => 'You Liked This Post', 'result' => 'Operation Complete']);
            }
        }
        
    }
}
?>
