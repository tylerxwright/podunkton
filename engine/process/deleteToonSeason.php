<?php
	global $database;
	global $core;
	global $error;
	global $msgObj;
	
	$seasonID = $core->args[2];
	
	$result = $database->db_query("SELECT sht.toonID FROM Toon_Seasons as ts JOIN Seasons_has_Toons as sht ON sht.seasonID = ts.seasonID WHERE ts.seasonID = $seasonID");
	$row = mysqli_fetch_object($result);
	
	
	$result = $database->db_query("SELECT ts.name, ts.picture, ts.hoverPicture FROM Toon_Seasons as ts WHERE ts.seasonID = $seasonID");
	$row2 = mysqli_fetch_object($result);
	
	// Remove season
	$result2 = $database->db_query("DELETE FROM Toon_Seasons WHERE seasonID = ".$seasonID);
	if(!$result2) {
		$error->setError("Error: The season could not be deleted");
		header("Location: /admin/toon/season");
		die();
	}
	
	// Remove season connection
	$result2 = $database->db_query("DELETE FROM Seasons_has_Toons WHERE seasonID = ".$seasonID);
	if(!$result2) {
		$error->setError("Error: The season link could not be deleted");
		header("Location: /admin/toon/season");
		die();
	}
	
	if($row->toonID != ""){
		// Remove all of the seasons toons
		$result2 = $database->db_query("DELETE FROM Toons WHERE toonID = ".$row->toonID);
		if(!$result2) {
			$error->setError("Error: The seasons toons could not be deleted");
			header("Location: /admin/toon/season");
			die();
		}
	}
	
	// Delete the picture
	if(!unlink("content/toons/seasons/".$row2->picture)) {
		$error->setError("Error: Blue season picture could not be deleted.");
		header("Location: /admin/toon/season");
		die();
	}
	
	// Delete the blue picture
	if(!unlink("content/toons/seasons/".$row2->hoverPicture)) {
		$error->setError("Error: Season hover picture could not be deleted.");
		header("Location: /admin/toon/season");
		die();
	}
	
	$msgObj->setMsg("You successfully deleted ".$row2->name." and all of its toons");
	header("Location: /admin/toon/season");
	die();
	
?>