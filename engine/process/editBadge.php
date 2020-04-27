<?php
	global $database;
	global $error;
	global $msgObj;
	
	$badgeID = $_POST['badgeID'];
	$name     = $_POST['name'];	
	$description = $_POST['description'];
	$message  = $_POST['message'];

	//check for valid input	
	if($name == "") {
		$error->setError("You must give this badge a name");
		header("Location: /admin/edit/$badgeID");
		die();
	}
	
	if($description == "") {
		$error->setError("You must give this badge a description");
		header("Location: /admin/edit/$badgeID");
		die();
	}
	
	if($message == "") {
		$error->setError("You must give this badge a message");
		header("Location: /admin/edit/$badgeID");
		die();
	}
	
	if($_FILES['icon']['name'] != "") {
		$result = $database->db_query("SELECT icon FROM Badges WHERE badgeID = $badgeID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['icon']['type'] == "image/png"){
			
			$png_name = $row->icon;
			
			$png_path = "content/badges/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving icon file!");
				header("Location: /admin/edit/$badgeID");
				die();
			}
		} else {
			$error->setError("Icon file must be a png!");
			header("Location: /admin/edit/$badgeID");
			die();
		}
	}
	
	$result = $database->db_query("UPDATE Badges SET name='$name', description='$description', message='$message' WHERE badgeID = $badgeID");
	if(!$result) {
		$error->setError("Error: Update failed!");
		header("Location: /admin/edit/$badgeID");
		die();
	}

	$msgObj->setMsg("You updated \"$name\"");
	header("Location: /admin/badges");
	die();
	
?>