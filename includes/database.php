<?php

error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
session_start();

class DB {

    public $db_name = 'u600126134_lms';
    public $db_user = 'root';
    public $db_pass = '';
    public $db_host = 'localhost';

    function connect() {
        return $connect_db = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    }

}

$databse_call = new DB;
$db = $databse_call->connect();
//DBCONNECTION MYSQL
// $conn=mysql_connect('localhost', 'root', '') or die("Can not connect to database.");
// mysql_select_db('adaa', $conn) or die("Can not select database.");
include("common.php");
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>
