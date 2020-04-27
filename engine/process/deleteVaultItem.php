<?php
	global $database;
	global $core;
	global $error;
	global $msgObj;
	
	$vaultID = $core->args[2];
	
	$result = $database->db_query("SELECT name, file FROM Vault WHERE vaultID = $vaultID");
	$row = mysqli_fetch_object($result);
	
	$result = $database->db_query("DELETE FROM Vault WHERE vaultID = $vaultID");
	if(!$result) {
		$error->setError("Error: Vault Delete Failed!");
		header("Location: /admin/vault");
		die();
	}
	
	if(!unlink("content/vault/".$row->file)) {
		$error->setError("Error: SWF file could not be deleted.");
		header("Location: /admin/toon");
		die();
	}
	
	$msgObj->setMsg("You deleted a the vault item ".$row->name);
	header("Location: /admin/vault");
	die();
	
?>