<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['mname'];
	$line1 = $_POST['line1'];
	$line2 = $_POST['line2'];
	$line3 = $_POST['line3'];
	
	if($name == "") {
		$error->setError("You must give this MPAA Rating a name");
		header("Location: /admin/toon/mpaa/add");
		die();
	}
	
	// Still needs size!
	if($_FILES['icon']['type'] == "image/png"){
		$png_name = "mpaa_".time().".png";
		
		$png_path = "content/mpaa/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['icon']['name']);
		if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $png_path);
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving MPAA icon!");
			header("Location: /admin/toon/mpaa/add");
			die();
		}
	} else {
		$error->setError("MPAA icon must be a PNG!");
		header("Location: /admin/toon/mpaa/add");
		die();
	}
	
	$result = $database->db_query("INSERT INTO MPAA_Ratings(name, line1, line2, line3, icon) VALUES('$name', '$line1', '$line2', '$line3', '$png_name')");
	if(!$result) {
		$error->setError("Error: MPAA Insert failed!");
		header("Location: /admin/toon/mpaa/add");
		die();
	}
	
	$msgObj->setMsg("You added \"$name\" as a new MPAA Rating");
	header("Location: /admin/toon/mpaa");
	die();
	
?>