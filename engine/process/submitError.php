<?php
	global $core;
	global $database;
	global $msgObj;
	global $error;
	global $session;
	
	$user = $session->user;
	
	if($user) {
		$subject = cleanInput($_POST['subject']);
		$message = nl2br(addslashes($_POST['message']));
		
		$result = $database->db_query("INSERT INTO Error_Reports(userID, subject, message, postdate) VALUES($user, '$subject', '$message', NOW())");
		
		$msgObj->setMsg("Error Report has been sent");
		header("Location: /");
		
	} else {
		$error->setError("You must be logged in to post error reports");
		header("Location: /");
	}
	
	function cleanInput($text) {
		$purifier = new HTMLPurifier();
		$text = $purifier->purify($text);
		$text = addslashes($text);
		return $text;
	}
?>