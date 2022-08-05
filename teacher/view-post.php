<?php
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
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Image</th>
                                                    <th>Author</th>
                                                    <th>Counts</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM tbl_post where school_id='".$_SESSION['school_id']."' and status!='requested' ORDER BY addedon DESC";
                                                $result = mysqli_query($db, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if($row['author_type']=='school'){
                                                        $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_school', 'id');
                                                        $image  =   '../school/uploads/posts/'.$row['image'];
                                                    }else if($row['author_type']=='teacher'){
                                                        $author_name  =   get_particular_name('name', $row['author_id'], 'tbl_teacher', 'id');
                                                        $image  =   'uploads/posts/'.$row['image'];
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

                                                        
                                                        <td><?php echo date('d/m/Y', $row['addedon']); ?></td>
                                                        <td>
                                                            <?php if(($_SESSION['teacher_id']==$row['author_id']) && ($_SESSION['user_type']==$row['author_type'])){ ?>
                                                                <?php if ($row['status'] == 'active') { ?>
                                                                    <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>">
                                                                        <span class="badge bg-success" onclick="change_status(<?php echo $row['id']; ?>, 'inactive', 'modules/posts/request.php')">Active</span>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a href="javascript:void(0);" class="status_<?php echo $row['id']; ?>">
                                                                        <span class="badge bg-danger" onclick="change_status(<?php echo $row['id']; ?>, 'active', 'modules/posts/request.php')">Inactive</span>
                                                                    </a>
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                            <span class="badge bg-info"><?php echo ucfirst($row['status']); ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td >
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="view-post_detail.php?id=<?php echo base64_encode($row['id']); ?>&action=view_detail" target="_blank" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                                                                <?php if(($_SESSION['teacher_id']==$row['author_id']) && ($_SESSION['user_type']==$row['author_type'])){ ?>
                                                                    <a href="add-post.php?id=<?php echo base64_encode($row['id']); ?>&action=e dit" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                                    <a href="javascript:void(0);" class="btn btn-danger"><i onclick="delete_detail(<?php echo $row['id']; ?>, 'modules/posts/request.php')" class="fas fa-trash"></i></a>
                                                                <?php } ?>
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
