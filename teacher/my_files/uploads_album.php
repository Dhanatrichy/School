<?php include('include/database.php'); 
$vendor_id	=	$_SESSION['vendor_id'];
$album_name	=	$_POST['album_name'];
$time	 =	time();

$query= "insert into tbl_album_name(vendor_id,album_name)values('".$vendor_id."','".$album_name."')";
$run1	= mysql_query($query);
if(mysql_affected_rows()>0)
{
	$album_id	=	mysql_insert_id();
	foreach($_FILES['album_file']['name'] as $key => $tmp_name )
	{
		$desired_dir="user/album_images/";
		$document_name = $desired_dir.time().$_FILES['album_file']['name'][$key];
		
		$al_pic_name   = time().$_FILES['album_file']['name'][$key]; 
		$document_size =$_FILES['album_file']['size'][$key];
		$file_tmp =$_FILES['album_file']['tmp_name'][$key];
		$file_type=$_FILES['album_file']['type'][$key];	
		
		if($document_size)
		{
			$query="INSERT into tbl_album_images(album_id,vendor_id,al_pic_name) VALUES('".$album_id."','".$vendor_id."','".$al_pic_name."')";
			$query2 = mysql_query($query);
		}
		if(is_dir("$desired_dir/".$al_pic_name)==false)
		{
			move_uploaded_file($file_tmp,"$desired_dir/".$al_pic_name);
		}
	}
}
?>