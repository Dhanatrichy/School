<?php
include('includes/database.php');

$action = 'submit';
$id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_student where id='" . $id . "'";
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
        <title>Add Student | LMS</title>

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
                                <h1 class="m-0">Add Student</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Add Student</li>
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
                                        <h3 class="card-title"><i class="fas fa-plus-square"></i> Add Student</h3>
                                    </div>

                                    <div class="card-footer">
                                    <a href="view-student.php">
                                            <button type="submit" name="submit" class="btn btn-primary">Back to View Student</button>
                                            </a>
                                        </div>

                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="post" name="student_form" id="student_form">
                                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="class_id">Class *</label>
                                                        <select class="form-control" name="class_id" id="class_id">
                                                            <option value="">-- Select Class --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_class where status='active' ORDER BY addedon ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if($row['id']==$class_id){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="section_id">Section *</label>
                                                        <select class="form-control" name="section_id" id="section_id">
                                                            <option value="">-- Select Section --</option>
                                                            <?php
                                                            $query = "SELECT * FROM tbl_section where status='active' ORDER BY name ASC";
                                                            $result = mysqli_query($db, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                            <option <?php if($row['id']==$section_id){ ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Student Name *</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Student Name" value="<?php echo $name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="single_image">Student's Image</label>
                                                        <input type="file" class="form-control" id="single_image" accept="image/*" name="single_image">
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="contact">Contact No *</label>
                                                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" value="<?php echo $contact; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="father_name">Father Name *</label>
                                                        <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father Name" value="<?php echo $father_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mother_name">Mother Name *</label>
                                                        <input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="Mother Name" value="<?php echo $mother_name; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dob">Date Of Birth *</label>
                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                            <input type="text" id="dob" name="dob" class="form-control datetimepicker-input" placeholder="Date Of Birth" value="<?php echo $dob; ?>" data-target="#reservationdate"/>
                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="state_id">State Name *</label>
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city_id">City Name *</label>
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

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="zipcode">Pin / Zip Code *</label>
                                                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Pin / Zip Code" value="<?php echo $zipcode; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="single_image">Proof*</label>
                                                        <input type="file" class="form-control" id="single_image" accept="image/*" name="single_image">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">Address *</label>
                                                        <textarea class="form-control" id="address" name="address" placeholder="Address"><?php echo $address; ?></textarea>
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
