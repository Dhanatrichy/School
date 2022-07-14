<?php

include_once('../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {
    if (($_GET["action"] == 'view_marks')) {

        $data = json_decode(file_get_contents("php://input"), TRUE);

        $school_id = $data['school_id'];
        $teacher_id = $data['teacher_id'];
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $subject_id = $data['subject_id'];
        $year = $data['year'];
        $time   =   time();
        $count = 0;
        
        
        $query = "SELECT sm.*, student.name as student_name FROM tbl_subject_mark AS sm LEFT JOIN tbl_student as student ON student.id = sm.student_id where sm.school_id='" . $school_id . "' and sm.class_id='" . $class_id . "' and sm.section_id='" . $section_id . "' and sm.subject_id='" . $subject_id . "' and sm.year='" . $year . "' ORDER BY sm.student_id ASC";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                $school_id = $row['school_id'];
                $teacher_id = $row['teacher_id'];
                $class_id = $row['class_id'];
                $section_id = $row['section_id'];
                $subject_id = $row['subject_id'];
                $year = $row['year'];

                $student_marks[] = array(
                    'id' => $row['student_id'],
                    'student_name' => $row['student_name'],
                    'total_marks' => $row['total_marks'],
                    'obtained_marks' => $row['obtained_marks']
                );
            }

            $subject_marks[] = array(
                'school_id' => $school_id,
                'teacher_id' => $teacher_id,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
                'year' => $year,
                'student_marks' => $student_marks
            );
            
             echo json_encode(['status' => 'true', 'data' => $subject_marks, 'result' => 'Data Found']);
        }else{
            echo json_encode(['status' => 'false', 'msg' => 'No Result Found', 'result' => 'Data Not Found']);
        }
    }
}
?>
