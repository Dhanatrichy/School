<?php

include_once '../../includes/database.php';

$query = "SELECT * FROM tbl_student where school_id='" . $_POST['school_id'] . "' and class_id='" . $_POST['class_id'] . "' and section_id='" . $_POST['section_id'] . "' ORDER BY name ASC";
$result = mysqli_query($db, $query);
?>
<option value="">-- Select Student --</option>
<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php
}
?>