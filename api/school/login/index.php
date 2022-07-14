<?php

include_once('../../database.php');


$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'login')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        
        $email      =   $data['email'];
        $password   =   $data['password'];
        

        $query = "select * from tbl_school where email='" . $email . "' and password='" . $password . "' and status='active'";
        $run = mysqli_query($db, $query);
        $count = mysqli_num_rows($run);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
                $arr[] = $row;
            }
            echo json_encode(['status' => 'true', 'data' => $arr, 'result' => 'Data Found']);
        } else {
            echo json_encode(['status' => 'true', 'msg' => 'Invalid Username / Password or Either Your Account Has Been Blocked By Admin.', 'result' => 'Data Not Found']);
        }
    }
}
?>
