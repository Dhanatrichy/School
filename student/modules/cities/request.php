<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);
    if ($sid == "") {
        $errorMsg[] = "Please Select State Name.<br />";
    }
    if ($name == "") {
        $errorMsg[] = "Please Enter The City Name.";
    }
    $name_exist = check_exist($name, 'tbl_city', 'name');
    if ($name_exist == 1) {
        $errorMsg[] = "City Name Already Exist.";
    }
    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    if (count($errorMsg) == 0) {
        if ($id != "") {
            $data = $_POST;
            $time = time();
            $fields = array("name", "sid");
            $static = "";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_city', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("name", "sid");
            $static = "";
            $insert_id = insert('tbl_city', $fields, $static, $data, $floor, "");
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
    $update_id = update('tbl_city', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_city where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}
?>