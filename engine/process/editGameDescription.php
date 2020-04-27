<?php
	global $database;
	global $msgObj;
	global $error;
	
	$description = $_POST['description'];
	$gameID = $_POST['gameID'];
	
	$result = $database->db_query("UPDATE Games SET description = '$description' WHERE gameID = $gameID");
	if(!$result) {
		$error->setError("Error: Could not update game description!");
		header("Location: /admin/game/$gameID");
		die();
	}
	
	$msgObj->setMsg("You updated a description");
	header("Location: /admin/game/$gameID");
?>