<?php
/**
 *	SystemMessage.php
 *	Sends system messages
 *
 *	Written by Tyler Wright
 * 	Last Modified: 7.5.2008
 */

class SystemMessage {
	
	function __construct() {
		
	}
	
	function send($userID, $subject, $message) {
		global $database;
		$message = addslashes($message);
		$result = $database->db_query("INSERT INTO Messages(subject, message) VALUES('$subject', '$message')");
		$mid = mysql_insert_id();
		$result = $database->db_query("INSERT INTO Inbox(reciever, sender, mid, isread, postdate) VALUES($userID, 1, $mid, 0, NOW())");
	}
	
}

$sysmsg = new SystemMessage;

?>
