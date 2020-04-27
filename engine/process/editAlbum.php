<?php
	global $database;
	global $error;
	global $msgObj;
	
	$albumID = $_POST['albumID'];
	$name = $_POST['aname'];
	$date = $_POST['date'];
	$producer = $_POST['producer'];
	$munniez = $_POST['munniez'];
	$credits = $_POST['credits'];
	$label = $_POST['label'];
	
	if($name == "") {
		$error->setError("You must give this album a name");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	if($date == "") {
		$error->setError("You must give this album a release date");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	if($_FILES['coverArt']['name'] != "" ){
		
		$result = $database->db_query("SELECT coverArt FROM Albums WHERE albumID = $albumID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['coverArt']['type'] == "image/png"){
			
			$png_name = $row->coverArt;
			
			$png_path = "content/audio/albumArt/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['coverArt']['name']);
			if(move_uploaded_file($_FILES['coverArt']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving band picture!");
				header("Location: /admin/audio/band/album/$albumID");
				die();
			}
		} else {
			$error->setError("Band picture must be a PNG!");
			header("Location: /admin/audio/band/album/$albumID");
			die();
		}
	}
	
	$numRows = 0;
	
	if($producer != '') {
		$result = $database->db_query("SELECT userID FROM Users WHERE name = '$producer'");
		$numRows = mysqli_num_rows($result);
		$rowUser = mysqli_fetch_object($result);
		if($numRows == 0) {
			$error->setError("The producer you entered, $producer, is not a member of the site.");
			header("Location: /admin/audio/band/album/$albumID");
			die();
		}
	}
	
	if($producer != '') {
		$result = $database->db_query("UPDATE Albums SET name = '$name', releaseDate = '$date', producer = ".$rowUser->userID.", munniez = $munniez, credits = $credits, studio = '$label' WHERE albumID = $albumID");
	} else {
		$result = $database->db_query("UPDATE Albums SET name = '$name', releaseDate = '$date', munniez = $munniez, credits = $credits, studio = '$label' WHERE albumID = $albumID");
	}
	if(!$result) {
		$error->setError("Error: Update of $name failed!");
		header("Location: /admin/audio/band/album/$albumID");
		die();
	}
	
	$msgObj->setMsg("You successfully updated ".$name);
	header("Location: /admin/audio/band/album/$albumID");
	die();
	
?>