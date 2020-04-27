<?php
	global $database;
	global $session;
	global $core;
	global $sysmsg;
	
	$purifier = new HTMLPurifier();
	
	$itemID = $purifier->purify($core->args[2]);
	$type = $purifier->purify($core->args[3]);
	$user = $session->user;
	
	if($itemID == "") {
		echo "fail";
		die();
	}
	
	if($type == "") {
		echo "fail";
		die();
	}
	
	if($user) {
	
		$result = $database->db_query("SELECT pid, name, munniez, credits, type FROM Physical_Features WHERE pid = $itemID LIMIT 1");
		$rowItem = mysqli_fetch_object($result);
		
		$name = $rowItem->name;
		$credits = $rowItem->credits;
		$munniez = $rowItem->munniez;
		
		if($rowItem->type != $type) {
			echo "fail";
			die();
		}
		
		$result = $database->db_query("SELECT credits FROM Users WHERE userID=$user");
		$row = mysqli_fetch_object($result);
		
		if($row->credits >= $credits){
			
			$newCredits = $row->credits - $credits;
			
			if($type == "hair") {
				$query = sprintf("UPDATE Users SET hair=%d WHERE userID=%d", $itemID, $user);
			} else {
				$query = sprintf("UPDATE Users SET eyebrows=%d WHERE userID=%d", $itemID, $user);
			}
			$result = $database->db_query($query);
			
			$update = $database->db_query("UPDATE Users SET credits=$newCredits WHERE userID = $user");
			
			$sysmsg->send($user, "System: Barber Shop Purchase", "You purchased <b>".$rowItem->name."</b> for <b>".$rowItem->credits."</b> credits");
			
			echo $newCredits;
			
		} else {
			echo "fail";
		}
		
	} else {
		echo "fail";
	}
	
	die();
?>