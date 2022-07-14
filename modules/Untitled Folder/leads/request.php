<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);

    if ($lead_cost == "") {
        $errorMsg[] = "Please Enter Lead Cost.<br />";
    }

    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    if (count($errorMsg) == 0) {
        if ($id != "") {
            $data = $_POST;
            $time = time();
            $fields = array("lead_cost", "status");
            $static = "";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_leads', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        }
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'change_status') {
    extract($_POST);

    $data = $_POST;
    $time = time();
    $fields = array("status");
    $static = "";
    $where = " id='" . $id . "'";
    $update_id = update('tbl_leads', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_leads where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_leads where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {

        $city_name = get_particular_name('name', $row['cid'], 'tbl_city', 'id');
        $state_name = get_particular_name('name', $row['sid'], 'tbl_state', 'id');
        
        $brand  = get_particular_name('name', $row['brand_id'], 'tbl_brand', 'id');
        $issue  = get_particular_name('name', $row['issue_id'], 'tbl_issue', 'id');
        $service= get_particular_name('name', $row['service_id'], 'tbl_service', 'id');
        
        $address    =   $row['useraddress'].', '.$city_name.'-'.$row['userpincode'].', '.$state_name;

        $list[] = array('id' => $row['id'], 'lead_id' => $row['lead_id'], 'username' => $row['username'], 'useremail' => $row['useremail'], 'usernumber' => $row['usernumber'], 'useraddress' => $row['useraddress'], 'city' => $city_name, 'state' => $state_name, 'userpincode' => $row['userpincode'], 'brand' => $brand, 'issue' => $issue, 'service' => $service, 'details' => $row['details'], 'verification_code' => $row['verification_code'], 'lead_cost' => $row['lead_cost'], 'addedon' => date('F j, Y', $row['addedon']), 'status' => $row['status'], 'address' => $address);
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}

if (isset($_POST['action']) && $_POST['action'] == 'view_full_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_leads where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {

        $city_name = get_particular_name('name', $row['cid'], 'tbl_city', 'id');
        $state_name = get_particular_name('name', $row['sid'], 'tbl_state', 'id');
        
        $brand  = get_particular_name('name', $row['brand_id'], 'tbl_brand', 'id');
        $issue  = get_particular_name('name', $row['issue_id'], 'tbl_issue', 'id');
        $service= get_particular_name('name', $row['service_id'], 'tbl_service', 'id');
        
        $vendor_name = get_particular_name('name', $row['vid'], 'tbl_vendor', 'id');
        $vendor_phone = get_particular_name('phone', $row['vid'], 'tbl_vendor', 'id');
        
        $address    =   $row['useraddress'].', '.$city_name.'-'.$row['userpincode'].', '.$state_name;

        $list[] = array('id' => $row['id'], 'lead_id' => $row['lead_id'], 'username' => $row['username'], 'useremail' => $row['useremail'], 'usernumber' => $row['usernumber'], 'useraddress' => $row['useraddress'], 'city' => $city_name, 'state' => $state_name, 'userpincode' => $row['userpincode'], 'brand' => $brand, 'issue' => $issue, 'service' => $service, 'details' => $row['details'], 'verification_code' => $row['verification_code'], 'lead_cost' => $row['lead_cost'], 'addedon' => date('F j, Y', $row['addedon']), 'status' => $row['status'], 'address' => $address, 'vendor_name' => $vendor_name, 'vendor_phone' => $vendor_phone);
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}
?>