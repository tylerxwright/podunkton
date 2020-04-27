<?php
	global $database;
	global $error;
	global $msgObj;
	
	$bandID = $_POST['bandID'];
	
	$result = $database->db_query("SELECT picture, name FROM Bands WHERE bandID = $bandID");
	$row = mysqli_fetch_object($result);
	
	// Still needs size!
	if($_FILES['pic']['type'] == "image/png"){
		
		$png_name = $row->picture;
		
		$png_path = "content/audio/bandPicture/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['pic']['name']);
		if(move_uploaded_file($_FILES['pic']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $png_path);
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving band picture!");
			header("Location: /admin/audio/band/$bandID");
			die();
		}
	} else {
		$error->setError("Band picture must be a PNG!");
		header("Location: /admin/audio/band/$bandID");
		die();
	}
	
	$msgObj->setMsg("You successfully changed ".$row->name."'s band picture, way to go!");
	header("Location: /admin/audio/band/$bandID");
	die();
	
?>