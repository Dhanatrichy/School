<?php
include('includes/database.php');

$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_student_assignment where id='" . $id . "'";
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
        <title>Add Assignment | LMS</title>

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
                                <h1 class="m-0">Add Assignment</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Add Assignment</li>
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
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Assignment</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="assignment_form" id="assignment_form" enctype="multipart/form-data">
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="class_id">Select Class *</label>
                                                        <select class="form-control" name="class_id" id="class_id">
                                                            <option value="">-- Select Class --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_class where status='active' ORDER BY addedon ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $class_id) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="section_id">Select Section *</label>
                                                        <select class="form-control" name="section_id" id="section_id">
                                                            <option value="">-- Select Section --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_section where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $section_id) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="subject_id">Select Subject *</label>
                                                        <select class="form-control" name="subject_id" id="subject_id">
                                                            <option value="">-- Select Subject --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_subject where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $subject_id) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="attachment">Upload Image</label>
                                                        <input type="file" class="form-control" id="attachment" name="attachment">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php if($attachment!=''){ ?>
                                                            <img src="uploads/assignments/<?php echo $attachment; ?>" height="100" width="100" />
                                                        <?php } ?>
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
            
            if ($class_id == "") {
                $errorMsg .= "Please Select Class.<br />";
            }
            
            if ($section_id == "") {
                $errorMsg .= "Please Select Section.<br />";
            }
            
            if ($subject_id == "") {
                $errorMsg .= "Please Select Subject.<br />";
            }

            if ($errorMsg != '') {
                echo "<script>";
                echo "toastr.error('" . $errorMsg . "')";
                echo "</script>";
            }


            if ($errorMsg == '') {
                $target_dir = "./uploads/assignments/";
                $target_file = $target_dir . time() . basename($_FILES["attachment"]["name"]);
                if ($_FILES["attachment"]["name"] != "") {
                    $file = time() . basename($_FILES["attachment"]["name"]);
                    move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file);
                } else {
                    $file = $attachment;
                }

                if ($id != "") {
                    $data = $_POST;
                    $time = time();
                    $fields = array("title", "class_id", "section_id", "subject_id");
                    $static = ", attachment='" . $file . "'";
                    $where = " id='" . $id . "'";
                    $update_id = update('tbl_student_assignment', $fields, $static, $data, $where);
                    if ($update_id) {

                        $success = "Updated Successfully.";
                        echo "<script>";
                        echo "toastr.success('Details has been Updated Successfully.')";
                        echo "</script>";
                    }
                } else {
                    $time = time();
                    $data = $_POST;
                    $fields = array("title", "class_id", "section_id", "subject_id");
                    $static = ", attachment='" . $file . "', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."', school_id='".$_SESSION['school_id']."', teacher_id='".$_SESSION['teacher_id']."'";
                    $insert_id = insert('tbl_student_assignment', $fields, $static, $data, $floor, "");
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
