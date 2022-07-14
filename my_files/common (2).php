<?php

function getSelectName($sel_id) {
    $sql = "select sel_name from tbl_select where sel_id='" . $sel_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return stripslashes($row['sel_name']);
        return stripslashes($row['sel_id']);
    }
    return "";
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

function getIndustryName($id) {
    $sql = "select ind_name from tbl_industry where ind_id ='" . $id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['ind_name']);
    }
    return "";
}

function getremark($table, $col_name, $col_id, $id) {
    $res = mysql_query("select $col_name from $table where $col_id='" . $id . "'");
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['$col_name'];
    }
    return "";
}

function getCountryName($cid) {
    $sql = "select name from countries where id ='" . $cid . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['name']);
    }
    return "";
}

function getStateName($sid) {
    $sql = "select name from states where id ='" . $sid . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['name']);
    }
    return "";
}

function getCityName($ctid) {
    $sql = "select name from cities where id ='" . $ctid . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['name']);
    }
    return "";
}

function getEntity($en_id) {
    $sql = "select en_name from tbl_entity where en_id ='" . $en_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['en_name']);
    }
    return "";
}

function getEntityValue($ev_id) {
    $sql = "select ev_name from tbl_entityvalue where ev_id ='" . $ev_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['ev_name']);
    }
    return "";
}

function getDescription($de_id) {
    $sql = "select de_name from tbl_description where de_id ='" . $de_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['de_name']);
    }
    return "";
}

function getStatus($s_id) {
    $sql = "select s_name from tbl_status where s_id ='" . $s_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['s_name']);
    }
    return "";
}

function getModuleVarValue($module, $var) {
    $sql = "select * from tbl_module_vars where module_name='" . $module . "' and variable_name='" . $var . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return stripslashes($row['variable_text']);
    }
}

function email_records($id, $to, $subject, $msg, $email_time, $ip_add) {
    $to = addslashes(addslashes($to));
    $query = "insert into tbl_email_records(user_id,email,temp_sub,temp_body,email_time,ip_address) values ('" . $id . "','" . $to . "','" . $subject . "','" . $msg . "','" . $email_time . "','" . $ip_add . "')";
    $rest = mysql_query($query);
    if ($rest) {
        return true;
    }
    return false;
}

function email_content_subject($id, $subject) {
    $sql = "select * from tbl_users where user_id = '" . $id . "'";
    $userresult = mysql_query($sql);
    while ($dr = mysql_fetch_assoc($userresult)) {
        $abn = $dr['abn'];
        $company = $dr['company'];
        $contact_person = $dr['contact_person'];
        $license = $dr['license'];
        $phone = $dr['phone'];
        $email = $dr['email'];
        $user_type = $dr['user_type'];
        $agreement = $dr['agreement'];
        $agreement_type = $dr['agreement_type'];
        $import_type = $dr['import_type'];
        $import_quantity = $dr['import_quantity'];
    }
    $subject = html_entity_decode(str_replace("{abn}", $abn, $subject));
    $subject = html_entity_decode(str_replace("{abn_no}", $abn, $subject));
    $subject = html_entity_decode(str_replace("{company}", $company, $subject));
    $subject = html_entity_decode(str_replace("{company_name}", $company, $subject));
    $subject = html_entity_decode(str_replace("{companyname}", $company, $subject));
    $subject = html_entity_decode(str_replace("{Company}", $company, $subject));
    $subject = html_entity_decode(str_replace("{comp}", $company, $subject));
    $subject = html_entity_decode(str_replace("{comp_name}", $company, $subject));
    $subject = html_entity_decode(str_replace("{contact_person}", $contact_person, $subject));
    $subject = html_entity_decode(str_replace("{contactperson}", $contact_person, $subject));
    $subject = html_entity_decode(str_replace("{cont_person}", $contact_person, $subject));
    $subject = html_entity_decode(str_replace("{phone}", $phone, $subject));
    $subject = html_entity_decode(str_replace("{tele_no}", $phone, $subject));
    $subject = html_entity_decode(str_replace("{email_id}", $email, $subject));
    $subject = html_entity_decode(str_replace("{email}", $email, $subject));
    $subject = html_entity_decode(str_replace("{user_type}", $user_type, $subject));
    $subject = html_entity_decode(str_replace("{agreement}", $agreement, $subject));
    $subject = html_entity_decode(str_replace("{status}", $agreement, $subject));
    $subject = html_entity_decode(str_replace("{agreement_type}", $agreement_type, $subject));
    $subject = html_entity_decode(str_replace("{import_type}", $import_type, $subject));
    $subject = html_entity_decode(str_replace("{importdetails}", $import_type, $subject));
    $subject = html_entity_decode(str_replace("{import_quantity}", $import_quantity, $subject));
    return $subject;
}

function email_content_change($id, $msg) {
    $sql = "select * from tbl_users where user_id = '" . $id . "'";
    $userresult = mysql_query($sql);
    while ($dr = mysql_fetch_assoc($userresult)) {
        $abn = $dr['abn'];
        $company = $dr['company'];
        $contact_person = $dr['contact_person'];
        $license = $dr['license'];
        $phone = $dr['phone'];
        $email = $dr['email'];
        $user_type = $dr['user_type'];
        $agreement = $dr['agreement'];
        $agreement_type = $dr['agreement_type'];
        $import_type = $dr['import_type'];
        $import_quantity = $dr['import_quantity'];
    }
    $msg = html_entity_decode(str_replace("{abn}", $abn, $msg));
    $msg = html_entity_decode(str_replace("{abn_no}", $abn, $msg));
    $msg = html_entity_decode(str_replace("{company}", $company, $msg));
    $msg = html_entity_decode(str_replace("{company_name}", $company, $msg));
    $msg = html_entity_decode(str_replace("{companyname}", $company, $msg));
    $msg = html_entity_decode(str_replace("{Company}", $company, $msg));
    $msg = html_entity_decode(str_replace("{comp}", $company, $msg));
    $msg = html_entity_decode(str_replace("{comp_name}", $company, $msg));
    $msg = html_entity_decode(str_replace("{contact_person}", $contact_person, $msg));
    $msg = html_entity_decode(str_replace("{contactperson}", $contact_person, $msg));
    $msg = html_entity_decode(str_replace("{cont_person}", $contact_person, $msg));
    $msg = html_entity_decode(str_replace("{phone}", $phone, $msg));
    $msg = html_entity_decode(str_replace("{tele_no}", $phone, $msg));
    $msg = html_entity_decode(str_replace("{email}", $email, $msg));
    $msg = html_entity_decode(str_replace("{email_id}", $email, $msg));
    $msg = html_entity_decode(str_replace("{user_type}", $user_type, $msg));
    $msg = html_entity_decode(str_replace("{agreement}", $agreement, $msg));
    $msg = html_entity_decode(str_replace("{status}", $agreement, $msg));
    $msg = html_entity_decode(str_replace("{agreement_type}", $agreement_type, $msg));
    $msg = html_entity_decode(str_replace("{import_type}", $import_type, $msg));
    $msg = html_entity_decode(str_replace("{importdetails}", $import_type, $msg));
    $msg = html_entity_decode(str_replace("{import_quantity}", $import_quantity, $msg));
    return $msg;
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

function getPaymentStatus($type) {
    $sql = "select sum(totalprice) as total from tbl_orders o inner join tbl_users u on o.user_id=u.user_id";
    //$sql	=	"select sum(totalprice) as total from tbl_orders ";
    if ($type == "Complete") {
        $sql .= " where payment_status='Completed'";
    }
    if ($type == "Cancelled") {
        $sql .= " where payment_status='Cancelled'";
    }
    if ($type == "Awaiting Payment") {
        $sql .= " where payment_status='Awaiting Payment'";
    }
    if ($type == "Incomplete") {
        $sql .= " where payment_status='Pending'";
    }
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        $total = $row['total'];
        if ($total > 0)
            return number_format($total, 2);
        //return number_format("0", 2);	
    }
}

function getTicketsStatus($type) {
    $sql = "select count(*) as total from tbl_tickets ";
    if ($type == "Closed") {
        $sql .= " where status='Closed'";
    } else if ($type == "Open") {
        $sql .= " where status<>'Closed'";
    }
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['total'];
    } else
        return 0;
}

function getAdminactivity($type) {
    $sql = "select count(*) as total from tbl_activity where user_type = 'Admin'";

    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['total'];
    } else
        return 0;
}

function getClientactivity($type) {
    $sql = "select count(*) as total from tbl_activity where user_type = 'Registered'";

    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['total'];
    } else
        return 0;
}

function getBrandName($rem_id) {
    $sql = "select br_name from tbl_brand where br_id ='" . $rem_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['br_name']);
    }
    return "";
}

function getColorName($class_id, $section_id, $stu_rollno) {
    $fetch = "select * from student_remarks where class_id = '" . $class_id . "' and section_id = '" . $section_id . "' and stu_rollno = '" . $stu_rollno . "' ";
    $run = mysql_query($fetch);
    if (mysql_num_rows($run) > 0) {
        $col = "#FF0000";
        return $col;
    }
    return "";
}

function getTerm($term_id) {
    $sql = "select term_name from tbl_term where term_id ='" . $term_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['term_name']);
    }
    return "";
}

function getTestName($temp_id) {
    $sql = "select addfa from tbl_unit_test where unit_id ='" . $temp_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['addfa']);
    }
    return "";
}

function getTempName($temp_id) {
    $sql = "select temp_subject from tbl_templates where temp_id ='" . $temp_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['temp_subject']);
    }
    return "";
}

function getXamName($exam_id) {
    $sql = "select exam_title from tbl_exam where exam_id ='" . $exam_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['exam_title']);
    }
    return "";
}

function getClassName($class_id) {
    $sql = "select class_name from tbl_class where class_id ='" . $class_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['class_name']);
    }
    return "";
}

function getTeachName($teach_id) {
    $sql = "select teach_name from tbl_tech where teach_id ='" . $teach_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['teach_name']);
    }
    return "";
}

function getSectionName($section_id) {
    $sql = "select class_section from tbl_section where section_id ='" . $section_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['class_section']);
    }
    return "";
}

function getStuName($stu_roll, $class_id, $section_id) {
    $sql = "select stu_name from tbl_student where stu_rollno ='" . $stu_roll . "' and class_id = '" . $class_id . "' and section_id = '" . $section_id . "'";
    //die();
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['stu_name']);
    }
    return "";
}

function getBlank() {
    $message = "";
    $srllno = "";
    $sname = "";
    $sphone = "";
    $mobileNumber = "";
    $mess = "";
    $stu_name = '';
    $stu_address = '';
    $stu_m_name = '';
    $stu_f_name = '';
    $stu_phone = '';
    $stu_alt_phone = '';
    $stu_email = '';
    $mother_tongue = "";
    $stu_f_quali = "";
    $stu_f_name = "";
    $stu_m_quali = "";
    $stu_m_name = "";
    $stu_address = "";
    $religion = "";
    $nationality = "";
    $datepicker = "";
}

function getStuPhone($stu_roll, $class_id, $section_id) {
    $sql = "select stu_phone from tbl_student where stu_rollno ='" . $stu_roll . "' and class_id = '" . $class_id . "' and section_id = '" . $section_id . "'";
    //die();
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['stu_phone']);
    }
    return "";
}

function getEmailId($stu_roll, $class_id, $section_id) {
    $sql = "select stu_email from tbl_student where stu_rollno ='" . $stu_roll . "' and class_id = '" . $class_id . "' and section_id = '" . $section_id . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['stu_email']);
    }
    return "";
}

function getSubject($subject_id) {
    $sql = "select sub_title from tbl_subject where sub_id ='" . $subject_id . "'";
    //die();
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['sub_title']);
    }
    return "";
}

function getSName($stu_roll) {
    $sql = "select stu_name from tbl_student where stu_id ='" . $stu_roll . "'";
    //die();
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['stu_name']);
    }
    return "";
}

function getAName($stu_roll) {
    $sql = "select name from tbl_users where user_id ='" . $stu_roll . "'";
    //die();
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['name']);
    }
    return "";
}

//function getUserType($stu_id)
//{
//	 $sql	=	"select stu_name from tbl_student where stu_id ='". $stu_id ."'";
//	//die();
//	$res	=	mysql_query($sql);
//	if(mysql_num_rows($res) > 0)
//	{
//		$row	=	mysql_fetch_assoc($res);
//		return html_entity_decode($row['stu_name']);
//	}
//	return "";
//}
function getTempSubject($temp_code) {
    $sql = "select temp_subject from tbl_templates where temp_id ='" . $temp_code . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['temp_subject']);
    }
    return "";
}

function getTemplateSubject($temp_code) {
    $sql = "select temp_subject from tbl_templates where temp_code ='" . $temp_code . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return html_entity_decode($row['temp_subject']);
    }
    return "";
}

function getTemplateBody($temp_code) {
    $sql = "select temp_body from tbl_templates where temp_code ='" . $temp_code . "' or temp_id = '" . $temp_code . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['temp_body'];
    }
    return "";
}

function getUserName($user_id) {
    $res = mysql_query("select username from tbl_users where user_id='" . $user_id . "'");
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['username'];
    }
    return "";
}

function getUserPhone($user_id) {
    $res = mysql_query("select phone from tbl_users where user_id='" . $user_id . "'");
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['phone'];
    }
    return "";
}

function getUserCompany($user_id) {
    $res = mysql_query("select company from tbl_users where user_id='" . $user_id . "'");
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['company'];
    }
    return "";
}

function getUserABN($user_id) {
    $res = mysql_query("select abn from tbl_users where user_id='" . $user_id . "'");
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['abn'];
    }
    return "";
}

function getUserEmail($user_id) {
    $res = mysql_query("select email from tbl_users where user_id='" . $user_id . "'");
    if (mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['email'];
    }
    return "";
}

function deleteModuleVars($module) {
    $sql = "select * from tbl_module_vars where module_name='" . $module . "'";
    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $sql = "delete from tbl_module_vars where module_name='" . $module . "'";
        $res = mysql_query($sql);
        if (mysql_affected_rows() > 0) {
            return true;
        }
        return false;
    } else
        return true;
}

function insertModuleVars($module, $vars, $values) {

    foreach ($vars as $key => $field) {
        mysql_query("insert into tbl_module_vars set module_name ='" . $module . "', variable_name='" . $field . "', variable_text='" . secureSuperGlobal($values[$field]) . "'");
    }
    return true;
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

function check_username($suggest) {
    $sql = "select * from tbl_users where username = '" . $suggest . "'";
    $res = mysql_query($sql) or die("Mysql Fetch Error: " . mysql_error());
    if (mysql_num_rows($res) > 0) {
        return true;
    }
    return false;
}

function check_email($suggest) {
    $sql = "select * from tbl_users where email = '" . $suggest . "'";
    $res = mysql_query($sql) or die("Mysql Fetch Error: " . mysql_error());
    if (mysql_num_rows($res) > 0) {
        return true;
    }
    return false;
}

function check_emailabnid($suggest, $abn, $user_id) {
    $sql = "select * from tbl_users where (email = '" . $suggest . "'or abn ='" . $abn . "') and (user_id !='" . $user_id . "')";
    $res = mysql_query($sql) or die("Mysql Fetch Error: " . mysql_error());
    if (mysql_num_rows($res) > 0) {
        return true;
    }
    return false;
}

function insert($tbl, $fields, $static_fields, $data, $where) {
    foreach ($fields as $key => $field) {
        $bits[] = "`$field` = '" . secureSuperGlobal($data[$field]) . "'";
    }
    $setStr = implode(",", $bits);
    $query = "insert into $tbl set " . $setStr . $static_fields;
    $sqlRs = mysql_query($query) or die("Mysql insertion error : " . mysql_error());
    return mysql_insert_id();
}

function update($tbl, $fields, $static_fields, $data, $where) {

    foreach ($fields as $key => $field) {
        $bits[] = "`$field` = '" . secureSuperGlobal($data[$field]) . "'";
    }
    $setStr = implode(",", $bits);
    $query = "update $tbl set $setStr $static_fields where $where";
    $sqlRs = mysql_query($query) or die("Mysql updation error : " . mysql_error());
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

function reminderEmail_b15day() {
    $sql = "select * from tbl_schedule";
    $res = mysql_query($sql) or die("Mysql Fetch Error: " . mysql_error());
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $emailid = $row['userid'];
            $template = $row['template'];
            if ($emailid == 9000) {

                //echo $emailid;
                //Send Email to all users
                /* SELECT TEMPLATE */
                $sql_temp = "select * from tbl_templates where temp_id=" . $template;
                $restmp = mysql_query($sql_temp) or die("Mysql Fetch Error: " . mysql_error());
                if (mysql_num_rows($restmp) > 0) {
                    $etemp = mysql_fetch_assoc($restmp);
                    $esubject = $etemp['temp_subject'];
                    $emsg = $etemp['temp_body'];
                }
                /* END SELECT TEMPLATE */
                $sql2 = "select * from tbl_users where agreement='Approved' and status=1 and user_type='Registered' order by user_id asc";
                $res2 = mysql_query($sql2) or die("Mysql Fetch Error: " . mysql_error());
                if (mysql_num_rows($res2) > 0) {
                    while ($row2 = mysql_fetch_assoc($res2)) {
                        $eto = $row2['email'];
                        $emailheaders = '';
                        //echo $eto.'<br />';
                        sendmail($eto, $esubject, $emsg, $emailheaders);
                        /* Uncomment this line for cron job. */
                    }
                }
                //E-mail End
            }
        }
    }
    //return false;
}

function reminderEmail_b4day() {
    $sql = "select * from tbl_schedule";
    $res = mysql_query($sql) or die("Mysql Fetch Error: " . mysql_error());
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $emailid = $row['userid'];
            $template = $row['template'];
            if ($emailid == 9001) {

                //echo $emailid;
                //Send Email to all users
                /* SELECT TEMPLATE */
                $sql_temp = "select * from tbl_templates where temp_id=" . $template;
                $restmp = mysql_query($sql_temp) or die("Mysql Fetch Error: " . mysql_error());
                if (mysql_num_rows($restmp) > 0) {
                    $etemp = mysql_fetch_assoc($restmp);
                    $esubject = $etemp['temp_subject'];
                    $emsg = $etemp['temp_body'];
                }
                /* END SELECT TEMPLATE */
                $sql2 = "select * from tbl_users where agreement='Approved' and status=1 and user_type='Registered' order by user_id asc";
                $res2 = mysql_query($sql2) or die("Mysql Fetch Error: " . mysql_error());
                if (mysql_num_rows($res2) > 0) {
                    while ($row2 = mysql_fetch_assoc($res2)) {
                        $eto = $row2['email'];
                        $emailheaders = '';
                        //echo $eto.'<br />';
                        sendmail($eto, $esubject, $emsg, $emailheaders);
                        /* Uncomment this line for cron job. */
                    }
                }
                //E-mail End
            }
        }
    }
    //return false;
}

function reminderEmail_a2day() {
    $sql = "select * from tbl_schedule";
    $res = mysql_query($sql) or die("Mysql Fetch Error: " . mysql_error());
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            $emailid = $row['userid'];
            $template = $row['template'];
            if ($emailid == 9002) {

                //echo $emailid;
                //Send Email to all users
                /* SELECT TEMPLATE */
                $sql_temp = "select * from tbl_templates where temp_id=" . $template;
                $restmp = mysql_query($sql_temp) or die("Mysql Fetch Error: " . mysql_error());
                if (mysql_num_rows($restmp) > 0) {
                    $etemp = mysql_fetch_assoc($restmp);
                    $esubject = $etemp['temp_subject'];
                    $emsg = $etemp['temp_body'];
                }
                /* END SELECT TEMPLATE */
                $sql2 = "select * from tbl_users where agreement='Approved' and status=1 and user_type='Registered' order by user_id asc";
                $res2 = mysql_query($sql2) or die("Mysql Fetch Error: " . mysql_error());
                if (mysql_num_rows($res2) > 0) {
                    while ($row2 = mysql_fetch_assoc($res2)) {
                        $eto = $row2['email'];
                        $emailheaders = '';
                        //echo $eto.'<br />';
                        sendmail($eto, $esubject, $emsg, $emailheaders);
                        /* Uncomment this line for cron job. */
                    }
                }
                //E-mail End
            }
        }
    }
    //return false;
}

?>
