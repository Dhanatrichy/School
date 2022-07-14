<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'view_attendance')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);

        $school_id = $data['school_id'];
        $teacher_id = $data['teacher_id'];
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $date = $data['date'];
        $session = $data['session'];
        $time = time();
        $count = 0;
        
        
        $query = "SELECT sa.student_attendance_id as student_attendance_id, sa.school_id as school_id, sa.teacher_id as teacher_id,sa.session as session,sa.class_id as class_id,sa.section_id as section_id, sa.date as date, sa.student_id as student_id, sa.attendance as attendance, student.name as student_name, sa.addedon, sa.status 
FROM tbl_student_attendance AS sa
INNER JOIN tbl_student as student
ON student.id = sa.student_id where sa.school_id='" . $school_id . "' and sa.class_id='" . $class_id . "' and sa.section_id='" . $section_id . "' and sa.date='" . $date . "' and sa.session='" . $session . "' ORDER BY sa.student_attendance_id ASC";

        //$query = "select * from tbl_student_attendance where school_id='" . $school_id . "' and class_id='" . $class_id . "' and section_id='" . $section_id . "' and date='" . $date . "' and session='" . $session . "'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                $school_id = $row['school_id'];
                $teacher_id = $row['teacher_id'];
                $session = $row['session'];
                $class_id = $row['class_id'];
                $section_id = $row['section_id'];
                $date = $row['date'];

                $attendance[] = array(
                    'id' => $row['student_id'],
                    'student_name' => $row['student_name'],
                    'present_status' => $row['attendance']
                );
            }

            $student_attendance[] = array(
                'school_id' => $school_id,
                'teacher_id' => $teacher_id,
                'session' => $session,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'date' => $date,
                'attendance' => $attendance
            );
            
             echo json_encode(['status' => 'true', 'data' => $student_attendance, 'result' => 'Data Found']);
        }else{
            echo json_encode(['status' => 'false', 'msg' => 'No Result Found', 'result' => 'Data Not Found']);
        }
    }
}
?>
