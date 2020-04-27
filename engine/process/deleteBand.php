<?php
	global $database;
	global $error;
	global $msgObj;
	global $core;
	
	$bandID = $core->args[2];
	
	$result = $database->db_query("SELECT name, picture FROM Bands WHERE bandID = $bandID");
	$row = mysqli_fetch_object($result);
	
	$result = $database->db_query("DELETE FROM Bands WHERE bandID = $bandID");
	if(!$result) {
		$error->setError("Error: Failed to delete the band ".$row->name);
		header("Location: /admin/audio/band/$bandID");
		die();
	} else {
		
		if(unlink("/content/audio/bandPicture/".$row->picture)) {
			$msgObj->setMsg("You delete the band ".$row->name);
			header("Location: /admin/audio/band");
			die();
		} else {
			$error->setError("Warning: Deleted ".$row->name." but the picture was not removed");
			header("Location: /admin/audio/band/$bandID");
			die();
		}
	}
	
?>