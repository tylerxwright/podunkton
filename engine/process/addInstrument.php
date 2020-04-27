<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$name = $_POST['gname'];
	
	if($name == '') {
		$error->setError("You must give your instrument a name");
		header("Location: /admin/audio/instrument/add");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Instruments (name) VALUES ('$name')");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You added \"$name\" as a new instrument");
	}
	
	header("Location: /admin/audio/instrument");
	
?>