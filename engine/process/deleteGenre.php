<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$genreID = $core->args[2];
	
	$result = $database->db_query("SELECT name FROM Genres WHERE genreID = $genreID");
	$row = mysqli_fetch_object($result);
	$name = $row->name;
	
	$result = $database->db_query("DELETE FROM Genres WHERE genreID = $genreID");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You deleted the genre \"$name\"");
	}
	
	header("Location: /admin/audio/genre");
	
?>