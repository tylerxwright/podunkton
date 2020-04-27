<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['cname'];
	$castID = $_POST['castID'];
	$gameID = $_POST['gameID'];
	
	//check for valid input	
	if($name == ""){
		$error->setError("You must give this cast member a name");
		header("Location: /admin/game/cast/edit/$gameID/$castID");
		die();
	}
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name = '$name'");
	$num = mysqli_num_rows($result);
	if($num == 0) {
		$error->setError("The cast member, $name, does not exist as a member on the site");
		header("Location: /admin/game/cast/edit/$gameID/$castID");
		die();
	}
	$row = mysqli_fetch_object($result);
	$userID = $row->userID;
	
	$result = $database->db_query("UPDATE Games_has_Cast SET userID = $userID WHERE id = $castID");
	if(!$result) {
		$error->setError("Error: Update of $name has failed. Its probably the LHC's fault.");
		header("Location: /admin/game/cast/edit/$gameID/$castID");
		die();
	}
	
	$msgObj->setMsg("You updated \"$name\" as a cast member");
	header("Location: /admin/game/$gameID");
	die();
	
?>