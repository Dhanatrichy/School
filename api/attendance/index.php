<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'add_attendance')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        
        $school_id = $data['school_id'];
        $teacher_id = $data['teacher_id'];
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $date = $data['date'];
        $session = $data['session'];
        $time   =   time();
        $count=0;
        
        $query = "select * from tbl_attendance_check where school_id='" . $school_id . "' and class_id='" . $class_id . "' and section_id='" . $section_id . "' and date='" . $date . "' and session='" . $session . "'";
        $run = mysqli_query($db, $query);
        $row_count = mysqli_num_rows($run);
        if ($row_count == 0) {
            foreach ($data['attendence'] as $attendance) {
            
                $insert =   "insert into tbl_student_attendance(school_id,teacher_id,class_id,section_id,student_id,attendance,date,session,addedon,datetime)values('" . $school_id . "','" . $teacher_id . "','" . $class_id . "','" . $section_id . "','" . $attendance['id'] . "','" . $attendance['present_status'] . "','" . $date . "','" . $session . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                $run_insert =   mysqli_query($db, $insert);
                if(mysqli_insert_id($db)>0){
                    $count++;
                }
            }
            if($count>0){
                $insert_check =   "insert into tbl_attendance_check(school_id,class_id,section_id,date,session,addedon,datetime)values('" . $school_id . "','" . $class_id . "','" . $section_id . "','" . $date . "','" . $session . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                $run_insert_check =   mysqli_query($db, $insert_check);
                
                echo json_encode(['status' => 'true', 'msg' => $count.' Record Submitted Successfully', 'result' => 'Operation Complete']);
            }
        }else{
            echo json_encode(['status' => 'true', 'msg' => "Attendance Already Uploaded", 'result' => 'Error']);
        }
    }
    
    
    if (($_GET["action"] == 'edit_attendance')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        
        $school_id = $data['school_id'];
        $teacher_id = $data['teacher_id'];
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $date = $data['date'];
        $session = $data['session'];
        $time   =   time();
        $count=0;
        
        $delete = "delete from tbl_student_attendance where school_id='" . $school_id . "' and class_id='" . $class_id . "' and section_id='" . $section_id . "' and date='" . $date . "' and session='" . $session . "'";
        $run_delete = mysqli_query($db, $delete);
        if (mysqli_affected_rows($db) > 0) {
            foreach ($data['attendence'] as $attendance) {
            
                $insert =   "insert into tbl_student_attendance(school_id,teacher_id,class_id,section_id,student_id,attendance,date,session,addedon,datetime)values('" . $school_id . "','" . $teacher_id . "','" . $class_id . "','" . $section_id . "','" . $attendance['id'] . "','" . $attendance['present_status'] . "','" . $date . "','" . $session . "','" . $time . "','" . date("Y-m-d H:i:s", $time) . "')";
                $run_insert =   mysqli_query($db, $insert);
                if(mysqli_insert_id($db)>0){
                    $count++;
                }
            }
            if($count>0){
                echo json_encode(['status' => 'true', 'msg' => $count.' Record Submitted Successfully', 'result' => 'Operation Complete']);
            }
        }
    }
    
}
?>
