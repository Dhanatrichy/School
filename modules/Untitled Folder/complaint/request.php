<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);

    if ($id != "") {
        $data = $_POST;
        $time = time();
        $fields = array("status");
        $static = "";
        $where = " id='" . $id . "'";
        $update_id = update('tbl_complaint', $fields, $static, $data, $where);
        if ($update_id) {
            $success[] = "Updated Successfully.";
        }
    }
    echo json_encode(array('status' => 'success', 'success' => $success));
}

//if (isset($_POST['action']) && $_POST['action'] == 'change_status') {
//    extract($_POST);
//
//    $data = $_POST;
//    $time = time();
//    $fields = array("status");
//    $static = "";
//    $where = " id='" . $id . "'";
//    $update_id = update('tbl_complaint', $fields, $static, $data, $where);
//    if ($update_id) {
//        $success[] = "Changed Successfully.";
//        echo json_encode(array('status' => $status, 'success' => $success));
//    }
//}
//
//if (isset($_POST['action']) && $_POST['action'] == 'delete') {
//    extract($_POST);
//
//    $sql = "delete from tbl_complaint where id='" . $id . "'";
//    $run = mysqli_query($db, $sql);
//    if (mysqli_affected_rows($db) > 0) {
//        $success[] = "Deleted Successfully.";
//        echo json_encode(array('status' => 'success', 'success' => $success));
//    }
//}
//if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
//    extract($_POST);
//
//    $sql = "SELECT * FROM tbl_complaint where id='" . $id . "'";
//    $run = mysqli_query($db, $sql);
//
//    //$list = array();
//    while ($row = mysqli_fetch_assoc($run)) {
//
//        $city_name = get_particular_name('name', $row['cid'], 'tbl_city', 'id');
//        $state_name = get_particular_name('name', $row['sid'], 'tbl_state', 'id');
//
//        $brand = get_particular_name('name', $row['brand_id'], 'tbl_brand', 'id');
//        $issue = get_particular_name('name', $row['issue_id'], 'tbl_issue', 'id');
//        $service = get_particular_name('name', $row['service_id'], 'tbl_service', 'id');
//
//        $address = $row['useraddress'] . ', ' . $city_name . '-' . $row['userpincode'] . ', ' . $state_name;
//
//        $list[] = array('id' => $row['id'], 'lead_id' => $row['lead_id'], 'username' => $row['username'], 'useremail' => $row['useremail'], 'usernumber' => $row['usernumber'], 'useraddress' => $row['useraddress'], 'city' => $city_name, 'state' => $state_name, 'userpincode' => $row['userpincode'], 'brand' => $brand, 'issue' => $issue, 'service' => $service, 'details' => $row['details'], 'verification_code' => $row['verification_code'], 'lead_cost' => $row['lead_cost'], 'addedon' => date('F j, Y', $row['addedon']), 'status' => $row['status'], 'address' => $address);
//    }
//
//    echo json_encode(array('status' => 'success', 'detail' => $list));
//}

if (isset($_POST['action']) && $_POST['action'] == 'view_full_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_complaint where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_assoc($run)) {

        $sql_ven = "SELECT * FROM tbl_vendor where ven_id='" . $row['vid'] . "'";
        $run_ven = mysqli_query($db, $sql_ven);
        while ($row1 = mysqli_fetch_assoc($run_ven)) {
            $vendor_name = $row1['name'];
            $vendor_phone = $row1['phone'];
        }

        $sql_user = "SELECT * FROM tbl_leads where lead_id='" . $row['lid'] . "'";
        $run_user = mysqli_query($db, $sql_user);
        while ($row2 = mysqli_fetch_assoc($run_user)) {
            $city_name = get_particular_name('name', $row2['cid'], 'tbl_city', 'id');
            $state_name = get_particular_name('name', $row2['sid'], 'tbl_state', 'id');
            $issue = get_particular_name('name', $row2['issue_id'], 'tbl_issue', 'id');
            $service = get_particular_name('name', $row2['service_id'], 'tbl_service', 'id');
            $address = $row2['useraddress'] . ', ' . $city_name . '-' . $row2['userpincode'] . ', ' . $state_name;
            $username = $row2['username'];
            $useremail = $row2['useremail'];
            $usernumber = $row2['usernumber'];
        }

        $list[] = array('id' => $row['id'], 'comp_id' => $row['comp_id'], 'username' => $username, 'useremail' => $useremail, 'usernumber' => $usernumber, 'address' => $address, 'issue' => $issue, 'service' => $service, 'complaint_details' => $row['complaint_details'], 'reason' => $row['reason'], 'addedon' => date('F j, Y', $row['addedon']), 'status' => $row['status'], 'vendor_name' => $vendor_name, 'vendor_phone' => $vendor_phone);
    }

    echo json_encode(['status' => 'success', 'detail' => $list]);
}
?>
