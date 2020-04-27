<?php
	global $database;
	global $error;
	global $core;
	global $msgObj;
	
	$toonID = $core->args[2];
	$castID = $core->args[3];
	
	$result = $database->db_query("DELETE FROM Toons_has_Cast WHERE id = $castID");
	if(!$result) {
		$error->setError("Error: Cast member could not be deleted!");
		header("Location: /admin/toon/$toonID");
		die();
	} else {
		$msgObj->setMsg("You deleted a cast member");
		header("Location: /admin/toon/$toonID");
		die();
	}
	
?>