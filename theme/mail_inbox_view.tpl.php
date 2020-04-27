<?php
	global $core;
	global $database;
	global $session;
	
	$result = $database->db_query("SELECT i.id, m.mid, m.subject, m.message, u.name, i.isread FROM Messages AS m JOIN Inbox AS i ON m.mid = i.mid JOIN Users as u ON i.sender = u.userID WHERE m.mid=".$core->args[2]." AND i.reciever=".$session->user);
	$row = mysqli_fetch_object($result);
	$num = mysqli_num_rows($result);
	
	if($row->isread == 0){
		$result = $database->db_query("UPDATE Inbox SET isread=1 WHERE id=".$row->id);
	}
?>
<?php
	if($num == 1){
?>
	<a href="/mail/inbox">Back to Inbox</a>
	<table border="0">
		<tr><td>From:</td><td><?php echo $row->name; ?></td></tr>
		<tr><td>Subject:</td><td><?php echo $row->subject; ?></td></tr>
		<tr><td valign="top">Message:</td><td><?php echo $row->message; ?></td></tr>
	</table>
<?php
	} else {
?>
	No Message
<?php
	}
?>