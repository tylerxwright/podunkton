<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['sname'];
	$track = $_POST['track'];
	$length = $_POST['length'];
	$munniez = $_POST['munniez'];
	$credits = $_POST['credits'];
	$albumID = $_POST['albumID'];
	
	if($name == "") {
		$error->setError("You must give this song a name");
		header("Location: /admin/audio/band/album/song/add/$albumID");
		die();
	}
	if($track == "") {
		$error->setError("You must give this song a track number");
		header("Location: /admin/audio/band/album/song/add/$albumID");
		die();
	}
	if($length == "") {
		$error->setError("You must give this song a length in seconds");
		header("Location: /admin/audio/band/album/song/add/$albumID");
		die();
	}
	if($munniez == "") {
		$munniez = 0;
	}
	if($credits == "") {
		$credits = 0;
	}
	
	// Still needs size!
	//if($_FILES['song']['type'] == "audio/mpeg"){
		
		$mp3_name = $_FILES['song']['name'];
		
		$mp3_path = "/home/cycon/podunktonMusic/".$mp3_name;
		
		if(file_exists($mp3_path)){
			$mp3_path = "/home/cycon/podunktonMusic/".$name."_".time().".mp3";
			$mp3_name = $name."_".time().".mp3";
		}
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['song']['name']);
		if(move_uploaded_file($_FILES['song']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $mp3_path);
			chmod($mp3_path, 0777);
		} else {
			$error->setError("Error on moving song file!");
			header("Location: /admin/audio/band/album/song/add/$albumID");
			die();
		}
	//} else {
		//$error->setError("Song must be an MP3!");
		//header("Location: /admin/audio/band/album/song/add/$albumID");
		//die();
	//}
	
	$result = $database->db_query("INSERT INTO Songs(name, track, song, length, munniez, credits) VALUES('$name', $track, '$mp3_name', $length, $munniez, $credits)");
	if(!$result) {
		$error->setError("Error: Insert into Songs failed");
		header("Location: /admin/audio/band/album/song/add/$albumID");
		die();
	}
	$id = mysql_insert_id();
	$result = $database->db_query("INSERT INTO Albums_has_Songs(albumID, songID) VALUES($albumID, $id)");
	if(!$result) {
		$error->setError("Error: Insert into Albums_has_Songs failed");
		header("Location: /admin/audio/band/album/song/add/$albumID");
		die();
	}
	
	$msgObj->setMsg("You added \"$name\" as a new song");
	header("Location: /admin/audio/band/album/$albumID");
	die();
	
?>