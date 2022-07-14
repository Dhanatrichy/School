<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();


if (isset($_POST['action']) && $_POST['action'] == 'change_status') {
    extract($_POST);

    $data = $_POST;
    $time = time();
    $fields = array("order_status");
    $static = "";
    $where = " order_id='" . $id . "'";
    $update_id = update('tbl_order', $fields, $static, $data, $where);
    if ($update_id) {
        if($order_status=='new'){
            $success[] = "Status Changed Successfully.";
        }
        
        if($order_status=='shipped'){
            $success[] = "Order Shipped Successfully.";
        }
        
        if($order_status=='completed'){
            $success[] = "Order Completed Successfully.";
        }
        
        
        echo json_encode(array('status' => 'success', 'success' => $success));
    }else{
        echo json_encode(array('status' => 'error', 'success' => 'Something went wrong !!'));
    }
}
?>