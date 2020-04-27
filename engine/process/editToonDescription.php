<?php
	global $database;
	global $msgObj;
	global $error;
	
	$description = $_POST['description'];
	$toonID = $_POST['toonID'];
	
	$result = $database->db_query("UPDATE Toons SET description = '$description' WHERE toonID = $toonID");
	if(!$result) {
		$error->setError("Error: Could not update toon description!");
		header("Location: /admin/toon/$toonID");
		die();
	}
	
	$msgObj->setMsg("You updated a description");
	header("Location: /admin/toon/$toonID");
?>