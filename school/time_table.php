<?php
include('includes/database.php');

$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_timetable where id='" . $id . "'";
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
        <title>Time Table Management | LMS</title>

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
                                <h1 class="m-0">Time Table Management</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Time Table Management</li>
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
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Time Table</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="time_table_form" id="time_table_form">
                                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="weekday">Select Week Day</label>
                                                        <select class="form-control" name="weekday" id="weekday">
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thursday">Thursday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <!-- /.form group -->
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="period_id">Select Period</label>
                                                        <select class="form-control" name="period_id" id="period_id">
                                                            <?php
                                                            $query = "SELECT * FROM tbl_period where status='active' ORDER BY sort_order ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if($row['id']==$period_id){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
                                                        <label for="class_assign_id">Assign To</label>
                                                        <select class="form-control select2" name="class_assign_id" id="class_assign_id">
                                                            <option value="">-- Select --</option>
                                                            <?php
                                                            $query = "SELECT ca.id as id, t.name as teacher_name, c.name as class_name, sec.name as section_name, sub.name as subject_name, ca.addedon, ca.status 
FROM tbl_class_assign AS ca
INNER JOIN tbl_teacher as t
ON ca.teacher_id = t.id
INNER JOIN tbl_class as c
ON c.id = ca.class_id
INNER JOIN tbl_section as sec
ON sec.id = ca.section_id
INNER JOIN tbl_subject as sub
ON sub.id = ca.subject_id where ca.school_id='".$_SESSION['school_id']."' ORDER BY addedon DESC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if($row['id']==$class_assign_id){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['teacher_name'].' [ '.$row['class_name'].'-'.$row['section_name'].' ] '.$row['subject_name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
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

                            <div class="col-md-12">
                                <!-- general form elements -->

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-file-alt"></i> View Time Table</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Weekday</th>
                                                    <th>Period Name</th>
                                                    <th>Timing</th>
                                                    <th>Teacher Name</th>
                                                    <th>Class</th>
                                                    <th>Section</th>
                                                    <th>Subject</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT tt.id as id, tt.weekday as weekday, p.name as period_name, p.start_time as period_start_time, p.end_time as period_end_time, t.name as teacher_name, c.name as class_name, sec.name as section_name, sub.name as subject_name, tt.addedon, tt.status 
FROM tbl_timetable AS tt
INNER JOIN tbl_class_assign as ca
ON tt.class_assign_id = ca.id
INNER JOIN tbl_period as p
ON tt.period_id = p.id
INNER JOIN tbl_teacher as t
ON ca.teacher_id = t.id
INNER JOIN tbl_class as c
ON c.id = ca.class_id
INNER JOIN tbl_section as sec
ON sec.id = ca.section_id
INNER JOIN tbl_subject as sub
ON sub.id = ca.subject_id where tt.school_id='".$_SESSION['school_id']."' ORDER BY addedon ASC";
                                                $result = mysqli_query($db, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr class="row_<?php echo $row['id']; ?>">
                                                        <td><?php echo $row['weekday']; ?></td>
                                                        <td><?php echo $row['period_name']; ?></td>
                                                        <td><?php echo $row['period_start_time'].' - '.$row['period_end_time']; ?></td>
                                                        <td><?php echo $row['teacher_name']; ?></td>
                                                        <td><?php echo $row['class_name']; ?></td>
                                                        <td><?php echo $row['section_name']; ?></td>
                                                        <td><?php echo $row['subject_name']; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'active') { ?>
                                                                <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-success" onclick="change_status(<?php echo $row['id']; ?>, 'inactive', 'modules/time_table/request.php')">Active</span></a>
                                                            <?php } else { ?>
                                                                <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-danger" onclick="change_status(<?php echo $row['id']; ?>, 'active', 'modules/time_table/request.php')">Inactive</span></a>
                                                            <?php } ?>		
                                                        </td>
                                                        <td >
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="time_table.php?id=<?php echo base64_encode($row['id']); ?>&action=edit" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                                <a href="javascript:void(0);" class="btn btn-danger"><i onclick="delete_detail(<?php echo $row['id']; ?>, 'modules/time_table/request.php')" class="fas fa-trash"></i></a>
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
