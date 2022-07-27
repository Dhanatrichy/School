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
        <title>Login | AHA Digischool</title>

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
                <a href="index.php"><b>AHA Digischool</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box   -msg">Sign in to start your session </p>

                    <form method="post">
                        <label for="login_as">Login As :</label>
                        <div class="input-group mb-3">
                            
                            <select class="form-control" name="login_as" id="login_as">
                                <option value="admin">Admin</option>
                                <option value="school">School</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span onclick="showhide_password()" title="Click To Show The Password" class="fas password_lock fa-lock"></span>
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
            $login_as = secureSuperGlobal($_POST['login_as']);
            
            
            if($login_as=='admin'){
                // Login As Admin
                $query = "select * from tbl_admin where email='" . $email . "' and password='" . $pass . "'";
                $sql = $db->query($query);

                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                    $_SESSION['admin_id'] = $row['id'];
                    $_SESSION['authority'] = $row['authority'];
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['admin_email'] = $row['email'];
                    $_SESSION['user_type'] = 'admin';
                    //$_SESSION['addedon'] = $row['addedon'];
                    echo "<script language=javascript>";
                    echo 'location.href="dashboard.php"';
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo "toastr.error('Invalid Username and Password')";
                    echo "</script>";
                }
            }else if($login_as=='school'){
                // Login As School
                
                $query = "select * from tbl_school where email='" . $email . "' and password='" . $pass . "' and status='active'";
                $sql = $db->query($query);

                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                    $_SESSION['school_id'] = $row['id'];
                    $_SESSION['school_name'] = $row['name'];
                    $_SESSION['school_email'] = $row['email'];
                    $_SESSION['user_type'] = $row['user_type'];
                    //$_SESSION['addedon'] = $row['addedon'];
                    echo "<script language=javascript>";
                    echo 'location.href="school/dashboard.php"';
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo "toastr.error('Invalid Username and Password / Your account has been Blocked by Admin')";
                    echo "</script>";
                }
                
            }else if($login_as=='teacher'){
                // Login As Teacher
                
                $query = "select * from tbl_teacher where email='" . $email . "' and password='" . $pass . "' and status='active'";
                $sql = $db->query($query);

                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                    $_SESSION['teacher_id'] = $row['id'];
                    $_SESSION['school_id'] = $row['school_id'];
                    $_SESSION['teacher_name'] = $row['name'];
                    $_SESSION['teacher_email'] = $row['email'];
                    $_SESSION['user_type'] = $row['user_type'];
                    echo "<script language=javascript>";
                    echo 'location.href="teacher/dashboard.php"';
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo "toastr.error('Invalid Username and Password / Your account has been Blocked by Admin')";
                    echo "</script>";
                }
                
            }else if($login_as=='student'){
                // Login As Student
                
                $query = "select * from tbl_student where email='" . $email . "' and password='" . $pass . "' and status='active'";
                $sql = $db->query($query);
                //$_SESSION   =   array();
                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                    $_SESSION =   $row;
                    $_SESSION['student_id'] = $row['id'];
                    $_SESSION['school_id'] = $row['school_id'];
                    $_SESSION['student_name'] = $row['name'];
                    $_SESSION['student_email'] = $row['email'];
                    $_SESSION['user_type'] = $row['user_type'];
                    
                    echo "<script language=javascript>";
                    echo 'location.href="student/dashboard.php"';
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo "toastr.error('Invalid Username and Password / Your account has been Blocked by Admin')";
                    echo "</script>";
                }
            }
            
        }
        ?>
    </body>

    <script>
        function showhide_password(){
            var passInput=$("#password");
            if(passInput.attr('type')==='password')
            {
                passInput.attr('type','text');
                $(".password_lock").removeClass("fa-lock");
                $(".password_lock").addClass("fa-unlock");
            }else{
                passInput.attr('type','password');
                $(".password_lock").removeClass("fa-unlock");
                $(".password_lock").addClass("fa-lock");
            }
        }


    </script>
</html>
