<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);

    if ($username == "") {
        $errorMsg[] = "Please Enter User Name.<br />";
    }
    if ($useremail == "") {
        $errorMsg[] = "Please Enter User Email.<br />";
    }
    if ($usernumber == "") {
        $errorMsg[] = "Please Enter User Number.<br />";
    }
    if ($lead_cost == "") {
        $errorMsg[] = "Please Enter Lead Cost.<br />";
    }
    if ($useraddress == "") {
        $errorMsg[] = "Please Enter User Address.<br />";
    }
    if ($sid == "") {
        $errorMsg[] = "Please Select State Name.<br />";
    }
    if ($cid == "") {
        $errorMsg[] = "Please Select City Name.<br />";
    }
    if ($userpincode == "") {
        $errorMsg[] = "Please Enter Pincode.<br />";
    }
    if ($service_id == "") {
        $errorMsg[] = "Please Select Service.<br />";
    }
    if ($brand_id == "") {
        $errorMsg[] = "Please Select Brand.<br />";
    }
    if ($issue_id == "") {
        $errorMsg[] = "Please Select Issue.<br />";
    }
    if ($details == "") {
        $errorMsg[] = "Please Enter Details.<br />";
    }

    $random_no = "lead-" . mt_rand(10000000000, 99999999999);

    function check_exist_lead($get_val, $table_name, $label) {
        $databse_call = new DB;
        $db = $databse_call->connect();
        $sel = $db->query("select $label from $table_name where $label = '" . $get_val . "'");
        if (mysqli_num_rows($sel) > 0) {
            $random_no = "lead-" . mt_rand(10000000000, 99999999999);
            $exist = check_exist_lead($random_no, 'tbl_leads', 'lead_id');
            return $exist;
        } else {
            return "";
        }
    }
    
    $leadid_exist = check_exist_lead($random_no, 'tbl_leads', 'lead_id');
    if ($leadid_exist == 1) {
        $errorMsg [] = "Lead ID Already Exist.";
    }


    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    if (count($errorMsg) == 0) {
        
        $time = time();
        $data = $_POST;
        $fields = array("username", "useremail", "usernumber", "useraddress", "cid", "sid", "userpincode", "service_id", "brand_id", "issue_id", "details", "lead_cost");
        $static = ", lead_id='" . $random_no . "', addedon='" . $time . "', status='approved'";
        $insert_id = insert('tbl_leads', $fields, $static, $data, $floor, "");
        if ($insert_id > 0) {
            $success[] = "Added Successfully";
        }
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}
?>