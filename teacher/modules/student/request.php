<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);
    
    if ($name == "") {
        $errorMsg[] = "Please Enter the Student Name.";
    }
    
    if ($class_id == "") {
        $errorMsg[] = "<br />Please Select Class";
    }
    
    if ($section_id == "") {
        $errorMsg[] = "<br />Please Select Section";
    }
    
    if ($email == "") {
        $errorMsg[] = "<br />Please Enter the Email.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[] = "<br />Please Enter the Valid Email.";
    }
    
    if($id==''){
        $email_exist = check_exist($email, 'tbl_student', 'email');
        if ($email_exist == 1) {
            $errorMsg[] = "<br />Email Id Already Exist.";
        }
    }
    
    if ($password == "") {
        $errorMsg[] = "<br />Please Enter the Password.";
    }
    
    if ($contact == "") {
        $errorMsg[] = "<br />Please Enter the Mobile No.";
    }
    
    if ($father_name == "") {
        $errorMsg[] = "<br />Please Enter the Father Name.";
    }
    
    if ($mother_name == "") {
        $errorMsg[] = "<br />Please Enter the Mother Name.";
    }
    
    if ($dob == "") {
        $errorMsg[] = "<br />Please Enter the Date Of Birth.";
    }
    
    if ($address == "") {
        $errorMsg[] = "<br />Please Enter the Address.";
    }
    
    if ($zipcode == "") {
        $errorMsg[] = "<br />Please Enter the Zipcode.";
    }
    
    if ($state_id == "") {
        $errorMsg[] = "<br />Please Select State.";
    }
    if ($city_id == "") {
        $errorMsg[] = "<br />Please Select City.";
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
            $fields = array("name","email","contact","address","state_id","city_id","zipcode","class_id","section_id","father_name","mother_name","dob");
            $static = ", password='". $password."', subjects='". $subjects."', school_id='".$_SESSION['school_id']."'";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_student', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("name","email","contact","address","state_id","city_id","zipcode","class_id","section_id","father_name","mother_name","dob");
            $static = ", password='". $password."', subjects='". $subjects."', school_id='".$_SESSION['school_id']."', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."'";
            $insert_id = insert('tbl_student', $fields, $static, $data, $floor, "");
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
    $update_id = update('tbl_student', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_student where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_student where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {

        $city_name = get_particular_name('name', $row['city_id'], 'tbl_city', 'id');
        $state_name = get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
        $class = get_particular_name('name', $row['class_id'], 'tbl_class', 'id');
        $section = get_particular_name('name', $row['section_id'], 'tbl_section', 'id');
        $school_name = get_particular_name('name', $row['school_id'], 'tbl_school', 'id');
        
        $subject_decode =   json_decode($row['subjects']);
        foreach($subject_decode as $subjects){
            $subject_names  .=   get_particular_name('name', $subjects, 'tbl_subject', 'id').'<br />';
        }
        //$subject_names  =   trim($subject_names,', ');
        
        $address    =   $row['address'].', '.$city_name.'-'.$row['zipcode'].', '.$state_name;

        $list[] = array(
            'id' => $row['id'],
            'school_name' => $school_name,
            'name' => $row['name'],
            'email' => $row['email'],
            'mobile_no' => $row['contact'],
            'father_name' => $row['father_name'],
            'mother_name' => $row['mother_name'],
            'subjects' => $subject_names,
            'dated' => $row['datetime'],
            'status' => ucfirst($row['status']),
            'address' => $address,
            'class' => $class.' - '.$section,
            'dob' => $row['dob']
        );
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}
?>