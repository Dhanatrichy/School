<?php include('includes/header.php'); ?>
<?php include('includes/left.php'); ?>
<?php
$get_id = base64_decode($_GET['id']);
if ($_GET['action'] == "edit" && isset($_GET['id'])) {
    $max = "select * from tbl_client where client_id='" . $get_id . "'";
    $max2 = mysqli_query($db, $max);
    $max3 = mysqli_fetch_assoc($max2);
    extract($max3);
    $update = 1;
}

if (isset($_POST['submit'])) {
    extract($_POST);
    if ($client_name == "") {
        $errorMsg .= "Please Fill All The Fields";
    }
    if ($errorMsg == "") {
        $target_dir = "../images/clients/";
        $target_file = $target_dir . time() . basename($_FILES["client_img"]["name"]);
        if ($_FILES["client_img"]["name"] != "") {
            unlink($target_dir . $client_img);
            $image = time() . basename($_FILES["client_img"]["name"]);
            move_uploaded_file($_FILES["client_img"]["tmp_name"], $target_file);
        } else {
            $image = $client_img;
        }
        
        if ($update == "1") {
            $data = $_POST;
            $time = time();
            $fields = array("client_name");
            $static = ", client_img='" . $image . "'";
            $where = " client_id='" . $get_id . "'";
            $update_id = update('tbl_client', $fields, $static, $data, $where);
            if ($update_id) {
                echo "<script>";
                echo "swal('','Updated Successfully','success');";
                echo "</script>";
                $success = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("client_name");
            $static = ",addedon='" . $time . "', client_img='" . $image . "'";
            $insert_id = insert('tbl_client', $fields, $static, $data, $floor, "");
            if ($insert_id > 0) {
                echo "<script>";
                echo "swal('','Added Successfully','success');";
                echo "</script>";
                $success = "Added Successfully";
            }
        }
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Management
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Management</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"> Add Clients</h3>
                <div class="box-tools pull-right">
                    <a href="view_clients.php">View</a>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update" value="<?php echo $update ?>" />
                    <input type="hidden" name="status" value="<?php
                    if ($status == "") {
                        echo 1;
                    } else {
                        echo $status;
                    }
                    ?>" />
                    <?php if ($errorMsg != '') { ?><div class="alert alert-danger" role="alert"><?php echo $errorMsg; ?></div><?php } ?>
                    <?php if ($success != '') { ?><div class="alert alert-success" role="alert"><?php echo $success; ?></div><?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="client_name" class="form-control" name="client_name" value="<?php echo $client_name; ?>">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <br />
                                <input type="file" id="client_img" name="client_img">
                                <?php if($client_img!=''){ ?>
                                <br />
                                <img src="../images/clients/<?php echo $client_img; ?>" height="70" width="70" />
                                <?php } ?>
                            </div>
                        </div>                        
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" name="submit" class="btn btn-primary btn-flat">Submit</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.box-body -->

        </div><!-- /.box -->


    </section><!-- /.content -->
</div>

<?php include('includes/footer.php'); ?>
</div><!-- ./wrapper -->

</body>
</html>
