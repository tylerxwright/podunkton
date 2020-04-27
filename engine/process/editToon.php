<?php
	global $database;
	global $error;
	global $msgObj;
	
	$toonID = $_POST['toonID'];
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
	$fileSize = 0;

	//check for valid input	
	if($name == ""){
		$error->setError("You must give this toon a name");
		header("Location: /admin/toon/edit/$toonID");
		die();
	}
	
	if($release == ""){
		$release = date('Y-m-d');
	}
	
	if($desc == ""){
		$error->setError("You must give this toon a description");
		header("Location: /admin/toon/edit/$toonID");
		die();
	}
	
	if($episode == ""){
		$error->setError("You must give this toon an episode number");
		header("Location: /admin/toon/edit/$toonID");
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
	
	if($_FILES['swf']['name'] != "") {
		$result = $database->db_query("SELECT swf FROM Toons WHERE toonID = $toonID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['swf']['type'] == "application/x-shockwave-flash"){
			
			$swf_name = $row->swf;
			
			$swf_path = "content/toons/swfs/".$swf_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['swf']['name']);
			if(move_uploaded_file($_FILES['swf']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $swf_path);
				chmod($swf_path, 0777);
				$fileSize = sprintf("%01.1f", filesize($swf_path)/1000000);
			} else {
				$error->setError("Error on moving toon file!");
				header("Location: /admin/toon/edit/$toonID");
				die();
			}
		} else {
			$error->setError("Toon file must be an swf!");
			header("Location: /admin/toon/edit/$toonID");
			die();
		}
	}
	
	if($_FILES['icon']['name'] != "") {
		$result = $database->db_query("SELECT icon FROM Toons WHERE toonID = $toonID");
		$row = mysqli_fetch_object($result);
		
		// Still needs size!
		if($_FILES['icon']['type'] == "application/x-shockwave-flash"){
			
			$png_name = $row->icon;
			
			$png_path = "content/toons/images/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			} else {
				$error->setError("Error on moving toon icon!");
				header("Location: /admin/toon/edit/$toonID");
				die();
			}
		} else {
			$error->setError("Toon icon must be a png!");
			header("Location: /admin/toon/edit/$toonID");
			die();
		}
	}
	
	if($fileSize == 0) {
		//echo "UPDATE Toons SET name='$name', season=$seasonID, description='$description', releaseDate='$releaseDate', ngLink='$ngLink', episode=$episode, safeName='$safeName', munniez=$munniez, credits=$credits, munniezOnView=$munniezOnView, mpaaRating='$mpaaRating' WHERE toonID=$toonID";
		$result = $database->db_query("UPDATE Toons SET name='$name', season=$seasonID, description='$desc', releaseDate='$release', ngLink='$ngLink', episode=$episode, safeName='$safeName', munniez=$munniez, credits=$credits, munniezOnView=$munniezOnView, mpaaRating='$mpaaRating' WHERE toonID=$toonID");
	} else {
		//echo "UPDATE Toons SET name='$name', season=$seasonID, description='$description', releaseDate='$releaseDate', ngLink='$ngLink', episode=$episode, safeName='$safeName', munniez=$munniez, credits=$credits, munniezOnView=$munniezOnView, mpaaRating='$mpaaRating', fileSize=$fileSize WHERE toonID=$toonID";
		$result = $database->db_query("UPDATE Toons SET name='$name', season=$seasonID, description='$desc', releaseDate='$release', ngLink='$ngLink', episode=$episode, safeName='$safeName', munniez=$munniez, credits=$credits, munniezOnView=$munniezOnView, mpaaRating='$mpaaRating', fileSize=$fileSize WHERE toonID=$toonID");
	}
	if(!$result) {
		$error->setError("Error: Update failed!");
		header("Location: /admin/toon/edit/$toonID");
		die();
	}

	$result = $database->db_query("DELETE FROM Seasons_has_Toons WHERE toonID = $toonID");
	if(!$result) {
		$error->setError("Error: Couldn't delete toon season link!");
		header("Location: /admin/toon/add");
		die();
	}

	$result = $database->db_query("INSERT INTO Seasons_has_Toons(toonID, seasonID) VALUES($toonID, $seasonID)");
	if(!$result) {
		$error->setError("Error: Insert of toon-season link failed!");
		header("Location: /admin/toon/add");
		die();
	}

	$msgObj->setMsg("You updated \"$name\"");
	header("Location: /admin/toon/$toonID");
	die();
	
?>