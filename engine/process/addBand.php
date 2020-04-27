<?php
	global $database;
	global $msgObj;
	global $error;
	
	$counterFile = "content/audio/bandPicture/counter.txt";
	
	$name = $_POST['bname'];
	$genre = $_POST['genre'];
	$label = $_POST['label'];
	$bio = $_POST['biography'];
	$homepage = $_POST['homepage'];
	
	if($name == "") {
		$error->setError("You must give this band a name");
		header("Location: /admin/audio/band/add");
		die();
	}
	
	// Still needs size!
	if($_FILES['bandPicture']['type'] == "image/png"){
		$fh = fopen($counterFile, "r");
		$counter = fread($fh, 50);
		fclose($fh);
		
		$fh = fopen($counterFile, "w+");
		fwrite($fh, $counter+1);
		fclose($fh);
		
		$png_name = "bpic_$counter.png";
		
		$png_path = "content/audio/bandPicture/".$png_name;
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['bandPicture']['name']);
		if(move_uploaded_file($_FILES['bandPicture']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $png_path);
			chmod($png_path, 0777);
		} else {
			$error->setError("Error on moving band picture!");
			header("Location: /admin/audio/band/add");
			die();
		}
	} else {
		$error->setError("Band picture must be a PNG!");
		header("Location: /admin/audio/band/add");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Forum_Thread(subject, author, dateAdded, subcategoryID, toleranceMin) VALUES('$name discussion', 1, NOW(), (SELECT subcategoryID FROM Forum_Subcategory WHERE name = 'Music Discussion'), -20)");
	$threadID = mysql_insert_id();
	
	$result = $database->db_query("INSERT INTO Forum_Post(threadID, post, author, dateAdded) VALUES($threadID, '<b>How much to you love $name?</b>', 1, NOW())");
	
	$tempName = eregi_replace(" ","_",$name);
	$safeName = strtolower($tempName);
	
	$result = $database->db_query("INSERT INTO Bands(name, biography, genre, picture, homepage, label, safeName, thread) VALUES('$name', '$bio', $genre, '$png_name', '$homepage', $label, '$safeName', $threadID)");
	$id = mysql_insert_id();
	if(!$result) {
		$error->setError("Error: Failed on insert");
		header("Location: /admin/audio/band/add");
		die();
	} else {
		$msgObj->setMsg("You added \"$name\" as a new band");
		header("Location: /admin/audio/band/$id");
		die();
	}
	
?>