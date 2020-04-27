<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$name = $_POST['gname'];
	
	if($name == '') {
		$error->setError("You must give your genre a name");
		header("Location: /admin/audio/recordlabel/add");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Record_Labels (name) VALUES ('$name')");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You added \"$name\" as a new record label");
	}
	
	header("Location: /admin/audio/recordlabel");
	
?>