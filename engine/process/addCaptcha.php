<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterFile = "content/captchas/counter.txt";
	
	$text = $_POST['text'];
	
	if($text == ''){
		$error->setError("You must give this captcha text");
		header("Location: /admin/captchas/add");
	}
	
	if(!isset($error->errorMsg)){
		
		// Place png
		if($_FILES['captcha']['type'] == "image/png"){
			$fh = fopen($counterFile, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$png_name = "captcha_$counter.png";
			
			$png_path = "content/captchas/".$png_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['captcha']['name']);
			if(move_uploaded_file($_FILES['captcha']['tmp_name'], $tmp_path)) {
				rename($tmp_path, $png_path);
				chmod($png_path, 0777);
			}
		}
		
		$result = $database->db_query("INSERT INTO Captchas (code, captcha) VALUES ('$text', '$png_name')");
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			$error->setError("You uploaded a captcha");
		}
		header("Location: /admin/captchas/add");
	}
?>