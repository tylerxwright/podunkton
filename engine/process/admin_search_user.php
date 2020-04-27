<?php
	global $database;
	global $error;
	
	$result = $database->db_query("SELECT userID as 'id' FROM Users WHERE name = '".$_POST['username']."'");
	
	$row = mysqli_fetch_object($result);
	$num_rows = mysqli_num_rows($result);
	
	if($num_rows){
		header('Location: /admin/user/' . $row->id);
	} else {
		$error->setError("User not found");
		header('Location: /admin/user');
	}
?>