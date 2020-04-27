<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['cname'];
	$gameID = $_POST['gameID'];
	
	//check for valid input	
	if($name == ""){
		$error->setError("You must give this cast member a name");
		header("Location: /admin/game/cast/add/$gameID");
		die();
	}
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name = '$name'");
	$num = mysqli_num_rows($result);
	if($num == 0) {
		$error->setError("The cast member, $name, does not exist as a member on the site");
		header("Location: /admin/game/cast/add/$gameID");
		die();
	}
	$row = mysqli_fetch_object($result);
	$userID = $row->userID;
	
	$result = $database->db_query("INSERT INTO Games_has_Cast(userID, gameID) VALUES($userID, $gameID)");
	if(!$result) {
		$error->setError("The cast member, $name, could not be added");
		header("Location: /admin/game/cast/add/$gameID");
		die();
	}
	
	$msgObj->setMsg("You added \"$name\" as a new cast member");
	header("Location: /admin/game/$gameID");
	die();
	
?>