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
                <a href="#" class="d-block">Admin</a>
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
                
                <li class="nav-item">
                    <a href="class.php" class="nav-link <?php if($page_name=='class.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Class Management
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="section.php" class="nav-link <?php if($page_name=='section.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Section Management
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="subject.php" class="nav-link <?php if($page_name=='subject.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Subject Management
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="year.php" class="nav-link <?php if($page_name=='year.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Year Management
                        </p>
                    </a>
                </li>
                
                <li class="nav-item <?php if($page_name=='add-teacher.php' || $page_name=='view-teacher.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add-teacher' || $page_name=='view-teacher.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Teacher Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-teacher.php" class="nav-link <?php if($page_name=='add-teacher.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add Teacher
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-teacher.php" class="nav-link <?php if($page_name=='view-teacher.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View / Edit Teacher
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item <?php if($page_name=='add-school.php' || $page_name=='view-school.php'){ ?> menu-open <?php } ?>">
                    <a href="#" class="nav-link <?php if($page_name=='add-school.php' || $page_name=='view-school.php'){ ?> active <?php } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            School Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-school.php" class="nav-link <?php if($page_name=='add-school.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Add School
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view-school.php" class="nav-link <?php if($page_name=='view-school.php'){ ?> active <?php } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    View Schools
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
