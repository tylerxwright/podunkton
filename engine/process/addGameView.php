<?php
	global $database;
	global $session;
	global $core;
	global $podunkton;
	
	$gameID = $core->args[2];
	$badgeID = 0;
	
	$result = $database->db_query("UPDATE Games SET views = views + 1 WHERE gameID = $gameID");
	
	switch($gameID){
		case 1: // Drunk
			$badgeID = 26;
			break;
		case 2: // IM Attack
			$badgeID = 27;
			break;
		case 3: // Splooge
			$badgeID = 28;
			break;
		case 4: // Douche
			$badgeID = 29;
			break;
	}
	
	$result = $database->db_query("SELECT munniezOnView, name FROM Games WHERE gameID = $gameID");
	$row = mysqli_fetch_object($result);
	$name = $row->name;
	$munniez = $row->munniezOnView;
	
	$msg = "played $name";
	$podunkton->recentActivity($session->user, "gotBadge", $msg);
	
	if($podunkton->addBadgeReturn($badgeID) == 1){
		$result = $database->db_query("UPDATE Users SET munniez = munniez + $munniez WHERE userID = ".$session->user);
	}

?>