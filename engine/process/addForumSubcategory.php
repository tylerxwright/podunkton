<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterFile = "content/forums/subcategoryIcons/counter.txt";
	$errorVal = 0;
	
	$categoryID = $_POST['categoryID'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$order = $_POST['order'];
	
	if($name == ''){
		$error->setError("You must give this subcategory a name");
		header("Location: /admin/forum/subcategory/add");
		$errorVal++;
	}
	
	if($description == ''){
		$error->setError("You must give this subcategory a description");
		header("Location: /admin/forum/subcategory/add");
		$errorVal++;
	}
	
	if($order == ""){
		$result = $database->db_query("SELECT MAX(sort) as 'sort' FROM Forum_Subcategory");
		$row = mysqli_fetch_object($result);
		$order = $row->sort+1;
	}
	
	if($_FILES['icon']['name'] == ""){
		$error->setError("You must upload an Icon");
		header("Location: /admin/forum/subcategory/add");
		$errorVal++;
	}
	
	$safeName = str_replace(" ", "_", $name);
	$strip = array("?", ",", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "+", "=", ".", ":", "<", ">", "{", "}", "[", "]", ";");
	$safeName = strtolower(str_replace($strip, "", $safeName));
	
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
			
			$png_path = "content/forums/subcategoryIcons/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['icon']['name']);
			if(move_uploaded_file($_FILES['icon']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			}
		}
		
		$result = $database->db_query("INSERT INTO Forum_Subcategory (categoryID, name, description, icon, sort, safeName) VALUES ($categoryID, '$name', '$description', '$png_name', $order, '$safeName')");
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			$error->setError("You uploaded a new subcategory");
		}
		header("Location: /admin/forum/subcategory");
	}
?>