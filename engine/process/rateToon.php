<?php
	global $database;
	global $session;
	global $podunkton;
	global $core;
	
	$userID = $session->user;
	$toonID = $core->args[2];
	$rating = $core->args[3];
	
	$result = $database->db_query("UPDATE Toons SET numRaters = numRaters + 1, rating = rating + $rating WHERE toonID = $toonID");
	$result = $database->db_query("INSERT INTO Toons_has_Users(toonID, userID) VALUES($toonID, $userID)");
	$result = $database->db_query("SELECT rating, numRaters FROM Toons WHERE toonID = $toonID");
	$row = mysqli_fetch_object($result);
	$rating = $row->rating;
	$numRaters = $row->numRaters;
	
	if($row->numRaters != 0) {
		$rating = $row->rating/$row->numRaters;
	} else {
		$rating = 0;
	}
	$return = $podunkton->stars($rating);
	
	echo $return;
	die();
	
?>