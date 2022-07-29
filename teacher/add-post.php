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
                                                        <input type="file" class="form-control" id="single_image" accept="audio/*,video/*,image/*" name="single_image">
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
                                                

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="audience_type">Select Audience Type*</label>
                                                        <select class="form-control select2" name="audience_type[]" id="audience_type" multiple placeholder="-- Select Audience Type --" value="<?php echo $udience_type; ?>">
                                                            <?php 
                                                                $assignAudience = array();
                                                                $audience_query = "SELECT * FROM tbl_assign_audience_post WHERE post_id = '".$id."' ";
                                                                $myAudience = mysqli_query($db, $audience_query);
                                                                while ($row = mysqli_fetch_array($myAudience)) {
                                                                    $assignAudience[] = $row['audience_id'];
                                                                }

                                                            ?>
                                                            <?php 
                                                                $query = "SELECT * FROM tbl_audience_type WHERE status='active' GROUP BY id ORDER BY name ASC";
                                                                $result = mysqli_query($db, $query);
                                                                while ($row = mysqli_fetch_assoc($result)) {

                                                                    $slected_audience= (in_array($row['id'],$assignAudience)) ? 'selected' : NULL;
                                                            ?>
                                                                <option value="<?= $row['id'];?>" <?= $slected_audience ?> > <?=$row['name'];?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="form-group">
                                                        <label for="class_assign_id">Select Class</label>

                                                        <select class="form-control select2" name="class_assign_id[]" id="class_assign_id" multiple placeholder="-- Select Class --" >
                                                            <option value="all">ALL</option>
                                                            <?php 
                                                                $assignClasses = array();
                                                                $class_query = "SELECT * FROM tbl_assign_class_post WHERE post_id = '".$id."' ";
                                                                $myClasss = mysqli_query($db, $class_query);
                                                                while ($row = mysqli_fetch_array($myClasss)) {
                                                                    $assignClasses[] = $row['class_id'];
                                                                }

                                                            ?>
                                                            <?php
                                                                $query = "SELECT c.* FROM tbl_class c INNER JOIN tbl_class_assign ca ON ca.class_id=c.id WHERE ca.school_id='".$_SESSION['school_id']."' AND ca.status='active' GROUP BY c.id ORDER BY c.name ASC";
                                                                $result = mysqli_query($db, $query);
                                                                while ($row = mysqli_fetch_assoc($result)) {

                                                                $slected_classes= (in_array($row['id'],$assignClasses)) ? 'selected' : NULL;
                                                            ?>
                                                                <option value="<?= $row['id'];?>" <?= $slected_classes ?>> <?=$row['name'];?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="section_assign_id">Select Class Section</label>
                                                        <select class="form-control select2" name="section_assign_id[]" id="section_assign_id" multiple placeholder="-- Select Class Section --">
                                                            <option value="all">ALL</option>
                                                            <?php 
                                                                $assignSections = array();
                                                                $section_query = "SELECT * FROM tbl_assign_section_post WHERE post_id = '".$id."' ";
                                                                $mySection = mysqli_query($db, $section_query);
                                                                while ($rowSection = mysqli_fetch_array($mySection)) {
                                                                    $assignSections[] = $rowSection['section_id'];
                                                                }

                                                            ?>
                                                            <?php
                                                                $query = "SELECT s.* FROM tbl_section s INNER JOIN tbl_class_assign ca ON ca.section_id=s.id WHERE ca.school_id='".$_SESSION['school_id']."' AND ca.status='active' GROUP BY s.id ORDER BY s.name ASC";
                                                                $result = mysqli_query($db, $query);
                                                                while ($row = mysqli_fetch_assoc($result)) {

                                                                    $slected_sestions= (in_array($row['id'],$assignSections)) ? 'selected' : NULL;
                                                            ?>
                                                                <option value="<?= $row['id'];?>" <?= $slected_sestions ?> > <?=$row['name'];?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description *</label>
                                                        <textarea id="summernote" name="description" value="<?php echo $description; ?>">
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
            if ($audience_type == "") {
                $errorMsg .= "Please Select Audience type.<br />";
            }
            if ($description == "") {
                $errorMsg .= "Please Enter Description.<br />";
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
                        if (!empty($_POST['audience_type'])) {
                            
                            $audienceIds = $_POST['audience_type'];
                            $insertAud = multipal_insert_data('tbl_assign_audience_post', $id, $audienceIds, 'post_id', 'audience_id', $id);
                            
                        }
                        
                        if (!empty($_POST['class_assign_id'])) {
                            
                            $classIds = $_POST['class_assign_id'];
                            $inserClass = multipal_insert_data('tbl_assign_class_post', $id, $classIds, 'post_id', 'class_id', $id);
                            
                        }

                        if (!empty($_POST['section_assign_id'])) {

                            $sectionIds = $_POST['section_assign_id'];
                            $insertSection = multipal_insert_data('tbl_assign_section_post', $id, $sectionIds, 'post_id', 'section_id', $id);
                            
                        }
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
