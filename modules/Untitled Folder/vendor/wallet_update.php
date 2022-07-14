<?php

include_once '../../includes/database.php';
$errorMsg = array();
$success = array();

if (isset($_POST['action']) && $_POST['action'] == 'add_money_to_vendor') {
    extract($_POST);

    if ($remark == "") {
        $errorMsg[] = "Please Enter Message.<br />";
    }
    if ($amount == "") {
        $errorMsg[] = "Please Enter Amount.<br />";
    }

    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    if (count($errorMsg) == 0) {
        $new_amount =   ($wallet_amount+$amount);
        
        $sql    =   "insert into tbl_wallet_updation(admin_id,vid,remark,amount,amount_process,addedon)values('".$_SESSION['admin_id']."','".$id."','".$remark."','".$amount."','Addition','".time()."')";
        $run    =   mysqli_query($db, $sql);
        if($run>0){
            
            $update =   "update tbl_vendor set wallet='".$new_amount."' where id='".$id."'";
            $run1    =   mysqli_query($db, $update);
            if($run1>0){
                $ven_id = get_particular_name('ven_id', $id, 'tbl_vendor', 'id');
                $msg    =   "Admin has added Rs. ".$amount." in your wallet with the remark - ".$remark;
                
                $insert_noti = "insert into tbl_notification(session_id,user_type,title,message,remark,addedon)values('" . $ven_id . "','vendor','Wallet Addition','".$msg."','Wallet Addition','" . time() . "')";
                $run_noti = mysqli_query($db, $insert_noti);
                
                $success[] = "Added Successfully";
                echo json_encode(array('status' => 'success', 'success' => $success, 'wallet_balance' => $new_amount, 'id' => $id));
            }
        }
        
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'deduct_money_from_vendor') {
    extract($_POST);

    if ($remark == "") {
        $errorMsg[] = "Please Enter Message.<br />";
    }
    if ($amount == "") {
        $errorMsg[] = "Please Enter Amount.<br />";
    }

    if (count($errorMsg) > 0) {
        echo json_encode(array('status' => 'error', 'errors' => $errorMsg));
    }
    if (count($errorMsg) == 0) {
        $new_amount =   ($wallet_amount-$amount);
        
        $sql    =   "insert into tbl_wallet_updation(admin_id,vid,remark,amount,amount_process,addedon)values('".$_SESSION['admin_id']."','".$id."','".$remark."','".$amount."','Deduction','".time()."')";
        $run    =   mysqli_query($db, $sql);
        if($run>0){
            
            $update =   "update tbl_vendor set wallet='".$new_amount."' where id='".$id."'";
            $run1    =   mysqli_query($db, $update);
            if($run1>0){
                $ven_id = get_particular_name('ven_id', $id, 'tbl_vendor', 'id');
                $msg    =   "Admin has deducted Rs. ".$amount." from your wallet with the remark - ".$remark;
                
                $insert_noti = "insert into tbl_notification(session_id,user_type,title,message,remark,addedon)values('" . $ven_id . "','vendor','Wallet Deduction','".$msg."','Wallet Deduction','" . time() . "')";
                $run_noti = mysqli_query($db, $insert_noti);
                
                $success[] = "Added Successfully";
                echo json_encode(array('status' => 'success', 'success' => $success, 'wallet_balance' => $new_amount, 'id' => $id));
            }
        }
        
    }
}



if (isset($_POST['action']) && $_POST['action'] == 'view_detail') {
    extract($_POST);

    $sql = "SELECT * FROM tbl_vendor where id='" . $id . "'";
    $run = mysqli_query($db, $sql);

    //$list = array();
    while ($row = mysqli_fetch_assoc($run)) {
        $list[] = array('id' => $row['id'], 'ven_id' => $row['ven_id'], 'wallet' => $row['wallet']);
    }

    echo json_encode(array('status' => 'success', 'detail' => $list));
}
?>