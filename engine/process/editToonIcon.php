<?php
	global $database;
	global $error;
	global $msgObj;
	
	$toonID = $_POST['toonID'];
	
	$result = $database->db_query("SELECT icon, name FROM Toons WHERE toonID = $toonID");
	$row = mysqli_fetch_object($result);
	
	// Still needs size!
	if($_FILES['icon']['type'] == "image/png"){
		
		$png_name = $row->icon;
		
		$png_path = "content/toons/images/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['icon']['name']);
		if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $png_path);
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving toon icon!");
			header("Location: /admin/toon/$toonID");
			die();
		}
	} else {
		$error->setError("Icon must be a PNG!");
		header("Location: /admin/toon/$toonID");
		die();
	}
	
	$msgObj->setMsg("You successfully changed ".$row->name."'s icon, way to go!");
	header("Location: /admin/toon/$toonID");
	die();
	
?>