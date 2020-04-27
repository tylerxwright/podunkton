<?php
	global $database;
	global $core;
	
	$mpaaID = $core->args[4];
	$result = $database->db_query("SELECT * FROM MPAA_Ratings WHERE mpaaID = $mpaaID");
	$row = mysqli_fetch_object($result);
?>
<b>Editting an MPAA Rating</b><br/>
<form enctype="multipart/form-data" action="/process/editMPAA" method="POST">
	<table>
		<tr><td>Name:</td><td><input type="text" name="mname" value="<?php echo $row->name; ?>" /></td></tr>
		<tr><td>Line 1:</td><td><input type="text" name="line1" value="<?php echo $row->line1; ?>" /></td></tr>
		<tr><td>Line 2:</td><td><input type="text" name="line2" value="<?php echo $row->line2; ?>" /></td></tr>
		<tr><td>Line 3:</td><td><input type="text" name="line3" value="<?php echo $row->line3; ?>" /></td></tr>
		<tr><td>Icon:</td><td><input type="file" name="icon" /> <span style="font-size: 8pt;">(47x63)</span></td></tr>
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td></td><td><br/><input type="submit" value="Add MPAA Rating" /></td></tr>
	</table>
	<input type="hidden" name="mpaaID" value="<?php echo $row->mpaaID; ?>" />
</form>