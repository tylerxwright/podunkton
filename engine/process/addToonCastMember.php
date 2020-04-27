<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['cname'];
	$toonID = $_POST['toonID'];
	
	//check for valid input	
	if($name == ""){
		$error->setError("You must give this cast member a name");
		header("Location: /admin/toon/cast/add/$toonID");
		die();
	}
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name = '$name'");
	$num = mysqli_num_rows($result);
	if($num == 0) {
		$error->setError("The cast member, $name, does not exist as a member on the site");
		header("Location: /admin/toon/cast/add/$toonID");
		die();
	}
	$row = mysqli_fetch_object($result);
	$userID = $row->userID;
	
	$result = $database->db_query("INSERT INTO Toons_has_Cast(userID, toonID) VALUES($userID, $toonID)");
	if(!$result) {
		$error->setError("The cast member, $name, could not be added");
		header("Location: /admin/toon/cast/add/$toonID");
		die();
	}
	
	$msgObj->setMsg("You added \"$name\" as a new cast member");
	header("Location: /admin/toon/$toonID");
	die();
	
?>