<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);

    if ($teacher_id == "") {
        $errorMsg[] = "Please Select Teacher Name.";
    }

    if ($class_id == "") {
        $errorMsg[] = "<br />Please Select Class.";
    }

    if ($section_id == "") {
        $errorMsg[] = "<br />Please Select Section.";
    }

    if ($subject_id == "") {
        $errorMsg[] = "<br />Please Select Subject.";
    }
    
    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }

    if (count($errorMsg) == 0) {
        if ($id != "") {
            $data = $_POST;
            $time = time();
            $fields = array("teacher_id","class_id","section_id","subject_id");
            $static = "";
            $where = " id='" . $id . "'";
            $update_id = update('tbl_class_assign', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("teacher_id","class_id","section_id","subject_id");
            $static = ", school_id='".$_SESSION['school_id']."', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."'";
            $insert_id = insert('tbl_class_assign', $fields, $static, $data, $floor, "");
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
    $update_id = update('tbl_class_assign', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_class_assign where id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}
?>