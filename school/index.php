<?php include('includes/database.php'); ?>
<?php
if(isset($_SESSION['admin_id'])){
  header('location: dashboard.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | LMS</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="index.php"><b>School</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session </p>

                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>

<!--                            <button type="button" class="btn btn-danger toastrDefaultError">
                                Launch Error Toast
                            </button>-->
                            <!-- /.col -->
                        </div>
                    </form>
                    <!-- /.social-auth-links -->

                    <p class="mb-1">
                        <a href="forgot-password.php">I forgot my password</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- Toastr -->
        <script src="plugins/toastr/toastr.min.js"></script>

        <?php
        if (isset($_POST['submit'])) {
            $email = secureSuperGlobal($_POST['email']);
            $pass = secureSuperGlobal($_POST['password']);

            $query = "select * from tbl_school where email='" . $email . "' and password='" . $pass . "'";
            $sql = $db->query($query);
            
            if (mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
                $_SESSION['school_id'] = $row['id'];
                $_SESSION['school_name'] = $row['name'];
                $_SESSION['school_email'] = $row['email'];
                $_SESSION['user_type'] = $row['user_type'];
                //$_SESSION['addedon'] = $row['addedon'];
                echo "<script language=javascript>";
                echo 'location.href="dashboard.php"';
                echo "</script>";
            } else {
                echo "<script>";
                echo "toastr.error('Invalid Username and Password')";
                echo "</script>";
            }
        }
        ?>
    </body>
</html>
