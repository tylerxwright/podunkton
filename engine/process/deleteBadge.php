<?php
	global $database;
	global $session;
	global $core;
	global $error;
	global $msgObj;
	
	$badgeID = $core->args[2];
	
	if(!$session->user){
		die();
	}
	
	// Get Badge
	$result = $database->db_query("SELECT name, icon FROM Badges WHERE badgeID = $badgeID");
	if(!$result){
		$error->setError("Error: Badge does not exist in the system");
		header("Location: /admin/badges");
		die();
	}
	$row = mysqli_fetch_object($result);
	
	// Delete Users_has_Badges link
	$result = $database->db_query("DELETE FROM Users_has_Badges WHERE badgeID = $badgeID");
	if(!$result){
		$error->setError("Error: Failed to delete the Users_has_Badges link");
		header("Location: /admin/badges");
		die();
	}
	
	// Delete the badge
	$result = $database->db_query("DELETE FROM Badges WHERE badgeID = $badgeID");
	if(!$result){
		$error->setError("Error: Failed to delete the Badge...Sorry, sheesh!");
		header("Location: /admin/badges");
		die();
	}
	
	if(unlink("/content/badges/".$row->icon)) {
		$msgObj->setMsg("You delete the badge ".$row->name);
		header("Location: /admin/badges");
		die();
	} else {
		$error->setError("Warning: Deleted the badge ".$row->name." but the icon(".$row->icon.") was not removed");
		header("Location: /admin/badges");
		die();
	}

?>
