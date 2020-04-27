<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$instrumentID = $core->args[2];
	
	$result = $database->db_query("SELECT name FROM Instruments WHERE instrumentID = $instrumentID");
	$row = mysqli_fetch_object($result);
	$name = $row->name;
	
	$result = $database->db_query("DELETE FROM Instruments WHERE instrumentID = $instrumentID");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You deleted the instrument \"$name\"");
	}
	
	header("Location: /admin/audio/instrument");
	
?>