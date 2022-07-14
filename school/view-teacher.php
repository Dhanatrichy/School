<?php
include('includes/database.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Teacher | LMS</title>

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
                                <h1 class="m-0">View Teacher</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">View Teacher</li>
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
                                        <h3 class="card-title"><i class="fas fa-file-alt"></i> View Teacher</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Teacher Name</th>
                                                    <th>Email</th>
                                                    <th>Number</th>
                                                    <th>Address</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM tbl_teacher where school_id='".$_SESSION['school_id']."' ORDER BY name ASC";
                                                $result = mysqli_query($db, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $state_name  =   get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
                                                    $city_name  =   get_particular_name('name', $row['city_id'], 'tbl_city', 'id').'-'.$row['zipcode'];
                                                    
                                                    ?>
                                                <tr class="row_<?php echo $row['id']; ?>">
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['mobile_no']; ?></td>
                                                        <td><?php echo $row['address'].', '.$city_name.', '.$state_name; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'active') { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-success" onclick="change_status(<?php echo $row['id']; ?>, 'inactive', 'modules/teacher/request.php')">Active</span></a>
                                                            <?php } else { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-danger" onclick="change_status(<?php echo $row['id']; ?>, 'active', 'modules/teacher/request.php')">Inactive</span></a>
                                                            <?php } ?>		
                                                        </td>
                                                        <td >
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="javascript:void(0);" onclick="view_teacher_detail(<?php echo $row['id']; ?>)" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                                                                <a href="add-teacher.php?id=<?php echo base64_encode($row['id']); ?>&action=edit" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                                <a href="javascript:void(0);" class="btn btn-danger"><i onclick="delete_detail(<?php echo $row['id']; ?>, 'modules/teacher/request.php')" class="fas fa-trash"></i></a>
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
                    
                    
                    <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                
                                    <div class="modal-header">
                                        <h4 class="modal-title">Teacher Detail</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <tr>
                                                <th>School Name </th>
                                                <td id="school_name"></td>
                                            </tr>
                                            <tr>
                                                <th>Created On </th>
                                                <td id="dated"></td>
                                            </tr>
                                            <tr>
                                                <th>Teacher Name </th>
                                                <td id="name"></td>
                                            </tr>
                                            <tr>
                                                <th>Email Id </th>
                                                <td id="email"></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile Number </th>
                                                <td id="mobile_no"></td>
                                            </tr>
                                            <tr>
                                                <th>Qualification </th>
                                                <td id="qualification"></td>
                                            </tr>
                                            <tr>
                                                <th>Experience </th>
                                                <td id="experience"></td>
                                            </tr>
                                            <tr>
                                                <th>Subjects </th>
                                                <td id="subjects"></td>
                                            </tr>
                                            <tr>
                                                <th>Address </th>
                                                <td id="address"></td>
                                            </tr>
                                            <tr>
                                                <th>State </th>
                                                <td id="state"></td>
                                            </tr>
                                            <tr>
                                                <th>City </th>
                                                <td id="city"></td>
                                            </tr>
                                            
                                            <tr>
                                                <th>Status </th>
                                                <td id="status"></td>
                                            </tr>
                                            
                                        </table>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    
                    
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
