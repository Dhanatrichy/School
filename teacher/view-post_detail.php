<?php
include('includes/database.php');

$query = "SELECT * FROM tbl_post where id='" . base64_decode($_GET['id']) . "'";
$result = mysqli_query($db, $query);
$count = mysqli_num_rows($result);
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        extract($row);
        if ($author_type == 'school') {
            $author_name = get_particular_name('name', $author_id, 'tbl_school', 'id');
            $image = '../school/uploads/posts/' . $image;
        } else if ($author_type == 'teacher') {
            $author_name = get_particular_name('name', $author_id, 'tbl_teacher', 'id');
            $image = 'uploads/posts/' . $image;
        }
    }
    
    // Gets likes id regarding User Type
    $query_get_likes_id = "select DISTINCT(user_id) from tbl_post_like where post_id='" . $id . "' and user_type='".$_SESSION['user_type']."'";
    $run_likes_id = mysqli_query($db, $query_get_likes_id);
    if (mysqli_num_rows($run_likes_id) > 0) {
        while ($row_likes_id = mysqli_fetch_assoc($run_likes_id)) {
            $liked_user_ids[] =   $row_likes_id['user_id'];
        }
    }
    
    $like_count =   give_count('tbl_post_like','post_id',$id);
    $comment_count  =   give_count('tbl_post_comment','post_id',$id);
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Post Detail | LMS</title>

        <?php include_once 'includes/header.php'; ?>
        <style>
            .post strong{
                padding-left:5%;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed text-sm">
        <div class="wrapper">

            <?php include_once 'includes/topnav.php'; ?>
            <?php include_once 'includes/leftnav.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">View Post Detail</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">View Post Detail</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="dist/img/user.png" alt="user image">
                                                <span class="username">
                                                    <a href="#"><?php echo $author_name; ?></a>
                                                </span>
                                                <span class="description"><?php echo date("F j, Y", $addedon); ?></span>
                                            </div>
                                            <div class="col-sm-12 text-center">
                                                <img class="img-fluid" src="<?php echo $image; ?>" height="50%" alt="Photo">
                                            </div>
                                            <br /><br />
                                            <div class="col-sm-12">
                                                <p><?php echo html_entity_decode($description); ?></p>
                                            </div>
                                            
                                            <p>
                                                <?php if ($allow_like == 'Yes') { ?>
                                                <a href="javascript:void(0);" onclick="post_like(<?php echo $id; ?>)" class="link-black text-sm like_counts_here">
                                                    <?php if(in_array($_SESSION['school_id'], $liked_user_ids)){ ?>
                                                        (<?php echo $like_count; ?>) <i class="fas fa-thumbs-up"></i> Liked
                                                    <?php }else{ ?>
                                                        (<?php echo $like_count; ?>) <i class="far fa-thumbs-up mr-1"></i> Like
                                                    <?php } ?>
                                                </a> 
                                                <?php } ?>
                                                <?php if ($allow_comment == 'Yes') { ?>
                                                <span class="float-right">
                                                    <a href="javascript:void(0);" class="link-black text-sm comment_counts_here">
                                                        <i class="far fa-comments mr-1"></i> Comments (<?php echo $comment_count; ?>)
                                                    </a>
                                                </span>
                                                <?php } ?>
                                            </p>
                                            
                                            <?php if ($allow_comment == 'Yes') { ?>
                                            <form method="post" id="comment_form">
                                                <input class="form-control form-control-sm" type="text" placeholder="Type a comment" id="comment_box">
                                                <input type="hidden" id="post_id" value="<?php echo $id; ?>" />
                                                <button type="button" style="display:none;" class="btn btn-default"><i class="fas fa-paper-plane"></i></button>
                                            </form>
                                            <?php } ?>
                                        </div>
                                        <?php if ($allow_comment == 'Yes') { ?>
                                            <div class="post_comments"></div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card -->
                    </div><!-- /.container-fluid -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include_once 'includes/footer.php'; ?>
        </div>
        <!-- ./wrapper -->

        <?php include_once 'includes/footer_links.php'; ?>
        
    </body>
</html>
