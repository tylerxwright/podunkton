<?php
	global $database;
	global $core;
	global $error;
	global $msgObj;
	
	$toonID = $core->args[2];
	
	$result = $database->db_query("SELECT * FROM Toons WHERE toonID = $toonID");
	$row = mysqli_fetch_object($result);
	
	$result = $database->db_query("DELETE FROM Toons WHERE toonID = $toonID");
	if(!$result) {
		$error->setError("Error: Toon Delete Failed!");
		header("Location: /admin/toon");
		die();
	}
	
	$result = $database->db_query("DELETE FROM Toons_Trivia WHERE toonID = $toonID");
	if(!$result) {
		$error->setError("Error: Toons_Trivia Delete Failed!");
		header("Location: /admin/toon");
		die();
	}
	
	$result = $database->db_query("DELETE FROM Toons_has_Cast WHERE toonID = $toonID");
	if(!$result) {
		$error->setError("Error: Toons Cast Delete Failed!");
		header("Location: /admin/toon");
		die();
	}
	
	if(!unlink("content/toons/swfs/".$row->swf)) {
		$error->setError("Error: SWF file could not be deleted.");
		header("Location: /admin/toon");
		die();
	}
	
	if(!unlink("content/toons/images/".$row->icon)) {
		$error->setError("Error: Toon icon could not be deleted.");
		header("Location: /admin/toon");
		die();
	}
	
	$msgObj->setMsg("You deleted a toon");
	header("Location: /admin/toon/$toonID");
	die();
	
?>