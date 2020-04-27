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
	$songID = $_POST['songID'];
	
	if($name == "") {
		$error->setError("You must give this song a name");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	if($track == "") {
		$error->setError("You must give this song a track number");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	if($length == "") {
		$error->setError("You must give this song a length");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	if($munniez == "") {
		$munniez = 0;
	}
	
	if($credits == "") {
		$credits = 0;
	}
	
	if($_FILES['song']['name'] != "" ){
	
		$result = $database->db_query("SELECT song FROM Songs WHERE songID = $songID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['song']['type'] == "audio/mpeg"){
			
			$mp3_name = $row->song;
			
			$mp3_path = "/home/cycon/podunktonMusic/".$mp3_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['song']['name']);
			if(move_uploaded_file($_FILES['song']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $mp3_path);
				chmod($mp3_path, 0777);
			} else {
				$error->setError("Error on moving song file!");
				header("Location: /admin/audio/band/album/$albumID");
				die();
			}
		} else {
			$error->setError("Song must be an MP3!");
			header("Location: /admin/audio/band/album/$albumID");
			die();
		}
	}
	
	$result = $database->db_query("UPDATE Songs SET name='$name', track=$track, length=$length, munniez=$munniez, credits=$credits WHERE songID = $songID");
	if(!$result) {
		$error->setError("Error: Update of song failed!");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	$msgObj->setMsg("You updated the song \"$name\"");
	header("Location: /admin/audio/band/album/$albumID");
	die();
	
?>