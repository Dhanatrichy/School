<?php
include('includes/database.php');
if (!isset($_SESSION['admin_id'])) {
    header('location:');
}
$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_section where id='" . $id . "'";
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
        <title>Section | LMS</title>

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
                                <h1 class="m-0">Add / View Section</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Section</li>
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
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Section</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="section_form" id="section_form">
                                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Section Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Section Name" value="<?php echo $name; ?>">
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

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-file-alt"></i> View Section</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Section Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM tbl_section ORDER BY name ASC";
                                                $result = mysqli_query($db, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                <tr class="row_<?php echo $row['id']; ?>">
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'active') { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-success" onclick="change_status(<?php echo $row['id']; ?>, 'inactive', 'modules/section/request.php')">Active</span></a>
                                                            <?php } else { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-danger" onclick="change_status(<?php echo $row['id']; ?>, 'active', 'modules/section/request.php')">Inactive</span></a>
                                                            <?php } ?>		
                                                        </td>
                                                        <td >
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="section.php?id=<?php echo base64_encode($row['id']); ?>&action=edit" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                                <a href="javascript:void(0);" class="btn btn-danger"><i onclick="delete_detail(<?php echo $row['id']; ?>, 'modules/section/request.php')" class="fas fa-trash"></i></a>
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
