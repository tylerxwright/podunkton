<?php
	
	/*for($c = 31; $c<=62; $c++){
		$result = $database->db_query("SELECT sex FROM Users WHERE userID = $c");
		$row = mysqli_fetch_object($result);
		if($row->sex == "m"){
			$query = sprintf("INSERT INTO Users_has_Items(userID_FK, itemID_FK, equipped, slotID, swfID, maxLevel, equipDate, equipDuration) VALUES(%d, %d, %d, %d, %d, %d, '%s', %d)", $c, 387, 1, 5, 415, 1, date("Y-m-d"), 0);
		} else {
			$query = sprintf("INSERT INTO Users_has_Items(userID_FK, itemID_FK, equipped, slotID, swfID, maxLevel, equipDate, equipDuration) VALUES(%d, %d, %d, %d, %d, %d, '%s', %d)", $c, 390, 1, 5, 418, 1, date("Y-m-d"), 0);
		}
		$resultCheck = mysqli_query($database->connection, $query);
	}*/
?>