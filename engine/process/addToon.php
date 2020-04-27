<?php
	global $database;
	global $error;
	global $msgObj;

	$name     = $_POST['name'];
	$seasonID = $_POST['seasonID'];	
	$release  = $_POST['rDate'];
	$ngLink   = $_POST['NG_Link'];
	$desc     = $_POST['description'];
	$episode  = $_POST['episode'];
	$munniez  = $_POST['munniez'];
	$credits  = $_POST['credits'];
	$mpaaRating = $_POST['mpaaRating'];
	$munniezOnView = $_POST['munniezOnView'];

	//check for valid input	
	if($name == ""){
		$error->setError("You must give this toon a name");
		header("Location: /admin/toon/add");
		die();
	}
	
	if($release == ""){
		$release = date('Y-m-d');
	}
	
	if($desc == ""){
		$error->setError("You must give this toon a description");
		header("Location: /admin/toon/add");
		die();
	}
	
	if($episode == ""){
		$error->setError("You must give this toon an episode number");
		header("Location: /admin/toon/add");
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
	

	//make safe name from name
	$tempName = eregi_replace(" ","_",$name);
	$tempName = eregi_replace("-","_",$tempName);
	$safeName = strtolower($tempName);

	// Still needs size!
	if($_FILES['swf']['type'] == "application/x-shockwave-flash"){
		
		$swf_name = "toon_".time().".swf";
		
		$swf_path = "content/toons/swfs/".$swf_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['swf']['name']);
		if(move_uploaded_file($_FILES['swf']['tmp_name'], $tmp_path)) {
			if(!rename($tmp_path, $swf_path)) {
				$error->setError("Error on moving the toon swf!");
				header("Location: /admin/toon/add");
				die();
			}
			chmod($swf_path, 0777);
		} else {
			$error->setError("Error on moving toon swf!");
			header("Location: /admin/toon/add");
			die();
		}
	} else {
		$error->setError("Toon swf file is not an swf!");
		header("Location: /admin/toon/add");
		die();
	}

	$fileSize = sprintf("%01.1f", filesize($swf_path)/1000000);

	// Still needs size!
	if($_FILES['icon']['type'] == "image/png"){
		
		$png_name = "icon_".time().".png";
		
		$png_path = "content/toons/images/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['icon']['name']);
		if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
			if(!rename($tmp_path, $png_path)) {
				$error->setError("Error on moving the toon icon!");
				header("Location: /admin/toon/add");
				die();
			}
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving the toon icon!");
			header("Location: /admin/toon/add");
			die();
		}
	} else {
		$error->setError("Toon icon is not a png! Honestly what were you thinking? I work with idiots!");
		header("Location: /admin/toon/add");
		die();
	}

	$result = $database->db_query("INSERT INTO Toons(name, season, description, releaseDate, ngLink, episode, swf, safeName, munniez, credits, munniezOnView, icon, mpaaRating, fileSize) VALUES('$name', $seasonID, '$desc', '$release', '$ngLink', $episode, '$swf_name', '$safeName', $munniez, $credits, $munniezOnView, '$png_name', $mpaaRating, $fileSize)");
	if(!$result) {
		$error->setError("Error: Insert failed!");
		header("Location: /admin/toon/add");
		die();
	}

	//get the tid from recently inserted toon.
	$id = mysql_insert_id();

	$result = $database->db_query("INSERT INTO Seasons_has_Toons(toonID, seasonID) VALUES($id, $seasonID)");
	if(!$result) {
		$error->setError("Error: Insert of toon-season link failed!");
		header("Location: /admin/toon/add");
		die();
	}

	$msgObj->setMsg("You added \"$name\" as a new toon");
	header("Location: /admin/toon/$id");
	die();

?>
