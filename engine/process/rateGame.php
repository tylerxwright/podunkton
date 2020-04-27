<?php
	global $database;
	global $session;
	global $podunkton;
	global $core;
	
	$userID = $session->user;
	$gameID = $core->args[2];
	$rating = $core->args[3];
	
	$result = $database->db_query("UPDATE Games SET numRaters = numRaters + 1, rating = rating + $rating WHERE gameID = $gameID");
	$result = $database->db_query("INSERT INTO Games_has_Users(gameID, userID) VALUES($gameID, $userID)");
	$result = $database->db_query("SELECT rating, numRaters FROM Games WHERE gameID = $gameID");
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