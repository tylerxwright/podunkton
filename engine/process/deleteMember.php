<?php
	global $core;
	global $session;
	global $database;
	global $error;
	global $msgObj;
	
	$id = $core->args[2];
	
	$result = $database->db_query("DELETE FROM Bands_has_Members WHERE id=$id");
	if(!$result) {
		$error->setError("There was a snake in my boots!");
		header("Location: /admin/audio/band");
		die();
	}
	$result = $database->db_query("DELETE FROM Members_has_Instruments WHERE memberID=$id");
	if(!$result) {
		$error->setError("There was a snake in my boots!");
		header("Location: /admin/audio/band");
		die();
	}
	
	$msgObj->setMsg("You deleted a member");
	header("Location: /admin/audio/band");
	die();
?>