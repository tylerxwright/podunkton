<?php
	global $database;
	global $error;
	global $core;
	global $session;
	global $msgObj;
	
	$labelID = $core->args[2];
	
	$result = $database->db_query("SELECT name FROM Record_Labels WHERE labelID = $labelID");
	$row = mysqli_fetch_object($result);
	$name = $row->name;
	
	$result = $database->db_query("DELETE FROM Record_Labels WHERE labelID = $labelID");
	
	if (!$result){
		$error->setError("There was a snake in my boot!");
	} else {
		$msgObj->setMsg("You deleted the record label \"$name\"");
	}
	
	header("Location: /admin/audio/recordlabel");
	
?>