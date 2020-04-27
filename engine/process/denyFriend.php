<?php
	global $database;
	global $session;
	global $core;
	global $msgObj;
	global $error;
	global $sysmsg;
	
	$id1 = $core->args[2];
	$id2 = $core->args[3];
	$userID = $session->user;
	
	$result = $database->db_query("SELECT uhf.userID, u.name FROM Users_has_Friends as uhf JOIN Users as u ON uhf.friendID = u.userID WHERE uhf.id=$id2");
	$row = mysqli_fetch_object($result);
	
	if($row->userID != $userID){
		$error->setError("Error: This is not yours to deny");
		header("Location: /user/".$session->username);
		die();
	}
	
	$result = $database->db_query("DELETE FROM Users_has_Friends WHERE id=$id1 OR id=$id2");
	if(!$result) {
		$error->setError("Error: Deny failed");
		header("Location: /user/".$session->username);
		die();
	}
	
	$msgObj->setMsg("You have denied friendship with ".$row->name);
	header("Location: /user/".$session->username);
	die();
	
?>