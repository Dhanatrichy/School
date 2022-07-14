<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    extract($_POST);
    
    
    if ($class_id == "") {
        $errorMsg[] = "<br />Please Select Class";
    }
    
    if ($section_id == "") {
        $errorMsg[] = "<br />Please Select Section";
    }
    
    if ($student_id == "") {
        $errorMsg[] = "<br />Please Select Student.";
    }
    
    if ($subject_id == "") {
        $errorMsg[] = "<br />Please Select Subject.";
    }

    if ($year == "") {
        $errorMsg[] = "<br />Please Select Year.";
    }

    if ($total_marks == "") {
        $errorMsg[] = "<br />Please Enter Total Marks.";
    }
    
    if ($obtained_marks == "") {
        $errorMsg[] = "<br />Please Enter Obtained Marks.";
    }


    $query = "select * from tbl_subject_mark where student_id='" . $student_id . "' and subject_id='" . $subject_id . "' and year='" . $year . "'";
    $run = mysqli_query($db, $query);
    $row_count = mysqli_num_rows($run);
    if ($row_count > 0) {
        $errorMsg[] = "<br />Marks for this Subject already uploaded.";
    }
    
    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }

    if (count($errorMsg) == 0) {

        if ($id != "") {
            $data = $_POST;
            $fields = array("class_id","section_id","student_id","subject_id","year","total_marks","obtained_marks");
            $static = "";
            $where = " subject_mark_id='" . $id . "'";
            $update_id = update('tbl_subject_mark', $fields, $static, $data, $where);
            if ($update_id) {
                $success[] = "Updated Successfully.";
            }
        } else {
            $time = time();
            $data = $_POST;
            $fields = array("class_id","section_id","student_id","subject_id","year","total_marks","obtained_marks");
            $static = ", school_id='".$_SESSION['school_id']."', teacher_id='".$_SESSION['teacher_id']."', addedon='".$time."', datetime='".date("Y-m-d H:i:s", $time)."'";
            $insert_id = insert('tbl_subject_mark', $fields, $static, $data, $floor, "");
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
    $where = " subject_mark_id='" . $id . "'";
    $update_id = update('tbl_subject_mark', $fields, $static, $data, $where);
    if ($update_id) {
        $success[] = "Changed Successfully.";
        echo json_encode(array('status' => $status, 'success' => $success));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    extract($_POST);

    $sql = "delete from tbl_subject_mark where subject_mark_id='" . $id . "'";
    $run = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $success[] = "Deleted Successfully.";
        echo json_encode(array('status' => 'success', 'success' => $success));
    }
}

?>