<?php

include_once('../database.php');


$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'get_posts')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $id =   $data['id'];
        $user_type = $data['user_type'];

        $query = "select * from tbl_post where school_id='" . $id . "' and status='active' ORDER BY addedon DESC";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                if($row['author_type']=='school'){
                    //$image  =   'http://ahadigischools.in/school/uploads/posts/'.$row['image'];
                    $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_school', 'id');
                }else if($row['author_type']=='teacher'){
                    //$image  =   'http://ahadigischools.in/teacher/uploads/posts/'.$row['image'];
                    $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_teacher', 'id');
                }
                
                
                // Gets likes id regarding User Type
                $query_get_likes_id = "select DISTINCT(user_id) from tbl_post_like where post_id='" . $row['id'] . "' and user_type='".$user_type."'";
                $run_likes_id = mysqli_query($db, $query_get_likes_id);
                if (mysqli_num_rows($run_likes_id) > 0) {
                    while ($row_likes_id = mysqli_fetch_assoc($run_likes_id)) {
                        $liked_user_ids[] =   $row_likes_id['user_id'];
                    }
                }
                
                //print_r($liked_user_ids);

                $likes      =   give_count('tbl_post_like', 'post_id', $row['id']);
                $comments   =   give_count('tbl_post_comment', 'post_id', $row['id']);
                
                
                $arr[] = array(
                    'id' => $row['id'],
                    'school_id' => $row['school_id'],
                    'author_id' => $row['author_id'],
                    'author_name' => $author_name,
                    'author_type' => $row['author_type'],
                    'likes'       => $likes,
                    'comments'    => $comments,
                    'liked_ids'   => $liked_user_ids,
                    'title' => $row['title'],
                    'image' => $row['image'],
                    'description' => html_entity_decode($row['description']),
                    'allow_like' => $row['allow_like'],
                    'allow_comment' => $row['allow_comment'],
                    'datetime' => $row['datetime'],
                    'addedon' => humanTiming($row['addedon']),
                    'status' => ucfirst($row['status'])
                );
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'No Post Yet', 'result' => 'Data Not Found']);
        }
    }
    
    if (($_GET["action"] == 'get_post_detail')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $id =   $data['id'];
        $user_type = $data['user_type'];

        $query = "select * from tbl_post where id='" . $id . "'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                if($row['author_type']=='school'){
                    //$image  =   'http://ahadigischools.in/school/uploads/posts/'.$row['image'];
                    $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_school', 'id');
                }else if($row['author_type']=='teacher'){
                    //$image  =   'http://ahadigischools.in/teacher/uploads/posts/'.$row['image'];
                    $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_teacher', 'id');
                }
                
                // Gets likes id regarding User Type
                $query_get_likes_id = "select DISTINCT(user_id) from tbl_post_like where post_id='" . $row['id'] . "' and user_type='".$user_type."'";
                $run_likes_id = mysqli_query($db, $query_get_likes_id);
                if (mysqli_num_rows($run_likes_id) > 0) {
                    while ($row_likes_id = mysqli_fetch_assoc($run_likes_id)) {
                        $liked_user_ids[] =   $row_likes_id['user_id'];
                    }
                }
                
                $likes      =   give_count('tbl_post_like', 'post_id', $row['id']);
                $comments   =   give_count('tbl_post_comment', 'post_id', $row['id']);
                
                // Gets comments regarding Post
                $query_comments = "select * from tbl_post_comment where post_id='" . $row['id'] . "'";
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
                            'addedon' => humanTiming($row_comments['addedon']),
                            'status' => ucfirst($row_comments['status'])
                        );
                    }
                }
                
                $arr[] = array(
                    'id' => $row['id'],
                    'school_id' => $row['school_id'],
                    'author_id' => $row['author_id'],
                    'author_name' => $author_name,
                    'author_type' => $row['author_type'],
                    'likes'       => $likes,
                    'comments'    => $comments,
                    'title' => $row['title'],
                    'image' => $row['image'],
                    'description' => html_entity_decode($row['description']),
                    'allow_like' => $row['allow_like'],
                    'allow_comment' => $row['allow_comment'],
                    'liked_ids'   => $liked_user_ids,
                    'comments_list' => $comments_list,
                    'datetime' => $row['datetime'],
                    'addedon' => humanTiming($row['addedon']),
                    'status' => ucfirst($row['status'])
                );
                
                unset($liked_user_ids);
                unset($comments_list);
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'No Result Found', 'result' => 'Data Not Found']);
        }
    }
}
?>
