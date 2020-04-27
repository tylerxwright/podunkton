<?php
	global $database;
	global $session;
	global $core;
	global $podunkton;
	
	$toonID = $core->args[2];
	$badgeID = 0;
	
	$result = $database->db_query("UPDATE Toons SET views = views + 1 WHERE toonID = $toonID");
	
	switch($toonID){
		case 1: // Nice Day
			$badgeID = 21;
			break;
		case 2: // Ode
			$badgeID = 19;
			break;
		case 3: // Wrong Vagina
			$badgeID = 18;
			break;
		case 4: // MonkeySpank
			$badgeID = 20;
			break;
		case 5: // Baby
			$badgeID = 30;
			break;
		case 6: // Dooby
			$badgeID = 24;
			break;
		case 7: // Klunk Christmas
			$badgeID = 22;
			break;
		case 8: // Fanmail
			$badgeID = 25;
			break;
		case 9: // Christmas Horrors
			$badgeID = 23;
			break;
	}
	
	$result = $database->db_query("SELECT munniezOnView, name FROM Toons WHERE toonID = $toonID");
	$row = mysqli_fetch_object($result);
	$name = $row->name;
	$munniez = $row->munniezOnView;
	
	$msg = "watched $name";
	$podunkton->recentActivity($session->user, "gotBadge", $msg);
	
	if($podunkton->addBadgeReturn($badgeID) == 1){
		$result = $database->db_query("UPDATE Users SET munniez = munniez + $munniez WHERE userID = ".$session->user);
	}

?>