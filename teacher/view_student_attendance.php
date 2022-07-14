<?php
include('includes/database.php');

//$action = 'submit';
//$id = base64_decode($_GET['id']);
//if ($_GET['action'] == "edit" && isset($_GET['id'])) {
//    $max = "select * from tbl_class_assign where id='" . $id . "'";
//    $max2 = mysqli_query($db, $max);
//    $max3 = mysqli_fetch_assoc($max2);
//    extract($max3);
//    $update = 1;
//}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Attendance Management | LMS</title>

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
                                <h1 class="m-0">Attendance Management</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Attendance Management</li>
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
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Search</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="get_student_form" id="get_student_form">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="class_id">Select Class</label>
                                                        <select class="form-control" name="class_id" id="class_id">
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
                                                        <label for="section_id">Select Section</label>
                                                        <select class="form-control" name="section_id" id="section_id">
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
                                                        <label for="date">Date </label>
                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                            <input type="text" id="date" name="date" class="form-control datetimepicker-input" placeholder="Date" value="<?php echo $_GET['date']; ?>" data-target="#reservationdate"/>
                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="session">Select Session</label>
                                                        <select class="form-control" name="session" id="session">
                                                            <option <?php if ($_GET['session'] == 'ForeNoon') { ?> selected="selected" <?php } ?> value="ForeNoon">ForeNoon</option>
                                                            <option <?php if ($_GET['session'] == 'AfterNoon') { ?> selected="selected" <?php } ?> value="AfterNoon">AfterNoon</option>
                                                        </select>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="button" name="submit" onclick="get_student_list()" class="btn btn-primary">Search</button>
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

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Attendance Upload By</th>
                                                    <th>Class</th>
                                                    <th>Session</th>
                                                    <th>Student Name</th>
                                                    <th>Attendance</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT sa.student_attendance_id as sa_id, school.name as school_name, t.name as teacher_name, c.name as class_name, sec.name as section_name, student.name as student_name,sa.attendance, sa.date, sa.session, sa.addedon, sa.status 
FROM tbl_student_attendance AS sa
INNER JOIN tbl_school as school
ON sa.school_id = school.id
INNER JOIN tbl_teacher as t
ON sa.teacher_id = t.id
INNER JOIN tbl_class as c
ON sa.class_id = c.id
INNER JOIN tbl_section as sec
ON sa.section_id = sec.id
INNER JOIN tbl_student as student
ON sa.student_id = student.id where sa.school_id='".$_SESSION['school_id']."' and sa.class_id='".$_GET['class_id']."' and sa.section_id='".$_GET['section_id']."' and sa.date='".$_GET['date']."' and sa.session='".$_GET['session']."' ORDER BY sa.addedon ASC";
                                                $result = mysqli_query($db, $query);
                                                if(mysqli_num_rows($result)>0){
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $row['teacher_name']; ?></td>
                                                            <td><?php echo $row['class_name'].' - '.$row['section_name']; ?></td>
                                                            <td><?php echo $row['session']; ?></td>
                                                            <td><?php echo $row['student_name']; ?></td>
                                                            <td><?php echo $row['attendance']; ?></td>
                                                            <td><?php echo $row['date']; ?></td>

                                                        </tr>

                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <tr>
                                                            <td class="text-center" colspan="6">No Result Found</td>
                                                        </tr>
                                                        
                                                        <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>

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
        if (isset($_POST['submit_attendance'])) {
            extract($_POST);

            $count = 0;
            $time = time();
            foreach ($student as $student_id) {
                //echo $student_id;
                foreach ($attendance[$student_id] as $val) {
                    //echo $val;
                    $query = "insert into tbl_student_attendance(school_id,teacher_id,class_id,section_id,student_id,attendance,date,session,addedon,datetime)values('" . $_SESSION['school_id'] . "','" . $_SESSION['teacher_id'] . "','" . $class_id . "','" . $section_id . "','" . $student_id . "','" . $val . "','" . $date . "','" . $session . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                    $run = mysqli_query($db, $query);
                    $count++;
                }
            }
            if ($count > 0) {
                echo "<script>";
                echo "toastr.success('$count Record Submitted Successfully.')";
                echo "</script>";
            }
        }
        ?>
        <script>
            function get_student_list() {
                var class_id = $("#class_id").val();
                var section_id = $("#section_id").val();
                var date1 = $("#date").val();
                var session = $("#session").val();

                window.location.href = 'view_student_attendance.php?class_id=' + class_id + '&section_id=' + section_id + '&date=' + date1 + '&session=' + session + '&action=get_list';
            }

        </script>
    </body>
</html>
