<?php
include('includes/database.php');
unset($_SESSION['admin_id']);
unset($_SESSION['authority']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);
session_destroy();
header("Location:index.php");
?>
<!-- //check -->