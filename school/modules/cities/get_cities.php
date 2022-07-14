<?php

include_once '../../includes/database.php';

$query = "SELECT * FROM tbl_city where sid='" . $_POST['id'] . "' ORDER BY name ASC";
$result = mysqli_query($db, $query);
?>
<option value="">-- Select City --</option>
<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php
}
?>