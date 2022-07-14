<?php
include('includes/database.php');
if (!isset($_SESSION['admin_id'])) {
    header('location: index.php');
}
$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_teacher where id='" . $id . "'";
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
        <title>Add Teacher | LMS</title>

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
                                <h1 class="m-0">Add Teacher</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Add Teacher</li>
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
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Teacher</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="teacher_form" id="teacher_form">
                                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="school_id">School</label>
                                                        <select class="form-control select2" name="school_id" id="school_id">
                                                            <option value="">-- Select School --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_school where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if($row['id']==$school_id){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Teacher Name *</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Teacher Name" value="<?php echo $name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mobile_no">Mobile No *</label>
                                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile No" value="<?php echo $mobile_no; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email Id *</label>
                                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Id" value="<?php echo $email; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Password *</label>
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
                                                        <?php /* ?><input type="hidden" id="edit_password" name="edit_password" value="<?php echo $password; ?>"><?php */ ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="state_id">State Name</label>
                                                        <select class="form-control" name="state_id" id="state_id" onchange="get_city(this.value);">
                                                            <option value="">-- Select State --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_state where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if($row['id']==$state_id){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="city_id">City Name</label>
                                                        <select class="form-control city_id" name="city_id" id="city_id">
                                                            <option value="">-- Select City --</option>
                                                            <?php
                                                            $query_city = "SELECT * FROM tbl_city where status='active' and sid='".$state_id."' ORDER BY name ASC";
                                                            $result_city = mysqli_query($db, $query_city);
                                                            while ($row_city = mysqli_fetch_assoc($result_city)) {
                                                                ?>
                                                            <option <?php if($row_city['id']==$city_id){ ?> selected="selected" <?php } ?> value="<?php echo $row_city['id']; ?>"><?php echo $row_city['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="zipcode">Pin / Zip Code</label>
                                                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Pin / Zip Code" value="<?php echo $zipcode; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">Address *</label>
                                                        <textarea class="form-control" id="address" name="address" placeholder="Address"><?php echo $address; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="qualification">Qualification *</label>
                                                        <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification" value="<?php echo $qualification; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experience">Experience *</label>
                                                        <input type="text" class="form-control" id="experience" name="experience" placeholder="Experience" value="<?php echo $experience; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="subjects">Subjects *</label>
                                                        <select class="select2" name="subjects[]" id="subjects" multiple="multiple" data-placeholder="Select Subjects" style="width: 100%;">
                                                            <option value="">-- Select Subjects --</option>
                                                            <?php
                                                            $subject_decode =   json_decode($subjects);
                                                            $query = "SELECT * FROM tbl_subject where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if(in_array($row['id'], $subject_decode)){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
