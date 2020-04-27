<?php
	global $database;
	global $core;
	global $error;
	global $msgObj;
	
	$albumID = $core->args[2];
	$bandID = $core->args[3];
	
	$result = $database->db_query("SELECT coverArt FROM Albums WHERE albumID = $albumID");
	$row = mysqli_fetch_object($result);
	if(!$result) {
		$error->setError("Error: Could not query for album");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	// Delete the coverArt
	if(!unlink("content/audio/albumArt/".$row->coverArt)) {
		$error->setError("Error: Cover art could not be deleted.");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	// Remove actual album
	$result = $database->db_query("DELETE FROM Albums WHERE albumID = $albumID");
	if(!$result) {
		$error->setError("Error: Album could not be deleted from the database");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	// Remove band connection to album
	$result = $database->db_query("DELETE FROM Bands_has_Albums WHERE albumID = $albumID");
	if(!$result) {
		$error->setError("Error: Album could not be deleted from the database Bands_has_Albums");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	// Get albums song list (Don't grab shared songs)
	$result = $database->db_query("SELECT ahs.songID, s.song FROM Albums_has_Songs as ahs JOIN Songs as s ON s.songID = ahs.songID WHERE ahs.albumID = $albumID AND ahs.songID NOT IN (SELECT ahs2.songID FROM Albums_has_Songs as ahs2 WHERE ahs2.albumID != $albumID)");
	while($row = mysqli_fetch_object($result)){
		
		// Remove song connection to album
		$result2 = $database->db_query("DELETE FROM Albums_has_Songs WHERE songID = ".$row->songID);
		if(!$result2) {
			$error->setError("Error: Song (id:".$row->songID.") connection to album could not be removed");
			header("Location: /admin/audio/band/$bandID");
			die();
		}
		
		// Remove parentless songs
		$result2 = $database->db_query("DELETE FROM Songs WHERE songID = ".$row->songID);
		if(!$result2) {
			$error->setError("Error: Song (id:".$row->songID.") could not be removed");
			header("Location: /admin/audio/band/$bandID");
			die();
		}
		
		// Delete the song
		if(!unlink("/home/cycon/podunktonMusic/".$row->song)) {
			$error->setError("Error: Song file could not be deleted.");
			header("Location: /admin/audio/band/$bandID");
			die();
		}
		
	}
	
	$msgObj->setMsg("Wow, that was rough but we did it. The album (id:$albumID) and any of its direct songs have been removed!");
	header("Location: /admin/audio/band/$bandID");
	die();
	
?>