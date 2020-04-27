<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['sname'];
	$order = $_POST['order'];
	$seasonID = $_POST['seasonID'];
	
	if($name == "") {
		$error->setError("You must give this season a name");
		header("Location: /admin/toon/season/edit/$sessionID");
		die();
	}
	
	if($order == "") {
		$order = 10;
	}
	
	if($_FILES['picture']['name'] != "") {
		$result = $database->db_query("SELECT picture FROM Toon_Seasons WHERE seasonID = $seasonID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['picture']['type'] == "image/png"){
			
			$png_name = $row->picture;
			
			$png_path = "content/toons/seasons/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['picture']['name']);
			if(move_uploaded_file($_FILES['picture']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving blue season picture!");
				header("Location: /admin/toon/season/edit/$sessionID");
				die();
			}
		} else {
			$error->setError("Season blue picture must be a PNG!");
			header("Location: /admin/toon/season/edit/$sessionID");
			die();
		}
	}
	
	if($_FILES['hpicture']['name'] != "") {
		$result = $database->db_query("SELECT hoverPicture FROM Toon_Seasons WHERE seasonID = $seasonID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['hpicture']['type'] == "image/png"){
			
			$png_name2 = $row->hoverPicture;
			
			$png_path = "content/toons/seasons/".$png_name2;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['hpicture']['name']);
			if(move_uploaded_file($_FILES['hpicture']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving season hover picture!");
				header("Location: /admin/toon/season/edit/$sessionID");
				die();
			}
		} else {
			$error->setError("Season hover picture must be a PNG!");
			header("Location: /admin/toon/season/edit/$sessionID");
			die();
		}
	}
	
	$tempName = eregi_replace(" ","_",$name);
	$tempName = eregi_replace("-","_",$tempName);
	$safeName = strtolower($tempName);
	
	$result = $database->db_query("UPDATE Toon_Seasons SET name='$name', seasonOrder=$order, safeName='$safeName' WHERE seasonID=$seasonID");
	if(!$result) {
		$error->setError("Error: Failed on update");
		header("Location: /admin/toon/season/edit/$sessionID");
		die();
	} else {
		$msgObj->setMsg("You updated the season \"$name\"");
		header("Location: /admin/toon/season");
		die();
	}
?>