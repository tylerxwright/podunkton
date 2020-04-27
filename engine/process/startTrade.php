<?php
	global $session;
	global $database;
	global $error;
	global $sysmsg;
	global $podunkton;
	
	$purifier = new HTMLPurifier();
	
	$errorVal = 0;
	
	$user = $session->user;
	$tradeUsername = $purifier->purify($_POST['uname']);
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name='".$tradeUsername."'");
	$numRows = mysqli_num_rows($result);
	if($numRows == 0) {
		$errorVal = 1;
		$error->setError("User does not exist");
		header("Location: /trade");
	} else {
		$row = mysqli_fetch_object($result);
		$tradeUser = $row->userID;
	}
	
	if($user == $tradeUser) {
		$error->setError("You can't trade with yourself, thats dumb");
		header("Location: /trade");
		die();
	}
	
	if($errorVal == 0) {
		$result = $database->db_query("INSERT INTO Trades(leftUser, rightUser) VALUES($user, $tradeUser)");
		$tradeID = mysql_insert_id();
		
		$result = $database->db_query("INSERT INTO User_has_Trades(userID, tradeID, phase, viewed) VALUES($user, $tradeID, 1, 1)");
		$result = $database->db_query("INSERT INTO User_has_Trades(userID, tradeID, phase) VALUES($tradeUser, $tradeID, 0)");
		
		$sysmsg->send($user, "System: Trade Started", "You have started a trade with $tradeUsername");
		
		header("Location: /trade/$tradeID");
	}
?>