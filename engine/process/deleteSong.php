<?php
	global $database;
	global $core;
	global $error;
	global $msgObj;
	
	$albumID = $core->args[2];
	$songID = $core->args[3];
	
	// Get albums song list (Don't grab shared songs)
	$result = $database->db_query("SELECT s.songID, s.song FROM Songs as s WHERE s.songID = $songID AND s.songID NOT IN (SELECT ahs2.songID FROM Albums_has_Songs as ahs2 WHERE ahs2.albumID != $albumID)");
	$row = mysqli_fetch_object($result);
	
	// Remove song connection to album
	$result2 = $database->db_query("DELETE FROM Albums_has_Songs WHERE songID = ".$row->songID." AND albumID = ".$albumID);
	if(!$result2) {
		$error->setError("Error: Song (id:".$row->songID.") connection to album could not be removed");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	// Remove parentless songs
	$result2 = $database->db_query("DELETE FROM Songs WHERE songID = ".$row->songID);
	if(!$result2) {
		$error->setError("Error: Song (id:".$row->songID.") could not be removed");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	// Delete the song
	if(!unlink("/home/cycon/podunktonMusic/".$row->song)) {
		$error->setError("Error: Song file could not be deleted.");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	// Remove Raters
	$result2 = $database->db_query("DELETE FROM Songs_has_Users WHERE songID = $songID");
	if(!$result2) {
		$error->setError("Error: Songs raters could not be removed, not really a big deal");
	}
	
	$msgObj->setMsg("The song (id:$songID) has been removed!");
	header("Location: /admin/audio/band/album/$albumID");
	die();
	
?>