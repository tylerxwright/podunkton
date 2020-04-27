<?php
	global $database;
	global $error;
	global $msgObj;

	$name  = $_POST['vname'];
	$order = $_POST['order'];	
	$type  = $_POST['type'];
	$munniezOnView = $_POST['munniezOnView'];

	//check for valid input	
	if($name == ""){
		$error->setError("You must give this vault item a name");
		header("Location: /admin/vault/add/".$type);
		die();
	}
	
	if($order == ""){
		$order = 10;
	}
	
	if($munniezOnView == ""){
		$munniezOnView = 0;
	}
		
	
	$ext = ".".substr(strrchr($_FILES['file']['name'], '.'), 1);
	$item_name = "vault_".time().$ext;
	$item_path = "content/vault/".$item_name;	
	
	$tmp_path = "tmp/";
	$tmp_path .= basename($_FILES['file']['name']);
	if(move_uploaded_file($_FILES['file']['tmp_name'], $tmp_path)) {
		if(!rename($tmp_path, $item_path)) {
			$error->setError("Error on moving the file!");
			header("Location: /admin/vault/add/".$type);
			die();
		}
		chmod($item_path, 0777);
	} else {
		$error->setError("Error on moving vault item!");
		header("Location: /admin/vault/add/".$type);
		die();
	}

	$fileSize = sprintf("%01.1f", filesize($item_path)/1000000);

	$result = $database->db_query("INSERT INTO Vault(name, sortOrder, type, file, dateAdded, munniezOnView, fileSize) VALUES('$name', $order, '$type', '$item_name', NOW(), $munniezOnView, $fileSize)");
	if(!$result) {
		$error->setError("Error: Insert failed!");
		header("Location: /admin/vault/add/".$type);
		die();
	}

	$msgObj->setMsg("You added \"$name\" as a new vault item");
	header("Location: /admin/vault");
	die();

?>
