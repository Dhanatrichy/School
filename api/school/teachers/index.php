<?php

include_once('../../database.php');

$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'get_teachers')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $id =   $data['id'];

        $query = "select * from tbl_teacher where school_id='" . $id . "'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                
                $state_name  =   get_particular_name('name', $row['state_id'], 'tbl_state', 'id');
                $city_name  =   get_particular_name('name', $row['city_id'], 'tbl_city', 'id').'-'.$row['zipcode'];
                
                $subject_decode =   json_decode($row['subjects']);
                foreach($subject_decode as $subjects){
                    $subject_names[]    =   get_particular_name('name', $subjects, 'tbl_subject', 'id');
                }
                //$subject_names  =   trim($subject_names,', ');
                
                
                $arr[] = array(
                    'id' => $row['id'],
                    'user_type' => $row['user_type'],
                    'school_id' => $row['school_id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'address' => $row['address'],
                    'mobile_no' => $row['mobile_no'],
                    'state' => $state_name,
                    'city' => $city_name,
                    'zipcode' => $row['zipcode'],
                    'qualification' => $row['qualification'],
                    'experience' => $row['experience'],
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
