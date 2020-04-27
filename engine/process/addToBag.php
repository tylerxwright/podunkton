<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$itemID = $core->args[2];
	
	$result = $database->db_query("SELECT i.name, iswf.itemswfID, s.slotID FROM Items as i JOIN Items_has_Slots as ihs ON ihs.itemID = i.itemID JOIN Slots as s ON ihs.slotID = s.slotID JOIN Items_has_ItemSWF as ihi ON ihs.id = ihi.ihsID JOIN ItemSWF as iswf ON ihi.itemswfID = iswf.itemswfID WHERE i.itemID = $itemID LIMIT 1");
	$row = mysqli_fetch_object($result);
	
	$name = $row->name;
	$swfID = $row->itemswfID;
	$slotID = $row->slotID;
	
	$query = sprintf("INSERT INTO Users_has_Items(userID_FK, itemID_FK, equipped, slotID, swfID, maxLevel, equipDate, equipDuration) VALUES(%d, %d, %d, %d, %d, %d, '%s', %d)", $session->user, $itemID, 0, $slotID, $swfID, 1, date("Y-m-d"), 0);
	$result = $database->db_query($query);
	
	$result = $database->db_query("SELECT i.itemID, iswf.itemswfID, s.slotID FROM Items as i JOIN Items_has_Slots as ihs ON ihs.itemID = i.itemID JOIN Slots as s ON ihs.slotID = s.slotID JOIN Items_has_ItemSWF as ihi ON ihs.id = ihi.ihsID JOIN ItemSWF as iswf ON ihi.itemswfID = iswf.itemswfID WHERE i.groups=$itemID");
	while($row = mysqli_fetch_object($result)){
		$query = sprintf("INSERT INTO Users_has_Items(userID_FK, itemID_FK, equipped, slotID, swfID, maxLevel, equipDate, equipDuration) VALUES(%d, %d, %d, %d, %d, %d, '%s', %d)", $session->user, $row->itemID, 0, $row->slotID, $row->itemswfID, 1, date("Y-m-d"), 0);
		$result2 = $database->db_query($query);
	}
	
	$error->setError($name." has been added to your bag!");
	header("Location: /admin/character/testpurchase");
?>
