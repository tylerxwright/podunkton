<?php
	global $session;
	global $database;
	global $core;
	global $msgObj;
	global $sysmsg;
	
	$purifier = new HTMLPurifier();
	
	$tradeID = $purifier->purify($core->args[2]);
	$user = $session->user;
	
	$result = $database->db_query("SELECT u.name, ut.phase, ut.userID, ut.id FROM User_has_Trades as ut JOIN Users as u ON ut.userID = u.userID WHERE tradeID = $tradeID");
	$row1 = mysqli_fetch_object($result);
	$row2 = mysqli_fetch_object($result);
	
	if($row1->userID == $user) {
		$myID = $row1->userID;
		$myutID = $row1->id;
		$myName = $row1->name;
		
		$theirID = $row2->userID;
		$theirPhase = $row2->phase;
		$theirutID = $row2->id;
		$theirName = $row2->name;
	} else {
		$myID = $row2->userID;
		$myutID = $row2->id;
		$myName = $row2->name;
		
		$theirID = $row1->userID;
		$theirPhase = $row1->phase;
		$theirutID = $row1->id;
		$theirName = $row1->name;
	}
	
	$result = $database->db_query("UPDATE Users SET munniez = munniez+(SELECT munniez FROM User_has_Trades WHERE tradeID = $tradeID AND userID = $myID), credits = credits+(SELECT credits FROM User_has_Trades WHERE tradeID = $tradeID AND userID = $myID) WHERE userID = $myID");
	$result = $database->db_query("UPDATE Users SET munniez = munniez+(SELECT munniez FROM User_has_Trades WHERE tradeID = $tradeID AND userID = $theirID), credits = credits+(SELECT credits FROM User_has_Trades WHERE tradeID = $tradeID AND userID = $theirID) WHERE userID = $theirID");
	
	$result = $database->db_query("SELECT uiID FROM Trades_has_Items WHERE utID = $myutID");
	while($row = mysqli_fetch_object($result)) {
		$result2 = $database->db_query("UPDATE Users_has_Items SET trading = 0 WHERE id = ".$row->uiID);
	}
	
	$result = $database->db_query("SELECT uiID FROM Trades_has_Items WHERE utID = $theirutID");
	while($row = mysqli_fetch_object($result)) {
		$result2 = $database->db_query("UPDATE Users_has_Items SET trading = 0 WHERE id = ".$row->uiID);
	}
	
	$result = $database->db_query("DELETE FROM Trades WHERE tradeID = $tradeID");
	$result = $database->db_query("DELETE FROM User_has_Trades WHERE tradeID = $tradeID");
	$result = $database->db_query("DELETE FROM Trades_has_Items WHERE utID = $myutID");
	$result = $database->db_query("DELETE FROM Trades_has_Items WHERE utID = $theirutID");
	
	$sysmsg->send($user, "System: Trade Canceled", "Your trade with $theirName has been canceled");
	
	if($theirPhase > 0) {
		$sysmsg->send($theirID, "System: Trade Canceled", "Your trade with $myName has been canceled");
	}
	
	$msgObj->setMsg("You have canceled a trade");
	header("Location: /trade");
	die();
	
?>