<?php
	global $core;
	global $session;
	global $database;
	global $error;
	global $msgObj;
	
	$purifier = new HTMLPurifier();
	
	$c = 1;
	$user = $session->user;
	$type = $purifier->purify($core->args[2]);
	
	while($mid = $_POST['mid'.$c]) {
		
		if($_POST['c'.$c] == "on") {
		
			$resultI = $database->db_query("SELECT id, sender, reciever FROM Inbox WHERE mid = $mid");
			$numI = mysqli_num_rows($resultI);
			$rowI = mysqli_fetch_object($resultI);
			
			$resultS = $database->db_query("SELECT id, sender, reciever FROM Sent WHERE mid = $mid");
			$numS = mysqli_num_rows($resultS);
			$rowS = mysqli_fetch_object($resultS);
			
			if($rowI->sender == $user AND $rowI->reciever == $user) {
				$result = $database->db_query("DELETE FROM Sent WHERE mid = $mid");
				$result = $database->db_query("DELETE FROM Inbox WHERE mid = $mid");
				$result = $database->db_query("DELETE FROM Messages WHERE mid = $mid");
			} else {
			
				if($numI == 1){
					if($rowI->sender == $user) {
						$result = $database->db_query("DELETE FROM Sent WHERE mid = $mid");
					} elseif($rowI->reciever == $user) {
						$result = $database->db_query("DELETE FROM Inbox WHERE mid = $mid");
					} else {
						$error->setError("You can only delete your own messages...cheater");
						header("Location: /mail");
						die();
					}
					$count++;
				}
				
				if($numS == 1){
					if($rowS->sender == $user) {
						$result = $database->db_query("DELETE FROM Sent WHERE mid = $mid");
					} elseif($rowS->reciever == $user) {
						$result = $database->db_query("DELETE FROM Inbox WHERE mid = $mid");
					} else {
						$error->setError("You can only delete your own messages...cheater");
						header("Location: /mail");
						die();
					}
					$count++;
				}
				
				if($count == 1) {
					$result = $database->db_query("DELETE FROM Messages WHERE mid = $mid");
				}
				
			}
		}
		$c++;
		
	}
	
	$msgObj->setMsg("You deleted a message");
	if($type == "inbox") {
		header("Location: /mail");
	} else {
		header("Location: /mail/sent");
	}
	
?>