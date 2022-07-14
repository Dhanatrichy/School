<?php
include('includes/database.php');

$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_subject_mark where subject_mark_id='" . $id . "'";
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
        <title>Add Marks | LMS</title>

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
                                <h1 class="m-0">Add Marks</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Add Marks</li>
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
                            <div class="col-md-4">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Marks</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="marks_form" id="marks_form">
                                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                                        <input type="hidden" name="id" value="<?php echo $subject_mark_id; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="class_id">Select Class *</label>
                                                        <select class="form-control" name="class_id" id="class_id" onchange="get_students(<?php echo $_SESSION['school_id']; ?>)">
                                                            <option value="">-- Select Class --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_class where status='active' ORDER BY addedon ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $_GET['class_id']) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="section_id">Select Section *</label>
                                                        <select class="form-control" name="section_id" id="section_id" onchange="get_students(<?php echo $_SESSION['school_id']; ?>)">
                                                            <option value="">-- Select Section --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_section where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $_GET['section_id']) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="year">Select Year *</label>
                                                        <select class="form-control" name="year" id="year">
                                                            <option value="">-- Select Year --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_year where status='active' ORDER BY year ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $_GET['year']) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['year']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="subject_id">Select Subject *</label>
                                                        <select class="form-control" name="subject_id" id="subject_id">
                                                            <option value="">-- Select Subject --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_subject where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option <?php if ($row['id'] == $_GET['subject_id']) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="button" name="submit" onclick="get_student_list()" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <!-- general form elements -->

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-file-alt"></i> View Student List</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" name="get_student_form" id="get_student_form">
                                            <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">
                                            <input type="hidden" name="section_id" value="<?php echo $_GET['section_id']; ?>">
                                            <input type="hidden" name="year" value="<?php echo $_GET['year']; ?>">
                                            <input type="hidden" name="subject_id" value="<?php echo $_GET['subject_id']; ?>">

                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Total Marks</th>
                                                        <th>Obtained Marks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $counting=0;
                                                    $query = "SELECT * FROM tbl_student where school_id='" . $_SESSION['school_id'] . "' and class_id='" . $_GET['class_id'] . "' and section_id='" . $_GET['section_id'] . "' and status='active' ORDER BY name ASC";
                                                    $result = mysqli_query($db, $query);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>

                                                        <tr>
                                                            <td>
                                                                <?php echo $row['name']; ?>
                                                                <input type="hidden" name="student_marks[<?php echo $counting; ?>][id]" value="<?php echo $row['id']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="student_marks[<?php echo $counting; ?>][total_marks]" class="form-control" placeholder="Total Marks">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="student_marks[<?php echo $counting; ?>][obtained_marks]" class="form-control" placeholder="Obtained Marks">
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $counting++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                            if (isset($_GET['class_id']) && isset($_GET['section_id']) && isset($_GET['subject_id']) && isset($_GET['year'])) {
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" name="submit_marks" value="submit_marks" class="btn pull-right btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
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
        if (isset($_POST['submit_marks'])) {

            extract($_POST);

            $count=0;
            $time = time();
            foreach ($student_marks as $student_mark) {
                
                $check_query = "select * from tbl_subject_mark where student_id='" . $student_mark['id'] . "' and subject_id='" . $subject_id . "' and year='" . $year . "'";
                $check_run = mysqli_query($db, $check_query);
                $row_count = mysqli_num_rows($check_run);
                if ($row_count == 0) {
                    $query = "insert into tbl_subject_mark(school_id,teacher_id,class_id,section_id,subject_id,year,student_id,total_marks,obtained_marks,addedon,datetime)values('" . $_SESSION['school_id'] . "','" . $_SESSION['teacher_id'] . "','" . $class_id . "','" . $section_id . "','" . $subject_id . "','" . $year . "','" . $student_mark['id'] . "','" . $student_mark['total_marks'] . "','" . $student_mark['obtained_marks'] . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                    $run = mysqli_query($db, $query);
                    $count++;
                }
            }
            if($count>0){
                echo "<script>";
                echo "toastr.success('$count Record Submitted.')";
                echo "</script>";
            }else{
                echo "<script>";
                echo "toastr.error('0 Record Submitted.')";
                echo "</script>";
            }
        }
        ?>


        <script>
            function get_student_list() {
                var class_id = $("#class_id").val();
                var section_id = $("#section_id").val();
                var subject_id = $("#subject_id").val();
                var year = $("#year").val();

                var errorMsg='';

                if(class_id==''){
                    errorMsg    +=   "Please Select Class";
                }

                if(section_id==''){
                    errorMsg    +=   "<br /> Please Select Section";
                }

                if(subject_id==''){
                    errorMsg    +=   "<br /> Please Select Subject";
                }

                if(year==''){
                    errorMsg    +=   "<br /> Please Select Year";
                }

                if(errorMsg==''){
                    window.location.href = 'add-marks.php?class_id=' + class_id + '&section_id=' + section_id + '&subject_id=' + subject_id + '&year=' + year + '&action=get_list';
                }else{
                    toastr.error(errorMsg);
                }
            }

        </script>
    </body>
</html>
