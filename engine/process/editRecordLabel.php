<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$name = $_POST['gname'];
	$labelID = $_POST['labelID'];
	
	if($name == '') {
		$error->setError("You must give your record label a name");
		header("Location: /admin/audio/recordlabel/add");
		die();
	}
	
	$result = $database->db_query("UPDATE Record_Labels SET name='$name' WHERE labelID=$labelID");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You updated the record label \"$name\"");
	}
	
	header("Location: /admin/audio/recordlabel");
	
?>