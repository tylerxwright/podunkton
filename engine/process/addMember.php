<?php
	global $core;
	global $session;
	global $database;
	global $error;
	global $msgObj;
	
	$bandID = $_POST['bandID'];
	$name = $_POST['mname'];
	
	if($name == "") {
		$error->setError("You must give your member a name");
		header("Location: /admin/audio/band/member/add/$bandID");
		die();
	}
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name='$name'");
	$count = mysqli_num_rows($result);
	if($count == 0) {
		$error->setError("The username $name does not exist in the system");
		header("Location: /admin/audio/band/member/add/$bandID");
		die();
	}
	$row = mysqli_fetch_object($result);
	$userID = $row->userID;
	
	$result = $database->db_query("INSERT INTO Bands_has_Members(userID, bandID) VALUES($userID, $bandID)");
	$id = mysql_insert_id();
	
	if(!$result) {
		$error->setError("There was a snake in my boots!");
		header("Location: /admin/audio/band/member/add/$bandID");
		die();
	}
	
	$c = 1;
	while($iId = $_POST['instrument'.$c]) {
		$result = $database->db_query("INSERT INTO Members_has_Instruments(memberID, instrumentID) VALUES($id, $iId)");
		if(!$result) {
			$error->setError("There was a snake in my boots!");
			header("Location: /admin/audio/band/member/add/$bandID");
			die();
		}
		$c++;
	}
	
	$msgObj->setMsg("You added $name as a new member!");
	header("Location: /admin/audio/band/$bandID");
	die();
?>