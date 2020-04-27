<?php
	global $database;
	global $error;
	global $msgObj;
	
	$name = $_POST['sname'];
	$order = $_POST['order'];
	
	if($name == "") {
		$error->setError("You must give this season a name");
		header("Location: /admin/toon/season/add");
		die();
	}
	
	if($order == "") {
		$order = 10;
	}
	
	// Still needs size!
	if($_FILES['picture']['type'] == "image/png"){
		$png_name = "season_".time().".png";
		
		$png_path = "content/toons/seasons/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['picture']['name']);
		if(move_uploaded_file($_FILES['picture']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $png_path);
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving blue season picture!");
			header("Location: /admin/toon/season/add");
			die();
		}
	} else {
		$error->setError("Season blue picture must be a PNG!");
		header("Location: /admin/toon/season/add");
		die();
	}
	
	// Still needs size!
	if($_FILES['hpicture']['type'] == "image/png"){
		$png_name2 = "seasonHover_".time().".png";
		
		$png_path = "content/toons/seasons/".$png_name2;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['hpicture']['name']);
		if(move_uploaded_file($_FILES['hpicture']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $png_path);
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving season hover picture!");
			header("Location: /admin/toon/season/add");
			die();
		}
	} else {
		$error->setError("Season hover picture must be a PNG!");
		header("Location: /admin/toon/season/add");
		die();
	}
	
	$tempName = eregi_replace(" ","_",$name);
	$tempName = eregi_replace("-","_",$tempName);
	$safeName = strtolower($tempName);
	
	$result = $database->db_query("INSERT INTO Toon_Seasons(name, seasonOrder, picture, hoverPicture, safeName) VALUES('$name', $order, '$png_name', '$png_name2', '$safeName')");
	if(!$result) {
		$error->setError("Error: Failed on insert");
		header("Location: /admin/toon/season/add");
		die();
	} else {
		$msgObj->setMsg("You added \"$name\" as a new toon season");
		header("Location: /admin/toon/season");
		die();
	}
?>