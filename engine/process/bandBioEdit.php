<?php
	global $database;
	global $msgObj;
	global $error;
	
	$bio = $_POST['bio'];
	$bandID = $_POST['bandID'];
	
	$result = $database->db_query("SELECT name FROM Bands WHERE bandID = $bandID");
	$row = mysqli_fetch_object($result);
	
	$result = $database->db_query("UPDATE Bands SET biography = '$bio' WHERE bandID = $bandID");
	
	if(!$result) {
		$error->setError("There was a snake in my boots!");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	$msgObj->setMsg("You updated the biography for the band ".$row->name);
	header("Location: /admin/audio/band/$bandID");
?>