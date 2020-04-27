<?php
	global $database;
	global $error;
	global $msgObj;
	
	$counterFile = "content/audio/albumArt/counter.txt";
	
	$bandID = $_POST['bandID'];
	$name = $_POST['aname'];
	$date = $_POST['date'];
	$producer = $_POST['producer'];
	$munniez = $_POST['munniez'];
	$credits = $_POST['credits'];
	$label = $_POST['label'];
	
	if($name == "") {
		$error->setError("You must give this album a name");
		header("Location: /admin/audio/band/album/add/$bandID");
		die();
	}
	
	if($date == "") {
		$error->setError("You must give this album a release date");
		header("Location: /admin/audio/band/album/add/$bandID");
		die();
	}
	
	if($_FILES['coverArt']['name'] != "" ){
		
		// Still needs size!
		if($_FILES['coverArt']['type'] == "image/png"){
			
			$fh = fopen($counterFile, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$png_name = "cart_$counter.png";
			
			$png_path = "content/audio/albumArt/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['coverArt']['name']);
			if(move_uploaded_file($_FILES['coverArt']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on uploading band picture!");
				header("Location: /admin/audio/band/album/add/$bandID");
				die();
			}
			
		} else {
			$error->setError("Band picture must be a PNG!");
			header("Location: /admin/audio/band/album/add/$bandID");
			die();
		}
	} else {
		$error->setError("You must upload an album picture");
		header("Location: /admin/audio/band/album/add/$bandID");
		die();
	}
	
	$numRows = 0;
	
	if($producer != '') {
		$result = $database->db_query("SELECT userID FROM Users WHERE name = '$producer'");
		$numRows = mysqli_num_rows($result);
		$rowUser = mysqli_fetch_object($result);
		if($numRows == 0) {
			$error->setError("The producer you entered, $producer, is not a member of the site.");
			header("Location: /admin/audio/band/album/add/$bandID");
			die();
		}
	} else {
		$error->setError("You must give this album a producer");
		header("Location: /admin/audio/band/album/add/$bandID");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Albums(name, releaseDate, producer, munniez, credits, studio, coverArt) VALUES('$name', '$date', ".$rowUser->userID.", $munniez, $credits, '$label', '$png_name')");
	$albumID = mysql_insert_id();
	if(!$result) {
		$error->setError("Error: Insert of the album $name failed!");
		header("Location: /admin/audio/band/album/add/$bandID");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Bands_has_Albums(bandID, albumID) VALUES($bandID, $albumID)");
	if(!$result) {
		$error->setError("Error: Insert of the album $name connection failed!");
		header("Location: /admin/audio/band/album/add/$bandID");
		die();
	}
	
	$msgObj->setMsg("You successfully added ".$name);
	header("Location: /admin/audio/band/album/$albumID");
	die();
	
?>