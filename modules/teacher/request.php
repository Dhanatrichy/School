<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);
    
    if ($name == "") {
        $errorMsg[] = "Please Enter the Teacher Name.";
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
    
    if ($qualification == "") {
        $errorMsg[] = "<br />Please Add Qualification.";
    }
    
    if ($experience == "") {
        $errorMsg[] = "<br />Please Add Experience.";
    }
    
    if (count($subjects) == 0) {
        $errorMsg[] = "<br />Please Select Subjects.";
    }
    
    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    
    $subjects   =   json_encode($_POST['subjects']);

    if (count($errorMsg) == 0) {
        if ($id != "") {
            $data = $_POST;
            $fields = array("school_id","name","email","mobile_no","address","state_id","city_id","zipcode","qualification","experience");
            $static = ", password='". $password."', subjects='". $subjects."'";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_teacher', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("school_id","name","email","mobile_no","address","state_id","city_id","zipcode","qualification","experience");
            $static = ", password='". $password."', subjects='". $subjects."', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."'";
            $insert_id = insert('tbl_teacher', $fields, $static, $data, $floor, "");
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
    $update_id = update('tbl_teacher', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_teacher where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_teacher where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {

        $city_name = get_particular_name('name', $row['city_id'], 'tbl_city', 'id');
        $state_name = get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
        $school_name = get_particular_name('name', $row['school_id'], 'tbl_school', 'id');
        
        $subject_decode =   json_decode($row['subjects']);
        foreach($subject_decode as $subjects){
            $subject_names  .=   get_particular_name('name', $subjects, 'tbl_subject', 'id').', ';
        }
        $subject_names  =   trim($subject_names,', ');
        
        $address    =   $row['address'].', '.$city_name.'-'.$row['zipcode'].', '.$state_name;

        $list[] = array('id' => $row['id'], 'school_name' => $school_name, 'name' => $row['name'], 'email' => $row['email'], 'city' => $city_name, 'state' => $state_name, 'mobile_no' => $row['mobile_no'], 'qualification' => $row['qualification'], 'experience' => $row['experience'], 'subjects' => $subject_names, 'dated' => $row['datetime'], 'status' => ucfirst($row['status']), 'address' => $address);
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}
?>