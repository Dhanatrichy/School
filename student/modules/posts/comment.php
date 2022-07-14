<?php
include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'post_comment') {
    extract($_POST);
    $time = time();

    $insert = "insert into tbl_post_comment(post_id,user_type,user_id,comment,datetime,addedon)values('" . $post_id . "','" . $_SESSION['user_type'] . "','" . $_SESSION['student_id'] . "','" . $comment_box . "','" . date("Y-m-d H:i:s", $time) . "','" . $time . "')";
    $run_insert = mysqli_query($db, $insert);
    if (mysqli_insert_id($db) > 0) {
        
        // Gets comments id regarding User Type
        $query_get_comments_id = "select DISTINCT(post_comment_id) from tbl_post_comment where post_id='" . $post_id . "' and user_type='".$_SESSION['user_type']."' and user_id='".$_SESSION['student_id']."'";
        $run_comments_id = mysqli_query($db, $query_get_comments_id);
        if (mysqli_num_rows($run_comments_id) > 0) {
            while ($row_comments_id = mysqli_fetch_assoc($run_comments_id)) {
                $comments_ids[] =   $row_comments_id['post_comment_id'];
            }
        }

        // Gets comments regarding Post
        $query_comments = "select * from tbl_post_comment where post_id='" . $post_id . "' order by addedon DESC";
        $run_comments = mysqli_query($db, $query_comments);
        if (mysqli_num_rows($run_comments) > 0) {
            while ($row_comments = mysqli_fetch_assoc($run_comments)) {
                if ($row_comments['user_type'] == 'school') {
                    $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_school', 'id');
                } else if ($row_comments['user_type'] == 'teacher') {
                    $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_teacher', 'id');
                } else if ($row_comments['user_type'] == 'student') {
                    $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_student', 'id');
                }
                ?>        

                <div class="post">
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user.png" alt="user image">
                        <span class="username">
                            <?php if(in_array($row_comments['post_comment_id'], $comments_ids)){ ?>
                            <span class="pull-right" style="float:right"><i class="fas fa-times-circle" onclick="delete_comment(<?php echo $row_comments['post_comment_id']; ?>,<?php echo $post_id; ?>)"></i></span>
                            <?php } ?>
                            <a href="javascript:void(0);"><?php echo $user_name; ?></a>
                        </span>
                        <span class="description"><?php echo date("F j, Y", $row_comments['addedon']); ?></span>
                    </div>
                    <!-- /.user-block -->
                    <strong>
                        <?php echo $row_comments['comment']; ?>
                    </strong>
                </div>
                <?php
            }
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete_comment') {
    extract($_POST);
    $time = time();

    $delete = "delete from tbl_post_comment where post_comment_id='".$post_comment_id."'";
    $run_delete = mysqli_query($db, $delete);
    if (mysqli_affected_rows($db) > 0) {
        
        // Gets comments id regarding User Type
        $query_get_comments_id = "select DISTINCT(post_comment_id) from tbl_post_comment where post_id='" . $post_id . "' and user_type='".$_SESSION['user_type']."' and user_id='".$_SESSION['student_id']."'";
        $run_comments_id = mysqli_query($db, $query_get_comments_id);
        if (mysqli_num_rows($run_comments_id) > 0) {
            while ($row_comments_id = mysqli_fetch_assoc($run_comments_id)) {
                $comments_ids[] =   $row_comments_id['post_comment_id'];
            }
        }

        // Gets comments regarding Post
        $query_comments = "select * from tbl_post_comment where post_id='" . $post_id . "' order by addedon DESC";
        $run_comments = mysqli_query($db, $query_comments);
        if (mysqli_num_rows($run_comments) > 0) {
            while ($row_comments = mysqli_fetch_assoc($run_comments)) {
                if ($row_comments['user_type'] == 'school') {
                    $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_school', 'id');
                } else if ($row_comments['user_type'] == 'teacher') {
                    $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_teacher', 'id');
                } else if ($row_comments['user_type'] == 'student') {
                    $user_name = get_particular_name('name', $row_comments['user_id'], 'tbl_student', 'id');
                }
                ?>        

                <div class="post">
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user.png" alt="user image">
                        <span class="username">
                            <?php if(in_array($row_comments['post_comment_id'], $comments_ids)){ ?>
                            <span class="pull-right" style="float:right"><i class="fas fa-times-circle" onclick="delete_comment(<?php echo $row_comments['post_comment_id']; ?>,<?php echo $post_id; ?>)"></i></span>
                            <?php } ?>
                            <a href="javascript:void(0);"><?php echo $user_name; ?></a>
                        </span>
                        <span class="description"><?php echo date("F j, Y", $row_comments['addedon']); ?></span>
                    </div>
                    <!-- /.user-block -->
                    <strong>
                        <?php echo $row_comments['comment']; ?>
                    </strong>
                </div>
                <?php
            }
        }
    }
}

?>