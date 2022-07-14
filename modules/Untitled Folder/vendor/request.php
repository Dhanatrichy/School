<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);

    if ($name == "") {
        $errorMsg[] = "Please Enter Vendor Name.<br />";
    }
    if ($email == "") {
        $errorMsg[] = "Please Enter Vendor Email.<br />";
    }
    if ($password == "") {
        $errorMsg[] = "Please Enter Vendor Password.<br />";
    }
    if ($phone == "") {
        $errorMsg[] = "Please Enter Vendor Phone.<br />";
    }
    if ($address == "") {
        $errorMsg[] = "Please Enter Vendor Address.<br />";
    }
    if ($sid == "") {
        $errorMsg[] = "Please Select State Name.<br />";
    }
    if ($cid == "") {
        $errorMsg[] = "Please Select City Name.<br />";
    }
    if ($pincode == "") {
        $errorMsg[] = "Please Enter Pincode.<br />";
    }

    $random_no = "ven-" . mt_rand(100000000, 999999999);


//    function check(){
//        $name_exist = check_exist($random_no, 'tbl_vendor', 'ven_id');
//        if ($name_exist == 1) {
//            check();
//            //$errorMsg[] = "Vendor ID Already Exist.";
//        }
//    }

    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    if (count($errorMsg) == 0) {
        if ($id != "") {
            $data = $_POST;
            $time = time();
            $fields = array("name", "email", "phone", "address", "cid", "sid", "pincode", "password");
            $static = "";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_vendor', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("name", "email", "phone", "address", "cid", "sid", "pincode", "password");
            $static = ", ven_id='" . $random_no . "', addedon='" . $time . "', wallet='0'";
            $insert_id = insert('tbl_vendor', $fields, $static, $data, $floor, "");
            if ($insert_id > 0) {
                $success[] = "Added Successfully";
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
    $update_id = update('tbl_vendor', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_vendor where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_vendor where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {

        $city_name = get_particular_name('name', $row['cid'], 'tbl_city', 'id');
        $state_name = get_particular_name('name', $row['sid'], 'tbl_state', 'id');

        $list[] = array('id' => $row['id'], 'ven_id' => $row['ven_id'], 'name' => $row['name'], 'email' => $row['email'], 'phone' => $row['phone'], 'address' => $row['address'], 'city' => $city_name, 'state' => $state_name, 'pincode' => $row['pincode'], 'wallet' => $row['wallet'], 'password' => $row['password'], 'gstin' => $row['gstin'], 'idprooftype' => $row['idprooftype'], 'idproofno' => $row['idproofno'], 'proofimage' => $row['proofimage'], 'addedon' => date('F j, Y', $row['addedon']), 'status' => ucwords($row['status']));
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}
?>