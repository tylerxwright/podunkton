<?php
	global $core;
	global $database;
	
	$badgeID = $core->args[3];
	$result = $database->db_query("SELECT * FROM Badges WHERE badgeID = $badgeID");
	$row = mysqli_fetch_object($result);
	
?>
<h2>Editting the badge <?php echo $row->name; ?></h2>
<form enctype="multipart/form-data" action="/process/editBadge" method="POST">
	<table border="0" width="100%">
		<tr><td>Name: </td><td><input class="adminInput2" name="name" value="<?php echo $row->name; ?>"/></td></tr>
		<tr><td>Icon:</td><td><input type="file" name="icon" /> (33x33)</td></tr>
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current icon)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td valign="top">Description:</td><td><textarea cols="40" rows="5" name="description"><?php echo $row->description; ?></textarea></td></tr>
		<tr><td valign="top">Message:</td><td><textarea cols="40" rows="5" name="message"><?php echo $row->message; ?></textarea></td></tr>
		<tr><td></td><td><input type="submit" value="Update Badge" /></td></tr>
	</table>
	<input type="hidden" name="badgeID" value="<?php echo $row->badgeID; ?>" />
</form>
