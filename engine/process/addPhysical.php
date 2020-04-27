<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterFile = "characterBuilder/items/counter.txt";
	$counterFile2 = "characterBuilder/images/counter.txt";
	
	$swfArr = array();
	
	$name = $_POST['name'];
	$desc = $_POST['description'];
	$type = $_POST['type'];
	$color = $_POST['color'];
	$sex = $_POST['sex'];
	$munniez = $_POST['munniez'];
	$credits = $_POST['credits'];
	
	if($name == ''){
		$error->setError("You must give this item a name");
		header("Location: /admin/character/addPhysical");
		die();
	}
	
	if($desc == ''){
		$error->setError("You must give this item a description");
		header("Location: /admin/character/addPhysical");
		die();
	}
	
	if($munniez == ''){
		$error->setError("You must give this item munniez");
		header("Location: /admin/character/addPhysical");
		die();
	}
	
	if($credits == ''){
		$error->setError("You must give this item credits");
		header("Location: /admin/character/addPhysical");
		die();
	}
	
	if($_FILES['s1']['name'] == ''){
		$error->setError("You must upload an swf for the first slot");
		header("Location: /admin/character/addPhysical");
		die();
	}
	
	if($_FILES['png']['name'] == ''){
		$error->setError("You must upload a PNG file");
		header("Location: /admin/character/addPhysical");
		die();
	}
	
	if(!isset($error->errorMsg)){
		
		if($type == "hair"){
			$slot1 = "head.hair";
			$slot2 = "backhead.hair_back";
		} elseif($type == "eyes") {
			$slot1 = "head.eyes";
			$slot2 = "none";
		} elseif($type == "eyebrows"){
			$slot1 = "head.eyebrow_left";
			$slot2 = "head.eyebrow_right";
		}
		
		// Check for number of uploaded
		if($_FILES['s2']['name'] == ''){
			$numSwf = 1;
		} else {
			$numSwf = 2;
		}
		
		// Place png
		if($_FILES['png']['type'] == "image/png"){
			$fh = fopen($counterFile2, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile2, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$png_name = "physicalPNG_$counter.png";
			
			$png_path = "characterBuilder/images/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['png']['name']);
			if(move_uploaded_file($_FILES['png']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			}
		} else {
			$error->setError("There was a snake in my boot!");
			header("Location: /admin/character/addPhysical");
			die();
			//break;
		}
		
		// Place swf
		for($i=1; $i<=$numSwf; $i++){
			if($_FILES['s'.$i]['type'] == "application/x-shockwave-flash"){
				
				$fh = fopen($counterFile, "r");
				$counter = fread($fh, 50);
				fclose($fh);
				
				$fh = fopen($counterFile, "w+");
				fwrite($fh, $counter+1);
				fclose($fh);
				
				$swf_name = "physical_$counter.swf";
				$swf_path = "characterBuilder/items/".$swf_name;
				
				$swfArr[$i] = $swf_name;
				
				$tmp_path = "tmp/";
				$tmp_path .= basename($_FILES['s'.$i]['name']);
				if(move_uploaded_file($_FILES['s'.$i]['tmp_name'], $tmp_path)) {
					rename($tmp_path, $swf_path);
					chmod($swf_path, 0777);
				}
				
			} else {
				$error->setError("There was a snake in my boot!");
				header("Location: /admin/character/addPhysical");
				die();
				//break;
			}
		}
		
		$swf1 = $swfArr[1];
		$swf2 = $swfArr[2];
		
		$result = $database->db_query("INSERT INTO Physical_Features (name, description, png, color, slot1, swf1, slot2, swf2, type, sex, munniez, credits) VALUES ('$name', '$desc', '$png_name', '$color', '$slot1', '$swf1', '$slot2', '$swf2', '$type', '$sex', $munniez, $credits)");
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			$error->setError("You uploaded skin number $nextNum");
		}
		header("Location: /admin/character/addPhysical");
	}
?>