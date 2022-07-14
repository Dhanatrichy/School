<?php
$action = 'submit';
include('includes/database.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Post | LMS</title>

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
                                <h1 class="m-0">View Post</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">View Post</li>
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
                                        <h3 class="card-title"><i class="fas fa-file-alt"></i> View Post</h3>
                                    </div>
                                <?php if (false) { ?>
                            
                                    <form method="post" name="post_form" id="post_form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="class_assign_id">Select Class</label>
                                                        <select class="form-control select2" name="class_assign_id[]" id="class_assign_id" multiple placeholder="-- Select Class --">
                                                            <option value="all">ALL</option>
                                                            <?php
                                                                $query = "SELECT c.* FROM tbl_class c INNER JOIN tbl_class_assign ca ON ca.class_id=c.id WHERE ca.school_id='".$_SESSION['school_id']."' AND ca.status='active' GROUP BY c.id ORDER BY c.name ASC";
                                                                $result = mysqli_query($db, $query);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                                <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="section_assign_id">Select Class Section</label>
                                                        <select class="form-control select2" name="section_assign_id[]" id="section_assign_id" multiple placeholder="-- Select Class Section --">
                                                            <option value="all">ALL</option>
                                                            <?php
                                                                $query = "SELECT s.* FROM tbl_section s INNER JOIN tbl_class_assign ca ON ca.section_id=s.id WHERE ca.school_id='".$_SESSION['school_id']."' AND ca.status='active' GROUP BY s.id ORDER BY s.name ASC";
                                                                $result = mysqli_query($db, $query);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                                <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="audience_type">Select Audience Type</label>
                                                        <select class="form-control select2" name="audience_type[]" id="audience_type" multiple placeholder="-- Select Audience Type --">
                                                            <option value="all">ALL</option>
                                                            <option value="teacher">Teachers</option>
                                                            <option value="student">Students</option>
                                                            <option value="nonteacher">Non Teachers</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card-footer">
                                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php } ?>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Image</th>
                                                    <th>Author</th>
                                                    <th>Counts</th>
                                                    <th>Destination</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if (isset($_POST['submit'])) {
                                                        $postData = extract($_POST);
                                                        echo "<pre>";
                                                        print_r($postData);
                                                        echo "</pre>";
                                                    }
                                                $query = "SELECT * FROM tbl_post where school_id='".$_SESSION['school_id']."' ORDER BY addedon DESC";
                                                $result = mysqli_query($db, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if($row['author_type']=='school'){
                                                        $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_school', 'id');
                                                        $image  =   'uploads/posts/'.$row['image'];
                                                    }else if($row['author_type']=='teacher'){
                                                        $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_teacher', 'id');
                                                        $image  =   '../teacher/uploads/posts/'.$row['image'];
                                                    }
                                                    
                                                    ?>
                                                    <tr class="row_<?php echo $row['id']; ?>">
                                                        <td><?php echo $row['title']; ?></td>
                                                        <td><img src="<?php echo $image; ?>" width="100" height="100" /></td>
                                                        <td><?php echo $author_name; ?></td>
                                                        <td>
                                                            <?php
                                                                echo "Likes - ".give_count('tbl_post_like','post_id',$row['id']);
                                                                echo "<br />";
                                                                
                                                                echo "Comments - ".give_count('tbl_post_comment','post_id',$row['id']);
                                                            
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php

                                                                echo "Class - ";
                                                                $assignedSchool = select_other_data('tbl_assign_class_post','tbl_class','post_id','class_id',$row['id']);

                                                                foreach ($assignedSchool as $key => $school) {
                                                                    echo"<span class='badge bg-success'> ". $school['assign_name']."</span>";
                                                                }

                                                                echo "<br />";

                                                                echo "Section - ";
                                                                $assignedSection = select_other_data('tbl_assign_section_post','tbl_section','post_id','section_id',$row['id']);
                                                                foreach ($assignedSection as $key => $section) {
                                                                    echo"<span class='badge bg-success'> ". $section['assign_name']."</span>";
                                                                }
                                                                echo "<br />";

                                                                echo "Audience - ";
                                                                $assignedAudience = select_other_data('tbl_assign_audience_post','tbl_audience_type','post_id','audience_id',$row['id']);
                                                                foreach ($assignedAudience as $key => $audience) {
                                                                    echo"<span class='badge bg-success'> ". $audience['assign_name']."</span>";
                                                                }
                                                            
                                                            ?>
                                                        </td>
                                                        <td><?php echo date('d/m/Y', $row['addedon']); ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'active') { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-success" onclick="change_status(<?php echo $row['id']; ?>, 'inactive', 'modules/posts/request.php')">Active</span></a>
                                                            <?php } else { ?>
                                                            <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>"><span class="badge bg-danger" onclick="change_status(<?php echo $row['id']; ?>, 'active', 'modules/posts/request.php')">Inactive</span></a>
                                                            <?php } ?>		
                                                        </td>
                                                        <td >
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="view-post_detail.php?id=<?php echo base64_encode($row['id']); ?>&action=view_detail" target="_blank" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                                                                <a href="add-post.php?id=<?php echo base64_encode($row['id']); ?>&action=edit" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                                <a href="javascript:void(0);" class="btn btn-danger"><i onclick="delete_detail(<?php echo $row['id']; ?>, 'modules/posts/request.php')" class="fas fa-trash"></i></a>
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
