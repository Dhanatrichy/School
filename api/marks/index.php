<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'add_marks')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        
        $school_id = $data['school_id'];
        $teacher_id = $data['teacher_id'];
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $subject_id = $data['subject_id'];
        $year = $data['year'];
        $time   =   time();
        $count=0;

        foreach ($data['student_marks'] as $student_mark) {
            
            $check_query = "select * from tbl_subject_mark where student_id='" . $student_mark['id'] . "' and subject_id='" . $subject_id . "' and year='" . $year . "'";
            $check_run = mysqli_query($db, $check_query);
            $row_count = mysqli_num_rows($check_run);
            if ($row_count == 0) {
                $query = "insert into tbl_subject_mark(school_id,teacher_id,class_id,section_id,subject_id,year,student_id,total_marks,obtained_marks,addedon,datetime)values('" . $school_id . "','" . $teacher_id . "','" . $class_id . "','" . $section_id . "','" . $subject_id . "','" . $year . "','" . $student_mark['id'] . "','" . $student_mark['total_marks'] . "','" . $student_mark['obtained_marks'] . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                $run = mysqli_query($db, $query);
                if(mysqli_insert_id($db)>0){
                    $count++;
                }
            }
        }
        if($count>0){
            echo json_encode(['status' => 'true', 'msg' => $count.' Record Submitted Successfully', 'result' => 'Operation Complete']);
        }else{
            echo json_encode(['status' => 'true', 'msg' => "0 Record Submitted Successfully", 'result' => 'Error']);
        }

    }
    
    
    if (($_GET["action"] == 'edit_marks')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        
        $school_id = $data['school_id'];
        $teacher_id = $data['teacher_id'];
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $subject_id = $data['subject_id'];
        $year = $data['year'];
        $time   =   time();
        $count=0;

        $delete = "delete from tbl_subject_mark where school_id='" . $school_id . "' and class_id='" . $class_id . "' and section_id='" . $section_id . "' and subject_id='" . $subject_id . "' and year='" . $year . "'";
        $run_delete = mysqli_query($db, $delete);
        if (mysqli_affected_rows($db) > 0) {
            foreach ($data['student_marks'] as $student_mark) {

                $query = "insert into tbl_subject_mark(school_id,teacher_id,class_id,section_id,subject_id,year,student_id,total_marks,obtained_marks,addedon,datetime)values('" . $school_id . "','" . $teacher_id . "','" . $class_id . "','" . $section_id . "','" . $subject_id . "','" . $year . "','" . $student_mark['id'] . "','" . $student_mark['total_marks'] . "','" . $student_mark['obtained_marks'] . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                $run = mysqli_query($db, $query);
                if(mysqli_insert_id($db)>0){
                    $count++;
                }
            }
            if($count>0){
                echo json_encode(['status' => 'true', 'msg' => $count.' Record Submitted Successfully', 'result' => 'Operation Complete']);
            }else{
                echo json_encode(['status' => 'true', 'msg' => "0 Record Submitted Successfully", 'result' => 'Error']);
            }
        }
    }
}
?>
