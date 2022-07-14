<?php

include_once('../../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'get_assign_class')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $id =   $data['id'];
        
        
        
        $query = "SELECT ca.id as id, t.name as teacher_name, c.name as class_name, sec.name as section_name, sub.name as subject_name, ca.addedon, ca.status 
FROM tbl_class_assign AS ca
INNER JOIN tbl_teacher as t
ON ca.teacher_id = t.id
INNER JOIN tbl_class as c
ON c.id = ca.class_id
INNER JOIN tbl_section as sec
ON sec.id = ca.section_id
INNER JOIN tbl_subject as sub
ON sub.id = ca.subject_id where ca.school_id='".$id."' ORDER BY addedon DESC";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                $arr[] = $row;
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'No Result Found', 'result' => 'Data Not Found']);
        }
    }
}
?>
