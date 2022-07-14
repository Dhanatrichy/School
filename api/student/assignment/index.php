<?php

include_once('../../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'view_assignment')) {
//        extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $school_id =   $data['school_id'];
        $class_id =   $data['class_id'];
        $section_id =   $data['section_id'];
        
        $query = "SELECT sa.id as id, subject.name as subject_name,sa.attachment, sa.title, sa.addedon, sa.datetime, sa.status 
FROM tbl_student_assignment AS sa
INNER JOIN tbl_teacher as t
ON sa.teacher_id = t.id
INNER JOIN tbl_subject as subject
ON sa.subject_id = subject.id where sa.class_id='".$class_id."' and sa.section_id='".$section_id."' and sa.school_id='".$school_id."' ORDER BY sa.addedon DESC";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {

                $arr[] = array(
                    'subject_name' => $row['subject_name'],
                    'title' => $row['title'],
                    'attachment' => $row['attachment'],
                    'datetime' => $row['datetime'],
                    'addedon' => $row['addedon'],
                    'status' => ucfirst($row['status'])
                );
                
                unset($subject_names);
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'No Result Found', 'result' => 'Data Not Found']);
        }
    }
}
?>
