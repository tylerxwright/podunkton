<?php
	global $database;
	global $error;
	global $core;
	global $session;
	// jon start
	// send message from here
	$messageID;
	$message = $_POST['message'];
	$recieverID = $_POST['recievers'];
	$senderID = $session->user;
	$subject = $_POST['subject'];
	
	
	//insert message into the message table
	$result = $database->db_query("INSERT INTO Messages (subject,message) VALUES ('$subject','$message')");
	//get last set mid and put it in messageID
	$messageID = mysql_insert_id();
	//put information into the inbox database
	$result = $database->db_query("INSERT INTO Inbox (reciever, sender, mid, postdate) VALUES ($recieverID,$senderID,$messageID,NOW())");
	//now put it into Sent
	$result = $database->db_query("INSERT INTO Sent (reciever,sender,mid,postdate) VALUES($recieverID,$senderID,$messageID,NOW())");
				
	
	
	if (!$result)
	{
		$error->setError("There was a snake in my boot!");
	}
	else
	{
		$error->setError("You sent the message to this guy");
	}
	header("Location: /mail");
	//jon end
?>