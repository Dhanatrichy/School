<?php
function get_particular_name($get_name, $get_id, $table_name, $table_id) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select $get_name from $table_name where $table_id = '".$get_id."'");
    $row = mysqli_fetch_assoc($sel);
    return $r_val = $row[$get_name];
}

function check_exist($get_val, $table_name, $label) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select $label from $table_name where $label = '".$get_val."'");
    if (mysqli_num_rows($sel) > 0) {
        return 1;
    }else{
        return "";
    }
}


//Get User Id by email
function get_user_session_id($email) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select id from adaa_users where email = '" . $email . "'");
    $row = mysqli_fetch_assoc($sel);
    $id = $row['id'];
    return $id;
}

//Check User login
function user_login_details($email, $password) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select * from adaa_users where email='" . $email . "'");
    while ($row = mysqli_fetch_assoc($sel)) {
        $usr_email = $row['email'];
        $usr_pass = $row['password'];
        if ($email == $usr_email && $password == $usr_pass) {
            return "1";
        } else {
            return "0";
        }
    }
}

//Check User Email
function check_user_login_email($email) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select email from adaa_users");
    while ($row = mysqli_fetch_assoc($sel)) {
        $users_email = $row['email'];
        if ($email == $users_email) {
            return '1';
        }
    }
}

//Check User Login Existance
function check_admin_user_existance($id) {
    $databse_call = new DB;
    $db = $databse_call->connect();
    $sel = $db->query("select * from tbl_users where user_id = '" . $id . "'");
    $row = mysqli_fetch_assoc($sel);
    $user_id = $row['user_id'];
    if ($id == $user_id) {
        return '1';
    } else {
        return '0';
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
    $var = htmlspecialchars(stripslashes($var));
    $var = str_ireplace("script", "blocked", $var);
    $var = mysql_escape_string($var);
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

// Get Server Host and Request Url Link in php
$host_request_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// Get Server last accessed Url
$referrer_url = $_SERVER['HTTP_REFERER'];
?>
