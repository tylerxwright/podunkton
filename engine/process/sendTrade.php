<?php
	global $session;
	global $database;
	global $error;
	global $msgObj;
	global $sysmsg;
	
	$purifier = new HTMLPurifier();
	
	$leftItems = array();
	$rightItems = array();
	$inventoryItems = array();
	
	$message = $_POST['message'];
	$munniez = abs($_POST['munniez']);
	$credits = abs($_POST['credits']);
	$pword = $_POST['pword'];
	$emailMe = $_POST['emailMe'];
	$tradeID = $purifier->purify($core->args[2]);
	$user = $session->user;
	
	$tradeCount = 1;
	
	// Are we even logged in?
	if(!user) {
		$error->setError("You must be logged in to trade");
		header("Location: /");
		die();
	}
	
	$resultTrade = $database->db_query("SELECT uht.finalized, uht.userID, uht.id, uht.phase, uht.email, uht.credits, uht.munniez, t.finalized as 'final' FROM Trades as t JOIN User_has_Trades as uht ON t.tradeID = uht.tradeID WHERE t.tradeID = $tradeID");
	$row1 = mysqli_fetch_object($resultTrade);
	$row2 = mysqli_fetch_object($resultTrade);
	
	if($row1->final == 1){
		$error->setError("Trade has already been completed");
		header("Location: /trade");
		die();
	}
	
	if($user == $row1->userID) {
		$userSide = "left";
		$myuhtID = $row1->id;
		$theiruhtID = $row2->id;
	} elseif($user == $row2->userID) {
		$userSide = "right";
		$myuhtID = $row2->id;
		$theiruhtID = $row1->id;
	} else {
		$userSide = "fail";
		$error->setError("I have no idea what happened");
		header("Location: /trade/".$tradeID);
		die();
	}
	
	$resultLeftUser = $database->db_query("SELECT userID, name, password, sex, munniez, credits FROM Users WHERE userID = ".$row1->userID);
	$rowLU = mysqli_fetch_object($resultLeftUser);
	
	$resultRightUser = $database->db_query("SELECT userID, name, password, sex, munniez, credits FROM Users WHERE userID = ".$row2->userID);
	$rowRU = mysqli_fetch_object($resultRightUser);
	
	if($userSide == "left") {
		$myID = $user;
		$mySex = $rowLU->sex;
		$myName = $rowLU->name;
		$myPassword = $rowLU->password;
		$myMunniez = $rowLU->munniez;
		$myCredits = $rowLU->credits;
		$myOfferedMunniez = $row1->munniez;
		$myOfferedCredits = $row1->credits;
		$myPhase = $row1->phase;
		$myFinalize = $row1->finalized;
		
		$theirID = $rowRU->userID;
		$theirSex = $rowRU->sex;
		$theirName = $rowRU->name;
		$theirPhase = $row2->phase;
		$theirMunniez = $rowRU->munniez;
		$theirCredits = $rowRU->credits;
		$theirFinalize = $row2->finalized;
		$theirOfferedMunniez = $row2->munniez;
		$theirOfferedCredits = $row2->credits;
	} else {
		$myID = $user;
		$mySex = $rowRU->sex;
		$myName = $rowRU->name;
		$myPassword = $rowRU->password;
		$myMunniez = $rowRU->munniez;
		$myCredits = $rowRU->credits;
		$myOfferedMunniez = $row2->munniez;
		$myOfferedCredits = $row2->credits;
		$myPhase = $row2->phase;
		$myFinalize = $row2->finalized;
		
		$theirID = $rowLU->userID;
		$theirSex = $rowLU->sex;
		$theirName = $rowLU->name;
		$theirPhase = $row1->phase;
		$theirMunniez = $rowLU->munniez;
		$theirCredits = $rowLU->credits;
		$theirFinalize = $row1->finalized;
		$theirOfferedMunniez = $row1->munniez;
		$theirOfferedCredits = $row1->credits;
	}
	
	if($myPassword != md5($pword)) {
		$error->setError("Your password is incorrect");
		header("Location: /trade/".$tradeID);
		die();
	}
	
	if($message != ""){
		$message = $purifier->purify($message);
		$message = addslashes($message);
	}
	
	if($munniez == "") {
		$munniez = 0;
	}
	
	if($credits == "") {
		$credits = 0;
	}
	
	if($_POST['finalize']) {
		$type = "finalize";
	} else {
		$type = "offer";
	}
	
	if($emailMe == "on") {
		$emailMe = 1;
	} else {
		$emailMe = 0;
	}
	
	// Finalize deal?
	if($type == "finalize") {
		if($theirFinalize == 1) {
			$result = $database->db_query("UPDATE User_has_Trades SET phase = 4 WHERE id = $myuhtID");
			$result = $database->db_query("UPDATE User_has_Trades SET phase = 4 WHERE id = $theiruhtID");
			
			if($theirOfferedMunniez < $myOfferedMunniez) {
				$myNewMunniez = $myMunniez;
				$theirNewMunniez = $theirMunniez + ($myOfferedMunniez - $theirOfferedMunniez);
			} elseif($theirOfferedMunniez > $myOfferedMunniez) {
				$myNewMunniez = $myMunniez + ($theirOfferedMunniez - $myOfferedMunniez);
				$theirNewMunniez = $theirMunniez;
			} else {
				$myNewMunniez = $myMunniez;
				$theirNewMunniez = $theirMunniez;
			}
			
			if($theirOfferedCredits < $myOfferedCredits) {
				$myNewCredits = $myCredits;
				$theirNewCredits = $theirCredits + ($myOfferedCredits - $theirOfferedCredits);
			} elseif($theirOfferedCredits > $myOfferedCredits) {
				$myNewCredits = $myCredits + ($theirOfferedCredits - $myOfferedCredits);
				$theirNewCredits = $theirCredits;
			} else {
				$myNewCredits = $myCredits;
				$theirNewCredits = $theirCredits;
			}
			
			// Exchange Currency
			$result = $database->db_query("UPDATE Users SET munniez = $myNewMunniez, credits = $myNewCredits WHERE userID = $myID");
			$result = $database->db_query("UPDATE Users SET munniez = $theirNewMunniez, credits = $theirNewCredits WHERE userID = $theirID");
			
			// Exchange Items to them
			$result = $database->db_query("SELECT uhi.id FROM Users_has_Items as uhi JOIN Trades_has_Items as thi ON uhi.id = thi.uiID JOIN User_has_Trades as uht ON thi.utID = uht.id WHERE uht.tradeID = $tradeID AND uhi.userID_FK = $myID");
			while($row = mysqli_fetch_object($result)) {
				$database->db_query("UPDATE Users_has_Items SET trading = 0, equipped = 0, userID_FK = $theirID WHERE trading = 1 AND id = ".$row->id);
			}
			
			// Exchange Items to me
			$result = $database->db_query("SELECT uhi.id FROM Users_has_Items as uhi JOIN Trades_has_Items as thi ON uhi.id = thi.uiID JOIN User_has_Trades as uht ON thi.utID = uht.id WHERE uht.tradeID = $tradeID AND uhi.userID_FK = $theirID");
			while($row = mysqli_fetch_object($result)) {
				$database->db_query("UPDATE Users_has_Items SET trading = 0, equipped = 0, userID_FK = $myID WHERE trading = 1 AND id = ".$row->id);
			}
			
			// Finalize trade
			$result = $database->db_query("UPDATE Trades SET finalized = 1, datecompleted = CURDATE() WHERE tradeID = $tradeID");
			
			$sysmsg->send($myID, "System: Trade Finalized", "Your trade with $theirName has been finalized");
			$sysmsg->send($theirID, "System: Trade Finalized", "Your trade with $myName has been finalized");
			
			$msgObj->setMsg("You have completed your trade!");
			header("Location: /trade");
			die();
		}
	}
	
	// Deal with munniez offered
	if($myOfferedMunniez == $munniez) {
		$newMunniez = $myMunniez;
		if($newMunniez > $myMunniez) {
			$error->setError("You don't have enough Munniez, you entered ".$newMunniez."mz and you have ".$myMunniez."mz");
			header("Location: /trade/".$tradeID);
			die();
		}
	} elseif($myOfferedMunniez > $munniez) {
		$newMunniez = $myMunniez + ($myOfferedMunniez-$munniez);
	} elseif($myOfferedMunniez < $munniez) {
		$newMunniez = $myMunniez - ($munniez - $myOfferedMunniez);
		if($newMunniez > $myMunniez) {
			$error->setError("You don't have enough Munniez, you entered ".$newMunniez."mz and you have ".$myMunniez."mz");
			header("Location: /trade/".$tradeID);
			die();
		}
	}
	
	// Deal with credits offered
	if($myOfferedCredits == $credits) {
		$newCredits = $myCredits;
		if($newCredits > $myCredits) {
			$error->setError("You don't have enough Credits, you entered ".$newCredits." credits and you have ".$credits." credits");
			header("Location: /trade/".$tradeID);
			die();
		}
	} elseif($myOfferedCredits > $credits) {
		$newCredits = $myCredits + ($myOfferedCredits-$credits);
	} elseif($myOfferedCredits < $credits) {
		$newCredits = $myCredits - ($credits - $myOfferedCredits);
		if($newCredits > $myCredits) {
			$error->setError("You don't have enough Credits, you entered ".$newCredits." credits and you have ".$credits." credits");
			header("Location: /trade/".$tradeID);
			die();
		}
	}
	
	if($munniez > 0) {
		$tradeCount++;
	}
	
	if($credits > 0) {
		$tradeCount++;
	}
	
	// Create left array of items
	$count = 0;
	while($itemID = $_POST['leftID'.$count]){
		$tradeCount++;
		array_push($leftItems, $itemID);
		$count++;
	}
	
	// Create right array of items
	$count = 0;
	while($itemID = $_POST['rightID'.$count]){
		$tradeCount++;
		array_push($rightItems, $itemID);
		$count++;
	}
	
	// Create inventory Array
	$count = 0;
	while($itemID = $_POST['myInventoryItem'.$count]){
		array_push($inventoryItems, $itemID);
		$count++;
	}
	
	if($tradeCount == 0){
		$error->setError("This trade has nothing being offered");
		header("Location: /trade/".$tradeID);
		die();
	}
	
	$result = $database->db_query("DELETE FROM Trades_has_Items WHERE utID = $myuhtID");
	
	// Update items
	foreach($leftItems as $item) {
		$result = $database->db_query("UPDATE Users_has_Items SET trading = 1 WHERE id=$item");
		$result = $database->db_query("INSERT INTO Trades_has_Items(uiID, utID) VALUES($item, $myuhtID)");
	}
	
	// Update inventory
	foreach($inventoryItems as $item) {
		$result = $database->db_query("UPDATE Users_has_Items SET trading = 0 WHERE id=$item");
	}
	
	if($type == "offer") {
		if($myPhase == 1) {
			$myPhase = 2;
		}
		if($theirPhase == 0) {
			$theirPhase = 1;
		} elseif($theirPhase == 2) {
			$myPhase = 3;
			$theirPhase = 3;
		}
		$result = $database->db_query("UPDATE User_has_Trades SET finalized = 0 WHERE id = $myuhtID");
	} elseif($type == "finalize") {
		$myPhase = 3;
		$theirPhase = 3;
		$result = $database->db_query("UPDATE User_has_Trades SET finalized = 1 WHERE id = $myuhtID");
	}
	
	$result = $database->db_query("UPDATE Users SET munniez=$newMunniez, credits=$newCredits WHERE userID = $user");
	$result = $database->db_query("UPDATE User_has_Trades SET munniez = $munniez, credits = $credits, email = $emailMe, phase = $myPhase WHERE id = $myuhtID");
	$result = $database->db_query("UPDATE User_has_Trades SET phase = $theirPhase, viewed = 1 WHERE id = $theiruhtID");
	
	// Take care of sending a message with a trade
	$result = $database->db_query("INSERT INTO Messages(subject, message) VALUES('Trade Message', '$message')");
	$mid = mysql_insert_id();
	$result = $database->db_query("INSERT INTO Inbox(reciever, sender, mid, isread, postdate) VALUES($theirID, $myID, $mid, 0, NOW())");
	$result = $database->db_query("INSERT INTO Sent(reciever, sender, mid, isread, postdate) VALUES($theirID, $myID, $mid, 0, NOW())");
	
	if($type == "offer") {
		$msgObj->setMsg("Your offer has been updated and sent");
	} else {
		$msgObj->setMsg("Your trade has been finalized. Waiting on confirmation");
	}
	header("Location: /trade/");
	
	
?>