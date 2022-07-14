<?php

include_once('../../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'login')) {
//        extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);        

        $email      =   $data['email'];
        $password   =   $data['password'];
        
        $query = "select * from tbl_student where email='" . $email . "' and password='" . $password . "' and status='active'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                //$arr[] = $row;
                
                $state_name  =   get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
                $city_name  =   get_particular_name('name', $row['city_id'], 'tbl_city', 'id');
                $class = get_particular_name('name', $row['class_id'], 'tbl_class', 'id');
                $section = get_particular_name('name', $row['section_id'], 'tbl_section', 'id');
                $school_name  =   get_particular_name('name', $row['school_id'], 'tbl_school', 'id');
                
                $subject_decode =   json_decode($row['subjects']);
                foreach($subject_decode as $subjects){
                    $subject_names[]    =   get_particular_name('name', $subjects, 'tbl_subject', 'id');
                }
                //$subject_names  =   trim($subject_names,', ');
                
                
                $arr[] = array(
                    'id' => $row['id'],
                    'user_type' => $row['user_type'],
                    'school_id' => $row['school_id'],
                    'school_name' => $school_name,
                    'class_id' => $row['class_id'],
                    'class' => $class,
                    'section_id' => $row['section_id'],
                    'section' => $section,
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'contact' => $row['contact'],
                    'father_name' => $row['father_name'],
                    'mother_name' => $row['mother_name'],
                    'dob' => $row['dob'],
                    'address' => $row['address'],
                    'zipcode' => $row['zipcode'],
                    'state' => $state_name,
                    'city' => $city_name,
                    'zipcode' => $row['zipcode'],
                    'subjects' => $subject_names,
                    'datetime' => $row['datetime'],
                    'addedon' => $row['addedon'],
                    'status' => ucfirst($row['status'])
                );
                
                unset($subject_names);
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'Invalid Username / Password or Either Your Account Has Been Blocked By Admin.', 'result' => 'Data Not Found']);
        }
    }
}
?>
