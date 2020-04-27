<?php
	global $database;
	global $error;
	global $msgObj;
	
	$gameID = $_POST['gameID'];
	$name     = $_POST['name'];	
	$release  = $_POST['rDate'];
	$ngLink   = $_POST['NG_Link'];
	$desc     = $_POST['description'];
	$munniez  = $_POST['munniez'];
	$credits  = $_POST['credits'];
	$mpaaRating = $_POST['mpaaRating'];
	$munniezOnView = $_POST['munniezOnView'];
	$frameSize = $_POST['frameSize'];
	$fileSize = 0;

	//check for valid input	
	if($name == ""){
		$error->setError("You must give this game a name");
		header("Location: /admin/game/edit/$gameID");
		die();
	}
	
	if($release == ""){
		$release = date('Y-m-d');
	}
	
	if($desc == ""){
		$error->setError("You must give this game a description");
		header("Location: /admin/game/edit/$gameID");
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
	
	if($frameSize == "") {
		$error->setError("You must give this game a frame size");
		header("Location: /admin/game/edit/$gameID");
		die();
	}

	//make safe name from name
	$tempName = eregi_replace(" ","_",$name);
	$tempName = eregi_replace("-","_",$tempName);
	$safeName = strtolower($tempName);
	
	if($_FILES['swf']['name'] != "") {
		$result = $database->db_query("SELECT swf FROM Games WHERE gameID = $gameID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['swf']['type'] == "application/x-shockwave-flash"){
			
			$swf_name = $row->swf;
			
			$swf_path = "content/games/swfs/".$swf_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['swf']['name']);
			if(move_uploaded_file($_FILES['swf']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $swf_path);
				chmod($swf_path, 0777);
				$fileSize = sprintf("%01.1f", filesize($swf_path)/1000000);
			} else {
				$error->setError("Error on moving game file!");
				header("Location: /admin/game/edit/$gameID");
				die();
			}
		} else {
			$error->setError("Game file must be an swf!");
			header("Location: /admin/game/edit/$gameID");
			die();
		}
	}
	
	if($_FILES['icon']['name'] != "") {
		$result = $database->db_query("SELECT icon FROM Games WHERE gameID = $gameID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['icon']['type'] == "application/x-shockwave-flash"){
			
			$png_name = $row->icon;
			
			$png_path = "content/games/images/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving game icon!");
				header("Location: /admin/games/edit/$gameID");
				die();
			}
		} else {
			$error->setError("Game icon must be a png!");
			header("Location: /admin/games/edit/$gameID");
			die();
		}
	}
	
	if($fileSize == 0) {
		$result = $database->db_query("UPDATE Games SET name='$name', description='$desc', releaseDate='$release', ngLink='$ngLink', safeName='$safeName', munniez=$munniez, credits=$credits, munniezOnView=$munniezOnView, mpaaRating='$mpaaRating', frameSize='$frameSize' WHERE gameID=$gameID");
	} else {
		$result = $database->db_query("UPDATE Games SET name='$name', description='$desc', releaseDate='$release', ngLink='$ngLink', safeName='$safeName', munniez=$munniez, credits=$credits, munniezOnView=$munniezOnView, mpaaRating='$mpaaRating', fileSize=$fileSize, frameSize='$frameSize' WHERE gameID=$gameID");
	}
	if(!$result) {
		$error->setError("Error: Update failed!");
		header("Location: /admin/game/edit/$gameID");
		die();
	}

	$msgObj->setMsg("You updated \"$name\"");
	header("Location: /admin/game/$gameID");
	die();
	
?>