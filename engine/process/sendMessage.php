<?php
	include_once("engine/Converter.php");

	global $database;
	global $error;
	global $msgObj;
	global $core;
	global $session;
	
	$purifier = new HTMLPurifier();
	
	$toArr = array();
	
	if($core->args[2] == "pm") {
		//echo $core->args[3];
		die();
	} else {
		$inMid = $core->args[2];
	}
	
	$to = strip_tags($_POST['to']);
	$subject = strip_tags($_POST['subject']);
	$message = $_POST['message'];
	$user = $session->user;
	
	$result = $database->db_query("SELECT userID FROM Users WHERE name = '$to'");
	$count = mysqli_num_rows($result);
	if($count == 0) {
		$error->setError("The user your sending this message to doesn't exist.");
		header("Location: /mail/compose");
		die();
	}
	$row = mysqli_fetch_object($result);
	$reciever = $row->userID;
	
	if($subject == "") {
		$error->setError("You must give your message a subject");
		header("Location: /mail/compose");
		die();
	}
	
	if($message == "") { // Need to check length as well
		$error->setError("You must have something to say");
		header("Location: /mail/compose");
		die();
	}
	
	$clean_html = $purifier->purify($message);
	$clean_html = $converter->convert($clean_html, "");
	$clean_html = addslashes($clean_html);
	$clean_html = nl2br($clean_html);
	
	
	$result = $database->db_query("INSERT INTO Messages(subject, message) VALUES('$subject', '$clean_html')");
	$mid = mysql_insert_id();
	$result = $database->db_query("INSERT INTO Inbox(reciever, sender, mid, isread, postdate) VALUES($reciever, $user, $mid, 0, NOW())");
	$result = $database->db_query("INSERT INTO Sent(reciever, sender, mid, isread, postdate) VALUES($reciever, $user, $mid, 0, NOW())");
	
	if($inMid) {
		$result = $database->db_query("SELECT sender, reciever FROM Inbox WHERE mid = $inMid");
		$row1 = mysqli_fetch_object($result);
		
		if($row1->sender == $user) {
			$type = "Sent";
		} else {
			$type = "Inbox";
		}
		
		$result = $database->db_query("UPDATE ".$type." SET replied = 1 wHERE mid = $inMid");
	}
	
	if (!$result)
	{
		$error->setError("There was a snake in my boot!");
		header("Location: /mail/compose");
	}
	else
	{
		//$updateU = $database->db_query("UPDATE Users SET experience = experience+".EXP_PER_POST." WHERE userID=$user");
		//$msgObj->setMsg("You got ".EXP_PER_TOPIC." experience points for creating a new topic!");
		$msgObj->setMsg("You sent a message to $to");
		header("Location: /mail");
	}
	
?>