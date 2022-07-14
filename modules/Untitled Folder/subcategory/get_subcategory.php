<?php

include_once '../../includes/database.php';



$query = "SELECT * FROM tbl_subcategory where cat_id='" . $_POST['id'] . "' and status='active' ORDER BY name ASC";
$result = mysqli_query($db, $query);
?>
<option value="">-- Select Sub Category --</option>
<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php
}
?>