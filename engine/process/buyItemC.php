<?php
	
	global $database;
	global $session;
	global $core;
	global $sysmsg;
	global $podunkton;
	
	$purifier = new HTMLPurifier();
	
	$itemID = $purifier->purify($core->args[2]);
	$user = $session->user;
	
	if($user) {
	
		$result = $database->db_query("SELECT i.name, iswf.itemswfID, s.slotID, i.credits FROM Items as i JOIN Items_has_Slots as ihs ON ihs.itemID = i.itemID JOIN Slots as s ON ihs.slotID = s.slotID JOIN Items_has_ItemSWF as ihi ON ihs.id = ihi.ihsID JOIN ItemSWF as iswf ON ihi.itemswfID = iswf.itemswfID WHERE i.itemID = $itemID LIMIT 1");
		$rowItem = mysqli_fetch_object($result);
		
		$name = $rowItem->name;
		$swfID = $rowItem->itemswfID;
		$slotID = $rowItem->slotID;
		$credits = $rowItem->credits;
		
		$result = $database->db_query("SELECT credits FROM Users WHERE userID=$user");
		$row = mysqli_fetch_object($result);
		
		if($row->credits >= $credits){
			
			$newCredits = $row->credits - $credits;
			
			$query = sprintf("INSERT INTO Users_has_Items(userID_FK, itemID_FK, equipped, slotID, swfID, maxLevel, equipDate, equipDuration) VALUES(%d, %d, %d, %d, %d, %d, '%s', %d)", $user, $itemID, 0, $slotID, $swfID, 1, date("Y-m-d"), 0);
			$result = $database->db_query($query);
			
			$result = $database->db_query("SELECT i.itemID, iswf.itemswfID, s.slotID FROM Items as i JOIN Items_has_Slots as ihs ON ihs.itemID = i.itemID JOIN Slots as s ON ihs.slotID = s.slotID JOIN Items_has_ItemSWF as ihi ON ihs.id = ihi.ihsID JOIN ItemSWF as iswf ON ihi.itemswfID = iswf.itemswfID WHERE i.groups=$itemID");
			while($row2 = mysqli_fetch_object($result)){
				$query = sprintf("INSERT INTO Users_has_Items(userID_FK, itemID_FK, equipped, slotID, swfID, maxLevel, equipDate, equipDuration) VALUES(%d, %d, %d, %d, %d, %d, '%s', %d)", $user, $row2->itemID, 0, $row2->slotID, $row2->itemswfID, 1, date("Y-m-d"), 0);
				$result2 = $database->db_query($query);
			}
			
			$update = $database->db_query("UPDATE Users SET credits=$newCredits WHERE userID = $user");
			
			$sysmsg->send($user, "System: Item Purchase", "You purchased <b>".$rowItem->name."</b> for <b>".$rowItem->credits."</b> credits");
			
			$msg = "bought $name";
			$podunkton->recentActivity($session->user, "itemPurchase", $msg);
			
			echo $newCredits;
			
		} else {
			echo "fail";
		}
		
	} else {
		echo "fail";
	}
	
	die();
?>
