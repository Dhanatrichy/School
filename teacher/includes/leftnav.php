<?php
$page_name  = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Teacher</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
               
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php if($page_name=='dashboard.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                
                
                <li class="nav-item <?php if($page_name=='add_student_attendance.php' || $page_name=='view_student_attendance.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add_student_attendance' || $page_name=='view_student_attendance.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Attendance Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add_student_attendance.php" class="nav-link <?php if($page_name=='add_student_attendance.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add Student Attendance
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_student_attendance.php" class="nav-link <?php if($page_name=='view_student_attendance.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View Student Attendance
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item <?php if($page_name=='add-student.php' || $page_name=='view-student.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add-student' || $page_name=='view-student.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Student Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-student.php" class="nav-link <?php if($page_name=='add-student.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add Student
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-student.php" class="nav-link <?php if($page_name=='view-student.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View / Edit 
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item <?php if($page_name=='add-post.php' || $page_name=='view-post.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add-post' || $page_name=='view-post.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Post Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-post.php" class="nav-link <?php if($page_name=='add-post.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add Post
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-post.php" class="nav-link <?php if($page_name=='view-post.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View Post
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-requested-post.php" class="nav-link <?php if($page_name=='view-requested-post.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View Requested Post
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                
                <li class="nav-item <?php if($page_name=='add-assignment.php' || $page_name=='view-assignment.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add-assignment' || $page_name=='view-assignment.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Assignment Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-assignment.php" class="nav-link <?php if($page_name=='add-assignment.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add Assignment
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-assignment.php" class="nav-link <?php if($page_name=='view-assignment.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View Assignment
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?php if($page_name=='add-marks.php' || $page_name=='view-marks.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add-marks' || $page_name=='view-marks.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Marks Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-marks.php" class="nav-link <?php if($page_name=='add-marks.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add Marks
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-marks.php" class="nav-link <?php if($page_name=='view-marks.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View Marks
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
               
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
