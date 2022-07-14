<?php
include_once '../../includes/database.php';

$subjects       =   get_particular_name('subjects', $_POST['id'], 'tbl_teacher', 'id');
if($subjects){
    $ex_subjects    =   json_decode($subjects);

    foreach($ex_subjects as $subjects){
        $subject_names  .=   get_particular_name('name', $subjects, 'tbl_subject', 'id').', ';
    }
    echo $subject_names  =   "<b>Teacher Subjects -</b> ".trim($subject_names,', ');
}
?>