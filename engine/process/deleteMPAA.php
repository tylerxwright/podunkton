<?php
	global $database;
	global $core;
	global $error;
	global $msgObj;
	
	$mpaaID = $core->args[2];
	
	$result = $database->db_query("SELECT icon FROM MPAA_Ratings WHERE mpaaID = $mpaaID");
	$row = mysqli_fetch_object($result);
	
	$result = $database->db_query("DELETE FROM MPAA_Ratings WHERE mpaaID = $mpaaID");
	if(!$result) {
		$error->setError("Error: MPAA Delete failed!");
		header("Location: /admin/toon/mpaa");
		die();
	}
	
	if(!unlink("content/mpaa/".$row->icon)) {
		$error->setError("Error: MPAA icon could not be deleted.");
		header("Location: /admin/toon/mpaa");
		die();
	}
	
	$msgObj->setMsg("You deleted an MPAA Rating");
	header("Location: /admin/toon/mpaa");
	die();
	
?>