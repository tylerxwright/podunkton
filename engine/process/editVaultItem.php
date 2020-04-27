<?php
	global $database;
	global $error;
	global $msgObj;
	
	$vaultID = $_POST['vaultID'];
	$name  = $_POST['vname'];
	$order = $_POST['order'];	
	$type  = $_POST['type'];
	$munniezOnView = $_POST['munniezOnView'];
	$fileSize = 0;

	//check for valid input	
	if($name == ""){
		$error->setError("You must give this vault item a name");
		header("Location: /admin/vault/edit/$vaultID");
		die();
	}
	
	if($order == ""){
		$order = 10;
	}
	
	if($munniezOnView == "") {
		$munniezOnView = 0;
	}

	
	if($_FILES['file']['name'] != ""){
		$result = $database->db_query("SELECT file FROM Vault WHERE vaultID = $vaultID");
		$row = mysqli_fetch_object($result);
		
		$item_name = $row->file;
		$item_path = "content/vault/".$item_name;	
		
		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['file']['name']);
		if(move_uploaded_file($_FILES['file']['tmp_name'], $tmp_path)) {
			rename($tmp_path, $item_path);
			chmod($item_path, 0777);
			$fileSize = sprintf("%01.1f", filesize($item_path)/1000000);
		} else {
			$error->setError("Error on moving vault item!");
			header("Location: /admin/vault/edit/$vaultID");
			die();
		}
	}
	
	if($fileSize == 0) {
		$result = $database->db_query("UPDATE Vault SET name='$name', type='$type', sortOrder='$order', munniezOnView=$munniezOnView WHERE vaultID=$vaultID");
	} else {
		$result = $database->db_query("UPDATE Vault SET name='$name', type='$type', sortOrder='$order', munniezOnView=$munniezOnView, fileSize='$fileSize' WHERE vaultID=$vaultID");
	}
	if(!$result) {
		$error->setError("Error: Update failed!");
		header("Location: /admin/vault/edit/$vaultID");
		die();
	}

	$msgObj->setMsg("You updated \"$name\"");
	header("Location: /admin/vault");
	die();
	
?>
