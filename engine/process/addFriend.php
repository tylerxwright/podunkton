<?php
	global $database;
	global $session;
	global $core;
	global $sysmsg;
	
	$userID = $session->user;
	
	$friendID = $core->args[2];
	
	if(!$userID OR !$friendID) {
		echo 0;
		die();
	}
	
	$result = $database->db_query("INSERT INTO Users_has_Friends(userID, friendID) VALUES($userID, $friendID)");
	$id = mysql_insert_id();
	$result2 = $database->db_query("INSERT INTO Users_has_Friends(userID, friendID) VALUES($friendID, $userID)");
	$id2 = mysql_insert_id();
	if(!$result or !$result2){
		echo 0;
		die();
	} else {
		$sysmsg->send($friendID, "Friend Request", "<a class='blue' href='/user/".$session->username."'>".$session->username."</a> would like to be your friend!<br/><br/><a class='blue' href='/process/confirmFriend/$id/$id2'>Confrim</a> or <a class='blue' href='/process/denyFriend/$id/$id2'>Deny</a>");
		echo 1;
		die();
	}
	
?>