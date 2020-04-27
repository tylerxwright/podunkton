<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterFile = "characterBuilder/items/counter.txt";
	$swfArr = array();
	
	$nextNum = $_POST['nextNum'];
	$sex = $_POST['sex'];
	
	for($i=1; $i<=7; $i++){
		if($_FILES['s'.$i]['type'] == "application/x-shockwave-flash"){
			
			$fh = fopen($counterFile, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$swf_name = "skin_$counter.swf";
			$swf_path = "characterBuilder/items/".$swf_name;
			
			$swfArr[$i] = $swf_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['s'.$i]['name']);
			if(move_uploaded_file($_FILES['s'.$i]['tmp_name'], $tmp_path)) {
				rename($tmp_path, $swf_path);
				chmod($swf_path, 0777);
			}
			
		} else {
			break;
		}
		
		$head = $swfArr[1];
		$forearm1= $swfArr[2];
		$arm1 = $swfArr[3];
		$body = $swfArr[4];
		$forearm2 = $swfArr[5];
		$arm2 = $swfArr[6];
		$legs = $swfArr[7];
		
		$result = $database->db_query("INSERT INTO Skins (skinNum, head, forearm1, arm1, body, forearm2, arm2, legs, sex) VALUES ($nextNum, '$head', '$forearm1', '$arm1', '$body', '$forearm2', '$arm2', '$legs', '$sex')");
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			$error->setError("You uploaded skin number $nextNum");
		}
		header("Location: /admin/character");
	}
?>