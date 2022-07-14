<?php
include('includes/database.php');

$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_post where id='" . $id . "'";
    $max2 = mysqli_query($db, $max);
    $max3 = mysqli_fetch_assoc($max2);
    extract($max3);
    $update = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Post | LMS</title>

        <?php include_once 'includes/header.php'; ?>
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
                                <h1 class="m-0">Add Post</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Add Post</li>
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
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Post</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="post_form" id="post_form" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Title *</label>
                                                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="single_image">Upload Image</label>
                                                        <input type="file" class="form-control" id="single_image" accept="image/*" name="single_image">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <?php if($image!=''){ ?>
                                                            <img src="uploads/posts/<?php echo $image; ?>" height="100" width="100" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="allow_like">Allow Likes</label>
                                                        <select class="form-control" name="allow_like" id="allow_like">
                                                            <option <?php if($allow_like=='Yes'){ ?> selected="selected" <?php } ?> value="Yes">Yes</option>
                                                            <option <?php if($allow_like=='No'){ ?> selected="selected" <?php } ?> value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="allow_comment">Allow Comments</label>
                                                        <select class="form-control" name="allow_comment" id="allow_comment">
                                                            <option <?php if($allow_comment=='Yes'){ ?> selected="selected" <?php } ?> value="Yes">Yes</option>
                                                            <option <?php if($allow_comment=='No'){ ?> selected="selected" <?php } ?> value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description *</label>
                                                        <textarea id="summernote" name="description">
                                                            <?php echo $description; ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
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
        
        <?php
        if (isset($_POST['submit'])) {
            extract($_POST);

            if ($title == "") {
                $errorMsg .= "Please Enter The Title.<br />";
            }

            if ($errorMsg != '') {
                echo "<script>";
                echo "toastr.error('" . $errorMsg . "')";
                echo "</script>";
            }


            if ($errorMsg == '') {
                $target_dir = "./uploads/posts/";
                $target_file = $target_dir . time() . basename($_FILES["single_image"]["name"]);
                if ($_FILES["single_image"]["name"] != "") {
                    $single_image = time() . basename($_FILES["single_image"]["name"]);
                    move_uploaded_file($_FILES["single_image"]["tmp_name"], $target_file);
                } else {
                    $single_image = $image;
                }

                if ($id != "") {
                    $data = $_POST;
                    $time = time();
                    $fields = array("title", "description", "allow_like", "allow_comment");
                    $static = ", image='" . $single_image . "', status='requested'";
                    $where = " id='" . $id . "'";
                    $update_id = update('tbl_post', $fields, $static, $data, $where);
                    if ($update_id) {

                        $success = "Updated Successfully.";
                        echo "<script>";
                        echo "toastr.success('Details has been Updated Successfully.')";
                        echo "</script>";
                    }
                } else {
                    $time = time();
                    $data = $_POST;
                    $fields = array("title", "description", "allow_like", "allow_comment");
                    $static = ", image='" . $single_image . "', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."', school_id='".$_SESSION['school_id']."', author_id='".$_SESSION['teacher_id']."', author_type='teacher', status='requested'";
                    $insert_id = insert('tbl_post', $fields, $static, $data, $floor, "");
                    if ($insert_id > 0) {

                        $success = "Added Successfully";
                        echo "<script>";
                        echo "toastr.success('Details has been Added Successfully.')";
                        echo "</script>";
                    }
                }
            }
        }
        ?>
        
    </body>
</html>
