<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$name = $_POST['gname'];
	$desc = $_POST['description'];
	$genreID = $_POST['genreID'];
	
	if($name == '') {
		$error->setError("You must give your genre a name");
		header("Location: /admin/audio/genre/add");
		die();
	}
	
	if($desc == '') {
		$error->setError("You must have a description");
		header("Location: /admin/audio/genre/add");
		die();
	}
	
	$result = $database->db_query("UPDATE Genres SET name='$name', description='$desc' WHERE genreID=$genreID");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You updated the genre \"$name\"");
	}
	
	header("Location: /admin/audio/genre");
	
?>