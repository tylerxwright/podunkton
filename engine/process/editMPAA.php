<?php
	global $database;
	global $error;
	global $msgObj;
	
	$mpaaID = $_POST['mpaaID'];
	$name = $_POST['mname'];
	$line1 = $_POST['line1'];
	$line2 = $_POST['line2'];
	$line3 = $_POST['line3'];
	
	if($name == "") {
		$error->setError("You must give this MPAA Rating a name");
		header("Location: /admin/toon/mpaa/add");
		die();
	}
	
	if($_FILES['icon']['name'] != "") {
		$result = $database->db_query("SELECT icon FROM MPAA_Ratings WHERE mpaaID = $mpaaID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['icon']['type'] == "image/png"){
			
			$png_name = $row->icon;
			
			$png_path = "content/mpaa/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving MPAA icon!");
				header("Location: /admin/toon/mpaa/edit/$mpaaID");
				die();
			}
		} else {
			$error->setError("MPAA icon must be a PNG!");
			header("Location: /admin/toon/mpaa/edit/$mpaaID");
			die();
		}
	}
	
	$result = $database->db_query("UPDATE MPAA_Ratings SET name='$name', line1='$line1', line2='$line2', line3='$line3' WHERE mpaaID=$mpaaID");
	if(!$result) {
		$error->setError("Error: MPAA Update failed!");
		header("Location: /admin/toon/mpaa/edit/$mpaaID");
		die();
	}
	
	$msgObj->setMsg("You added \"$name\" as a new MPAA Rating");
	header("Location: /admin/toon/mpaa");
	die();
	
?>