<?php
include('includes/database.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Marks | LMS</title>

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
                                <h1 class="m-0">View Marks</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">View Marks</li>
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

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-file-alt"></i> View Marks</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Class</th>
                                                    <th>Student</th>
                                                    <th>Subject</th>
                                                    <th>Year</th>
                                                    <th>Total Marks</th>
                                                    <th>Obtained Marks</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT sm.*, student.name as student_name, c.name as class_name, sec.name as section_name, subject.name as subject_name, y.year as year_name FROM tbl_subject_mark sm LEFT JOIN tbl_student as student ON sm.student_id = student.id LEFT JOIN tbl_class as c ON sm.class_id = c.id LEFT JOIN tbl_section as sec ON sm.section_id = sec.id LEFT JOIN tbl_subject as subject ON sm.subject_id = subject.id LEFT JOIN tbl_year as y ON sm.year = y.id where sm.teacher_id='".$_SESSION['teacher_id']."' and sm.school_id='".$_SESSION['school_id']."' ORDER BY sm.addedon DESC";
                                                $result = mysqli_query($db, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    
                                                    ?>
                                                    <tr class="row_<?php echo $row['subject_mark_id']; ?>">
                                                        <td><?php echo $row['class_name'].' - '.$row['section_name']; ?></td>
                                                        <td><?php echo $row['student_name']; ?></td>
                                                        <td><?php echo $row['subject_name']; ?></td>
                                                        <td><?php echo $row['year_name']; ?></td>
                                                        <td><?php echo $row['total_marks']; ?></td>
                                                        <td><?php echo $row['obtained_marks']; ?></td>
                                                        <td><?php echo date('d/m/Y', $row['addedon']); ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'active') { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['subject_mark_id']; ?>"><span class="badge bg-success" onclick="change_status(<?php echo $row['subject_mark_id']; ?>, 'inactive', 'modules/marks/request.php')">Active</span></a>
                                                            <?php } else { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['subject_mark_id']; ?>"><span class="badge bg-danger" onclick="change_status(<?php echo $row['subject_mark_id']; ?>, 'active', 'modules/marks/request.php')">Inactive</span></a>
                                                            <?php } ?>		
                                                        </td>
                                                        <td >
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="javascript:void(0);" class="btn btn-danger"><i onclick="delete_detail(<?php echo $row['subject_mark_id']; ?>, 'modules/marks/request.php')" class="fas fa-trash"></i></a>
                                                            </div>
                                                        </td>
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
    </body>
</html>
