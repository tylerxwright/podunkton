<?php
	global $core;
	global $session;
	global $database;
	global $error;
	global $msgObj;
	
	$bandID = $_POST['bandID'];
	$name = $_POST['mname'];
	$bhmID = $_POST['bhmID'];
	
	if($name == "") {
		$error->setError("You must give your member a name");
		header("Location: /admin/audio/band/member/edit/$bhmID");
		die();
	}
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name='$name'");
	$count = mysqli_num_rows($result);
	if($count == 0) {
		$error->setError("The username $name does not exist in the system");
		header("Location: /admin/audio/band/member/edit/$bhmID");
		die();
	}
	$row = mysqli_fetch_object($result);
	$userID = $row->userID;
	
	$result = $database->db_query("UPDATE Bands_has_Members SET userID = $userID, bandID = $bandID WHERE id = $bhmID");
	
	if(!$result) {
		$error->setError("There was a snake in my boots!");
		header("Location: /admin/audio/band/member/edit/$bhmID");
		die();
	}
	
	$result = $database->db_query("DELETE FROM Members_has_Instruments WHERE memberID = $bhmID");
	if(!$result) {
		$error->setError("There was a snake in my boots!");
		header("Location: /admin/audio/band/member/edit/$bhmID");
		die();
	}
	
	$c = 1;
	while($iId = $_POST['instrument'.$c]) {
		$result = $database->db_query("INSERT INTO Members_has_Instruments(memberID, instrumentID) VALUES($bhmID, $iId)");
		if(!$result) {
			$error->setError("There was a snake in my boots!");
			header("Location: /admin/audio/band/member/edit/$bhmID");
			die();
		}
		$c++;
	}
	
	$msgObj->setMsg("You updated the member $name");
	header("Location: /admin/audio/band/$bandID");
	die();
?>