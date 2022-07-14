<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'insert_post_comment')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $post_id = $data['post_id'];
        $user_type = $data['user_type'];
        $user_id = $data['user_id'];
        $comment = $data['comment'];
        $time   =   time();

        
//        $post_id = 6;
//        $user_type = 'student';
//        $user_id = 1;
//        $comment = 'my comment';
        
        $insert =   "insert into tbl_post_comment(post_id,user_type,user_id,comment,datetime,addedon)values('" . $post_id . "','" . $user_type . "','" . $user_id . "','".$comment."','" . date("Y-m-d H:i:s", $time) . "','" . $time . "')";
        $run_insert =   mysqli_query($db, $insert);
        if(mysqli_insert_id($db)>0){
            
            // Gets comments regarding Post
            $query_comments = "select * from tbl_post_comment where post_id='" . $post_id . "'";
            $run_comments = mysqli_query($db, $query_comments);
            if (mysqli_num_rows($run_comments) > 0) {
                while ($row_comments = mysqli_fetch_assoc($run_comments)) {
                    if($row_comments['user_type']=='school'){
                        $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_school', 'id');
                    }else if($row_comments['user_type']=='teacher'){
                        $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_teacher', 'id');
                    }else if($row_comments['user_type']=='student'){
                        $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_student', 'id');
                    }

                    $comments_list[] =  array(
                        'post_comment_id' => $row_comments['post_comment_id'],
                        'post_id' => $row_comments['post_id'],
                        'user_type' => $row_comments['user_type'],
                        'user_id' => $row_comments['user_id'],
                        'user_name'=> $user_name,
                        'comment'    => $row_comments['comment'],
                        'datetime' => $row_comments['datetime'],
                        'addedon' => $row_comments['addedon'],
                        'status' => ucfirst($row_comments['status'])
                    );
                }
            }
            
            echo json_encode(['status' => 'true', 'msg' => 'You Comment on This Post', 'comments_list' => $comments_list, 'result' => 'Operation Complete']);
        }
    }
    
    if (($_GET["action"] == 'delete_post_comment')) {
        
        $data = json_decode(file_get_contents("php://input"), TRUE);
        $post_id = $data['post_id'];
        $post_comment_id = $data['post_comment_id'];
        $time   =   time();
        
//        $post_id = 6;
//        $post_comment_id = 6;
        
        $delete =   "delete from tbl_post_comment where post_comment_id='" . $post_comment_id . "'";
        $run_delete =   mysqli_query($db, $delete);
        if(mysqli_affected_rows($db)>0){
            
            // Gets comments regarding Post
            $query_comments = "select * from tbl_post_comment where post_id='" . $post_id . "'";
            $run_comments = mysqli_query($db, $query_comments);
            if (mysqli_num_rows($run_comments) > 0) {
                while ($row_comments = mysqli_fetch_assoc($run_comments)) {
                    if($row_comments['user_type']=='school'){
                        $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_school', 'id');
                    }else if($row_comments['user_type']=='teacher'){
                        $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_teacher', 'id');
                    }else if($row_comments['user_type']=='student'){
                        $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_student', 'id');
                    }

                    $comments_list[] =  array(
                        'post_comment_id' => $row_comments['post_comment_id'],
                        'post_id' => $row_comments['post_id'],
                        'user_type' => $row_comments['user_type'],
                        'user_id' => $row_comments['user_id'],
                        'user_name'=> $user_name,
                        'comment'    => $row_comments['comment'],
                        'datetime' => $row_comments['datetime'],
                        'addedon' => $row_comments['addedon'],
                        'status' => ucfirst($row_comments['status'])
                    );
                }
            }
            
            
            echo json_encode(['status' => 'true', 'msg' => 'You Deleted This Comment', 'comments_list' => $comments_list, 'result' => 'Operation Complete']);
        }
        
    }
    
}
?>
