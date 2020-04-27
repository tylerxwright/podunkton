<?php
	global $database;
	global $error;
	global $msgObj;

	$name     = $_POST['name'];
	$release  = $_POST['rDate'];
	$ngLink   = $_POST['NG_Link'];
	$desc     = $_POST['description'];
	$munniez  = $_POST['munniez'];
	$credits  = $_POST['credits'];
	$mpaaRating = $_POST['mpaaRating'];
	$munniezOnView = $_POST['munniezOnView'];
	$frameSize = $_POST['frameSize'];

	//check for valid input	
	if($name == ""){
		$error->setError("You must give this game a name");
		header("Location: /admin/game/add");
		die();
	}
	
	if($release == ""){
		$release = date('Y-m-d');
	}
	
	if($desc == ""){
		$error->setError("You must give this game a description");
		header("Location: /admin/game/add");
		die();
	}
	
	if($munniez == "") {
		$munniez = 0;
	}
	
	if($munniezOnView == "") {
		$munniezOnView = 0;
	}
	
	if($credits == "") {
		$credits = 0;
	}
	
	if($frameSize == ""){
		$error->setError("You must give this game a frame size");
		header("Location: /admin/game/add");
		die();
	}
	

	//make safe name from name
	$tempName = eregi_replace(" ","_",$name);
	$tempName = eregi_replace("-","_",$tempName);
	$safeName = strtolower($tempName);

	// Still needs size!
	if($_FILES['swf']['type'] == "application/x-shockwave-flash"){
		
		$swf_name = "game_".time().".swf";
		
		$swf_path = "content/games/swfs/".$swf_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['swf']['name']);
		if(move_uploaded_file($_FILES['swf']['tmp_name'], $tmp_path)) {
			if(!rename($tmp_path, $swf_path)) {
				$error->setError("Error on moving the game swf!");
				header("Location: /admin/game/add");
				die();
			}
			chmod($swf_path, 0777);
		} else {
			$error->setError("Error on moving game swf!");
			header("Location: /admin/toon/add");
			die();
		}
	} else {
		$error->setError("Toon swf file is not an swf!");
		header("Location: /admin/game/add");
		die();
	}

	$fileSize = sprintf("%01.1f", filesize($swf_path)/1000000);

	// Still needs size!
	if($_FILES['icon']['type'] == "image/png"){
		
		$png_name = "icon_".time().".png";
		
		$png_path = "content/games/images/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['icon']['name']);
		if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
			if(!rename($tmp_path, $png_path)) {
				$error->setError("Error on moving the game icon!");
				header("Location: /admin/game/add");
				die();
			}
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving the game icon!");
			header("Location: /admin/game/add");
			die();
		}
	} else {
		$error->setError("Game icon is not a png! Honestly what were you thinking? I work with idiots!");
		header("Location: /admin/game/add");
		die();
	}

	$result = $database->db_query("INSERT INTO Games(name, description, releaseDate, ngLink, swf, safeName, munniez, credits, munniezOnView, icon, mpaaRating, fileSize, frameSize) VALUES('$name', '$desc', '$release', '$ngLink', '$swf_name', '$safeName', $munniez, $credits, $munniezOnView, '$png_name', $mpaaRating, $fileSize, '$frameSize')");
	if(!$result) {
		$error->setError("Error: Insert failed!");
		header("Location: /admin/game/add");
		die();
	}

	//get the tid from recently inserted toon.
	$id = mysql_insert_id();

	$msgObj->setMsg("You added \"$name\" as a new game");
	header("Location: /admin/game/$id");
	die();

?>
