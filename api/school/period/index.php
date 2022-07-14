<?php

include_once('../../database.php');


$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'get_period')) {
        //extract($_POST);

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $id =   $data['id'];
        

        $query = "select * from tbl_period where school_id='" . $id . "'";
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
