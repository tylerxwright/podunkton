<?php
	global $database;
	global $error;
	global $msgObj;
	global $core;
	
	$gameID = $core->args[2];
	$triviaID = $core->args[3];
	
	$result = $database->db_query("DELETE FROM Games_Trivia WHERE triviaID = $triviaID");
	if(!$result) {
		$error->setError("Error: Delete of trivia item failed");
		header("Location: /admin/tgame/$gameID");
		die();
	}

	$msgObj->setMsg("You deleted a trivia item");
	header("Location: /admin/game/$gameID");
	die();
	
?>