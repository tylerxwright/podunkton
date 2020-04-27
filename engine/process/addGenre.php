<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$name = $_POST['gname'];
	$desc = $_POST['description'];
	
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
	
	$result = $database->db_query("INSERT INTO Genres (name, description) VALUES ('$name', '$desc')");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You added \"$name\" as a new genre");
	}
	
	header("Location: /admin/audio/genre");
	
?>