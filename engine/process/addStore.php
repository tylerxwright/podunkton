<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterFile = "content/stores/counter.txt";
	
	$name = $_POST['name'];
	$tagline = $_POST['tagline'];
	$sort = $_POST['order'];
	
	if($name == ''){
		$error->setError("You must give this store a name");
		header("Location: /admin/store/add");
	}
	
	if($tagline == ''){
		$error->setError("You must give this store a tagline");
		header("Location: /admin/store/add");
	}
	
	if($sort == ""){
		$result = $database->db_query("SELECT MAX(storeID) as 'storeID' FROM Store");
		$row = mysqli_fetch_object($result);
		$sort = $row->storeID+1;
	}
	
	$safeName = str_replace(" ", "_", strtolower($name));
	
	if(!isset($error->errorMsg)){
		
		$counter;
		
		// Place png
		if($_FILES['banner']['type'] == "image/png"){
			$fh = fopen($counterFile, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$png_name = "banner_$counter.png";
			
			$png_path = "content/stores/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['banner']['name']);
			if(move_uploaded_file($_FILES['banner']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			}
		}
		
		// Place png
		if($_FILES['hotbox']['type'] == "application/x-shockwave-flash"){
			$png_name2 = "hotbox_$counter.swf";
			
			$png_path = "content/stores/".$png_name2;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['hotbox']['name']);
			if(move_uploaded_file($_FILES['hotbox']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			}
		}
		
		$result = $database->db_query("INSERT INTO Store (name, tagline, banner, hotbox, sort, safeName) VALUES ('$name', '$tagline', '$png_name', '$png_name2', $sort, '$safeName')");
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			$error->setError("You uploaded a store");
		}
		header("Location: /admin/store/add");
	}
?>