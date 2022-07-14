<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'save_post')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $post_id = $data['post_id'];
        $user_type = $data['user_type'];
        $user_id = $data['user_id'];
        $time = time();


//        $post_id = 44;
//        $user_type = 'my_type';
//        $user_id = 44;


        $query = "select * from tbl_saved_post where post_id='" . $post_id . "' and user_type='" . $user_type . "' and user_id='" . $user_id . "'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            $delete = "delete from tbl_saved_post where post_id='" . $post_id . "' and user_type='" . $user_type . "' and user_id='" . $user_id . "'";
            $run_delete = mysqli_query($db, $delete);
            if (mysqli_affected_rows($db) > 0) {
                echo json_encode(['status' => 'true', 'msg' => 'You Unsaved This Post', 'result' => 'Operation Complete']);
            }
        } else {
            $insert = "insert into tbl_saved_post(post_id,user_type,user_id,datetime,addedon)values('" . $post_id . "','" . $user_type . "','" . $user_id . "','" . date("Y-m-d H:i:s", $time) . "','" . $time . "')";
            $run_insert = mysqli_query($db, $insert);
            if (mysqli_insert_id($db) > 0) {
                echo json_encode(['status' => 'true', 'msg' => 'You Saved This Post', 'result' => 'Operation Complete']);
            }
        }
    }


    if (($_GET["action"] == 'get_saved_posts')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $user_id = $data['user_id'];
        $user_type = $data['user_type'];

        $get_saved_post = "select * from tbl_saved_post where user_id='" . $user_id . "' and user_type='" . $user_type . "'";
        $run_saved_post = mysqli_query($db, $get_saved_post);
        if (mysqli_num_rows($run_saved_post) > 0) {
            while ($row_saved_post = mysqli_fetch_assoc($run_saved_post)) {

                $query = "select * from tbl_post where id='" . $row_saved_post['post_id'] . "'";
                $run = mysqli_query($db, $query);
                $count = mysqli_num_rows($run);
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($run)) {
                        if ($row['author_type'] == 'school') {
                            //$image  =   'http://ahadigischools.in/school/uploads/posts/'.$row['image'];
                            $author_name = get_particular_name('name', $row['author_id'], 'tbl_school', 'id');
                        } else if ($row['author_type'] == 'teacher') {
                            //$image  =   'http://ahadigischools.in/teacher/uploads/posts/'.$row['image'];
                            $author_name = get_particular_name('name', $row['author_id'], 'tbl_teacher', 'id');
                        }


                        // Gets likes id regarding User Type
                        $query_get_likes_id = "select DISTINCT(user_id) from tbl_post_like where post_id='" . $row['id'] . "' and user_type='" . $user_type . "'";
                        $run_likes_id = mysqli_query($db, $query_get_likes_id);
                        if (mysqli_num_rows($run_likes_id) > 0) {
                            while ($row_likes_id = mysqli_fetch_assoc($run_likes_id)) {
                                $liked_user_ids[] = $row_likes_id['user_id'];
                            }
                        }

                        //print_r($liked_user_ids);

                        $likes = give_count('tbl_post_like', 'post_id', $row['id']);
                        $comments = give_count('tbl_post_comment', 'post_id', $row['id']);


                        $arr[] = array(
                            'id' => $row['id'],
                            'school_id' => $row['school_id'],
                            'author_id' => $row['author_id'],
                            'author_name' => $author_name,
                            'author_type' => $row['author_type'],
                            'likes' => $likes,
                            'comments' => $comments,
                            'liked_ids' => $liked_user_ids,
                            'title' => $row['title'],
                            'image' => $row['image'],
                            'description' => html_entity_decode($row['description']),
                            'allow_like' => $row['allow_like'],
                            'allow_comment' => $row['allow_comment'],
                            'datetime' => $row['datetime'],
                            'addedon' => $row['addedon'],
                            'status' => ucfirst($row['status'])
                        );
                        
                        unset($liked_user_ids);
                    }
                    //echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
                }
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'No Post Yet', 'result' => 'Data Not Found']);
        }
    }
}
?>
