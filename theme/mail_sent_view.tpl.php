<?php
	global $core;
	global $database;
	global $session;
	
	$result = $database->db_query("SELECT m.mid, m.subject, m.message, u.name FROM Messages AS m JOIN Inbox AS i ON m.mid = i.mid JOIN Users as u ON i.reciever = u.userID WHERE m.mid=".$core->args[2]." AND i.sender=".$session->user);
	$row = mysqli_fetch_object($result);
	$num = mysqli_num_rows($result);
?>
<?php
	if($num == 1){
?>
	<a href="/mail/sent">Back to Sent</a>
	<table border="0">
		<tr><td>To:</td><td><?php echo $row->name; ?></td></tr>
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