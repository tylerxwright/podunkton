<?php
	global $database;
	global $session;
	global $core;
	
	if(!$session->user) {
		echo 0;
		die();
	}
	
	$friendID = $core->args[2];
	$userID = $session->user;
	
	$result = $database->db_query("DELETE FROM Users_has_Friends WHERE userID = $userID AND friendID = $friendID");
	if(!$result) {
		echo 0;
		die();
	}
	
	$result = $database->db_query("DELETE FROM Users_has_Friends WHERE userID = $friendID AND friendID = $userID");
	if(!$result) {
		echo 0;
		die();
	}
	
	$result = $database->db_query("SELECT name FROM Users WHERE userID = $friendID");
	if(!$result) {
		echo 0;
		die();
	}
	$row = mysqli_fetch_object($result);
	
	echo $row->name;
	die();
	
?>