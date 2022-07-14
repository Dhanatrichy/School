<?php
function get_particular_name($get_name, $get_id, $table_name, $table_id) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select $get_name from $table_name where $table_id = '" . $get_id . "'");
    $row = mysqli_fetch_assoc($sel);
    return $r_val = $row[$get_name];
}

function check_exist($get_val, $table_name, $label) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select $label from $table_name where $label = '" . $get_val . "'");
    if (mysqli_num_rows($sel) > 0) {
        return 1;
    } else {
        return "";
    }
}

function checkEmail($email) {
    $sql = "select com_email from tbl_companyprofile where com_email ='" . $email . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return "1";
    }
    return "0";
}

function getUsersCount($type) {
    $sql = "select count(*) as total from tbl_users where user_type='Registered'";
    if ($type == "Active") {
        $sql .= " and status='1'";
    } else if ($type == "Inactive") {
        $sql .= " and status='0'";
    }
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['total'];
    }
}

function check_slug($slug, $tbl, $id) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    if ($id == "") {
        $sel = $db->query("select slug from $tbl");
    } else {
        $sel = $db->query("select slug from $tbl where id != $id");
    }

    while ($row = mysqli_fetch_assoc($sel)) {
        $table_slug = $row['slug'];
        if ($table_slug == $slug) {

            return '1';
        }
    }
}


//Count Total Rows In A table
function give_count($tbl,$field_name,$id) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select * from $tbl where $field_name='".$id."'");
    $total_rows = mysqli_num_rows($sel);
    return $total_rows;
}


//Count Total Rows In A table
function count_total_num_row($tbl) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select * from $tbl");
    $total_rows = mysqli_num_rows($sel);
    return $total_rows;
}

function send_email($to, $subject, $message) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: CME <vijender@thebuildart.in>' . "\r\n";
    $check_mail = mail($to, $subject, $message, $headers);
    if ($check_mail > 0) {
        $return_result = "1";
    }
    return $return_result;
    //echo "1";
}

function encode_id($id) {
    return base64_encode($id);   // Encode the ID
}

function decode_id($id) {   // decode the ID
    return intval(base64_decode($id));
}

//Get Date and time format from string
function time_to_date_and_time($date) {
    $newdate = date('d-M-Y , h:i A', $date);
    return $newdate;
}

function humanTiming($time) {
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit)
            continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }
}

function checkValidImage($image) {
    $ext = end(explode(".", $image));
    if (in_array($ext, $GLOBALS['arrValidImageType'])) {
        return true;
    }
    return false;
}

function is_valid_email($email) {
    if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $email))
        return false;
    return true;
}

function secureSuperGlobal($var) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $var = htmlspecialchars(stripslashes($var));
    $var = str_ireplace("script", "blocked", $var);
    $var = mysqli_escape_string($db, $var);
    return $var;
}

function insert($tbl, $fields, $static_fields, $data, $where) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    foreach ($fields as $key => $field) {
        $bits[] = "`$field` = '" . secureSuperGlobal($data[$field]) . "'";
    }
    $setStr = implode(",", $bits);
    $sql = "insert into $tbl set " . $setStr . $static_fields;
    $query = $db->query($sql) or die("Mysqli insertion error : " . mysqli_error());
    return mysqli_insert_id($db);
}

function update($tbl, $fields, $static_fields, $data, $where) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    foreach ($fields as $key => $field) {
        $bits[] = "`$field` = '" . secureSuperGlobal($data[$field]) . "'";
    }
    $setStr = implode(",", $bits);
    $sql = "update $tbl set $setStr $static_fields where $where";
    $sqlRs = mysqli_query($db, $sql) or die("Mysqli updation error : " . mysqli_error());
    return true;
}

function select($sql_query) {
    
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query($sql_query);
    if (mysqli_num_rows($sel) > 0) {
        return $row = mysqli_fetch_array($res);;
    } else {
        return "";
    }
}

function sendmail($to, $subject, $msg, $mailheaders) {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Additional headers
    $headers .= $mailheaders;
    //echo $msg;
    if (mail($to, $subject, $msg, $headers)) {
        return true;
    } else {
        return false;
    }
}

function multipal_insert_data($tbl, $common_id, $data, $first, $second, $where=null) {

    $databse_call = new DB;
    $db = $databse_call->connect();

    if (!empty($where)) {
        $deleteQuery = "DELETE FROM $tbl WHERE $first ='" . $where . "'";
        $delete = mysqli_query($db, $deleteQuery);
    }

    $countItems = count($data);
    for ($i=0; $i<$countItems; $i++)
    {
        $data[$i] = $data[$i];
        $sql = "INSERT INTO $tbl ($first, $second) VALUES ($common_id, '".$data[$i]."')";
        $sqlRs = mysqli_query($db, $sql) or die("Mysqli insert multipal error : " . mysqli_error());
    }
    return true;
    
}

function select_other_data($tbl, $tbl2, $common_field, $field_name, $id) {
    
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("SELECT t1.*,t2.* from $tbl t1 INNER JOIN $tbl2 t2 ON t2.id=t1.$field_name where $common_field='".$id."'");
    while ($row = mysqli_fetch_assoc($sel)) {
        $data[] = array(
            "common_id" => $field_name,
            "assign_name" => $row['name']
        );
    }
    return $data;
}

// Get Server Host and Request Url Link in php
$host_request_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// Get Server last accessed Url
$referrer_url = $_SERVER['HTTP_REFERER'];
?>
