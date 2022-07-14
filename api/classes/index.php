<?php

include_once('../database.php');


$errorMsg = array();
$success = array();

if (isset($_GET["action"])) {

    if (($_GET["action"] == 'get_classes')) {

        $query = "select * from tbl_class where status='active' ORDER BY id ASC";
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
