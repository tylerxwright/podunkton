<?php
	global $database;
	global $session;
	global $error;
	global $msgObj;
	global $core;
	
	$name = $_POST['name'];
	$description = $_POST['description'];
	$message = $_POST['message'];
	
	if($name == "") {
		$error->setError("You must give this badge a name");
		header("Location: /admin/add");
		die();
	}
	
	if($description == "") {
		$error->setError("You must give this badge a description");
		header("Location: /admin/add");
		die();
	}
	
	if($message == "") {
		$error->setError("You must give this badge a message");
		header("Location: /admin/add");
		die();
	}
	
	if($_FILES['icon']['name'] != "" ){
		
		// Still needs size!
		if($_FILES['icon']['type'] == "image/png"){
		
			$png_name = "badge_".time().".png";
			
			$png_path = "content/badges/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				if(!rename($tmp_path, $png_path)) {
					$error->setError("Error on moving the icon png!");
					header("Location: /admin/badges/add");
					die();
				}
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving icon png!");
				header("Location: /admin/badges/add");
				die();
			}
		} else {
			$error->setError("Badge icon file is not an png!");
			header("Location: /admin/badges/add");
			die();
		}
		
	} else {
		$error->setError("You must upload a badge icon");
		header("Location: /admin/badge/add");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Badges(name, icon, description, message) VALUES('$name', '$png_name', '$description', '$message')");
	if(!$result){
		$error->setError("ERROR: Insert of the badge failed");
		header("Location: /admin/badges/add");
		die();
	}
	
	$msgObj->setMsg("You successfully added the badge ".$name);
	header("Location: /admin/badges");
	die();
	
?>