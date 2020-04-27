<?php
	global $database;
	global $error;
	global $msgObj;
	
	$bandID = $_POST['bandID'];
	$name = $_POST['bname'];
	$genre = $_POST['genre'];
	$label = $_POST['label'];
	$homepage = $_POST['homepage'];
	$bio = $_POST['biography'];
	
	if($name == "") {
		$error->setError("You must give this band a name");
		header("Location: /admin/audio/band/edit/$bandID");
		die();
	}
	
	if($_FILES['bandPicture']['name'] != "") {
		$result = $database->db_query("SELECT picture FROM Bands WHERE bandID = $bandID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['bandPicture']['type'] == "image/png"){
			
			$png_name = $row->picture;
			
			$png_path = "content/audio/bandPicture/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['bandPicture']['name']);
			if(move_uploaded_file($_FILES['bandPicture']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving band picture!");
				header("Location: /admin/audio/band/edit/$bandID");
				die();
			}
		} else {
			$error->setError("Band picture must be a PNG!");
			header("Location: /admin/audio/band/edit/$bandID");
			die();
		}
	}
	
	$tempName = eregi_replace(" ","_",$name);
	$safeName = strtolower($tempName);
	
	$result = $database->db_query("UPDATE Bands SET name = '$name', genre = $genre, label = $label, homepage = '$homepage', biography = '$bio', safeName = '$safeName' WHERE bandID = $bandID");
	if(!$result) {
		$error->setError("Error: Update of $name failed!");
		header("Location: /admin/audio/band/edit/$bandID");
		die();
	}
	
	$msgObj->setMsg("You successfully updated ".$name);
	header("Location: /admin/audio/band/$bandID");
	die();
	
?>