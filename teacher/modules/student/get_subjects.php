<?php

include_once '../../includes/database.php';

$query = "SELECT * FROM tbl_student where id='" . $_POST['student_id'] . "'";
$result = mysqli_query($db, $query);
if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    $subjects   =   $row['subjects'];
}

$subject_decode =   json_decode($row['subjects']);
?>
<option value="">-- Select Subject --</option>
<?php
foreach($subject_decode as $subjects){
    ?>
    <option value="<?php echo $subjects; ?>"><?php echo get_particular_name('name', $subjects, 'tbl_subject', 'id'); ?></option>
    <?php
}
?>