<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);
    if ($name == "") {
        $errorMsg[] = "Please Enter the School Name.";
    }
    
    if ($principal_name == "") {
        $errorMsg[] = "<br />Please Enter the Principal Name.";
    }
    
    if ($mobile_no == "") {
        $errorMsg[] = "<br />Please Enter the Mobile No.";
    }
    
    if ($email == "") {
        $errorMsg[] = "<br />Please Enter the Email.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[] = "<br />Please Enter the Valid Email.";
    }

    if ($state_id == "") {
        $errorMsg[] = "<br />Please Select State.";
    }

    if ($city_id == "") {
        $errorMsg[] = "<br />Please Select City.";
    }

    if ($zipcode == "") {
        $errorMsg[] = "<br />Please Enter the Zipcode.";
    }

    if ($address == "") {
        $errorMsg[] = "<br />Please Enter the Address.";
    }
    
//    if($id==''){
//        if ($password == "") {
//            $errorMsg[] = "<br />Please Enter the Password.";
//        }
//        $password   =   md5($password);
//        
//    }else{
//        if ($password != "") {
//            $password   = md5($password);
//        }else{
//            $password  =   $edit_password;
//        }
//    }
    
    if ($password == "") {
        $errorMsg[] = "<br />Please Enter the Password.";
    }
    
    if ($address == "") {
        $errorMsg[] = "<br />Please Enter the Address.";
    }
    if($id==''){
        $name_exist = check_exist($name, 'tbl_school', 'name');
        if ($name_exist == 1) {
            $errorMsg[] = "<br />Schoool Name Already Exist.";
        }
    }
    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }

    if (count($errorMsg) == 0) {
        if ($id != "") {
            $data = $_POST;
            $fields = array("school_id","name","email","mobile_no","telephone_no","address","principal_name","school_found","state_id","city_id","zipcode");
            $static = ", password='". $password."'";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_school', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("school_id","name","email","mobile_no","telephone_no","address","principal_name","school_found","state_id","city_id","zipcode");
            $static = ", password='". $password."', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."'";
            $insert_id = insert('tbl_school', $fields, $static, $data, $floor, "");
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
    $update_id = update('tbl_school', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_school where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_school where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {

        $city_name = get_particular_name('name', $row['city_id'], 'tbl_city', 'id');
        $state_name = get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
        
        $address    =   $row['address'].', '.$city_name.'-'.$row['zipcode'].', '.$state_name;

        $list[] = array('id' => $row['id'], 'school_id' => $row['school_id'], 'name' => $row['name'], 'principal_name' => $row['principal_name'], 'school_found' => $row['school_found'], 'email' => $row['email'], 'city' => $city_name, 'state' => $state_name, 'mobile_no' => $row['mobile_no'], 'dated' => $row['datetime'], 'status' => ucfirst($row['status']), 'address' => $address);
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}
?>