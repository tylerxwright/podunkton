<?php
	global $database;
	global $session;
	global $core;
	global $msgObj;
	global $error;
	global $sysmsg;
	global $podunkton;
	
	$id1 = $core->args[2];
	$id2 = $core->args[3];
	$userID = $session->user;
	
	$result = $database->db_query("SELECT uhf.userID, u.name FROM Users_has_Friends as uhf JOIN Users as u ON uhf.friendID = u.userID WHERE uhf.id=$id2");
	$row = mysqli_fetch_object($result);
	
	$msg = "became friends with <a class='blue' href='".$row->name."'>".$row->name."</a>";
	$this->recentActivity($session->user, "newFriend", $msg);
	
	$msg = "became friends with <a class='blue' href='".$session->username."'>".$session->username."</a>";
	$this->recentActivity($id2, "newFriend", $msg);
	
	if($row->userID != $userID){
		$error->setError("Error: This is not yours to confirm");
		header("Location: /user/".$session->username);
		die();
	}
	
	$result = $database->db_query("UPDATE Users_has_Friends SET confirmed=1, friendSince=NOW() WHERE id=$id1 OR id=$id2");
	if(!$result) {
		$error->setError("Error: Confirmation failed");
		header("Location: /user/".$session->username);
		die();
	}
	
	$msgObj->setMsg("You and ".$row->name." are now friends!");
	header("Location: /user/".$session->username);
	die();
	
?>