<?php

include_once('../../database.php');


$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'get_students')) {
        // extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $id =   $data['id'];
        

        $query = "select * from tbl_student where school_id='" . $id . "'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                
                $state_name  =   get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
                $city_name  =   get_particular_name('name', $row['city_id'], 'tbl_city', 'id');
                $class = get_particular_name('name', $row['class_id'], 'tbl_class', 'id');
                $section = get_particular_name('name', $row['section_id'], 'tbl_section', 'id');
                
                $subject_decode =   json_decode($row['subjects']);
                foreach($subject_decode as $subjects){
                    $subject_names[]    =   get_particular_name('name', $subjects, 'tbl_subject', 'id');
                }

                $arr[] = array(
                    'id' => $row['id'],
                    'user_type' => $row['user_type'],
                    'school_id' => $row['school_id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'mobile_no' => $row['contact'],
                    'father_name' => $row['father_name'],
                    'mother_name' => $row['mother_name'],
                    'dob' => $row['dob'],
                    'address' => $row['address'],
                    'state' => $state_name,
                    'city' => $city_name,
                    'zipcode' => $row['zipcode'],
                    'class' => $class,
                    'section' => $section,
                    'subjects' => $subject_names,
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
