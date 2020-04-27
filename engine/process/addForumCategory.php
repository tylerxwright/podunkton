<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterFile = "content/forums/categoryIcons/counter.txt";
	$errorVal = 0;
	
	$name = $_POST['name'];
	$color = $_POST['color'];
	$order = $_POST['order'];
	
	if($name == ''){
		$error->setError("You must give this category a name");
		header("Location: /admin/forum/category/add");
		$errorVal++;
	}
	
	if($order == ""){
		$result = $database->db_query("SELECT MAX(sort) as 'sort' FROM Forum_Category");
		$row = mysqli_fetch_object($result);
		$order = $row->sort+1;
	}
	
	if($_FILES['icon']['name'] == ""){
		$error->setError("You must upload an Icon");
		header("Location: /admin/forum/category/add");
		$errorVal++;
	}
	
	if($errorVal == 0){
		
		// Place png
		if($_FILES['icon']['type'] == "image/png"){
			$fh = fopen($counterFile, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$png_name = "icon_$counter.png";
			
			$png_path = "content/forums/categoryIcons/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			}
		}
		
		$result = $database->db_query("INSERT INTO Forum_Category (name, color, icon, sort) VALUES ('$name', '$color', '$png_name', $order)");
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			$error->setError("You uploaded a new category");
		}
		header("Location: /admin/forum/category");
	}
?>