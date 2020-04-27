<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$name = $_POST['gname'];
	$instrumentID = $_POST['instrumentID'];
	
	if($name == '') {
		$error->setError("You must give your instrument a name");
		header("Location: /admin/audio/instrument/add");
		die();
	}
	
	$result = $database->db_query("UPDATE Instruments SET name='$name' WHERE instrumentID=$instrumentID");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You updated the instrument \"$name\"");
	}
	
	header("Location: /admin/audio/instrument");
	
?>