<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$id = $core->args[2];
	$itemID = $core->args[3];
	
	$query = sprintf("DELETE FROM Users_has_Items WHERE id=%d", $id);
	$result = $database->db_query($query);
	
	$result = $database->db_query("SELECT itemID FROM Items WHERE groups=$itemID");
	while($row = mysqli_fetch_object($result)){
		$query = sprintf("DELETE FROM Users_has_Items WHERE itemID_FK=%d LIMIT 1", $row->itemID);
		$result2 = $database->db_query($query);
	}
	
	$error->setError("An Item has been removed to your bag!");
	header("Location: /admin/character/testpurchase");
?>
