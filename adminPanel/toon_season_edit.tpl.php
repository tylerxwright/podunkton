<?php
	global $database;
	
	$seasonID = $core->args[4];
	$result = $database->db_query("SELECT * FROM Toon_Seasons WHERE seasonID = $seasonID");
	$row = mysqli_fetch_object($result);
?>
<b>Editting Toon Season <?php echo $row->name; ?></b><br/>
<form enctype="multipart/form-data" action="/process/editToonSeason" method="POST">
	<table>
		<tr><td>Name:</td><td><input type="text" name="sname" value="<?php echo $row->name; ?>"/></td></tr>
		<tr><td>Order:</td><td><input type="text" name="order" value="<?php echo $row->seasonOrder; ?>"/></td></tr>
		<tr><td>Blue Picture:</td><td><input type="file" name="picture" /></td></tr>
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td>Hover Picture:</td><td><input type="file" name="hpicture" /></td></tr>
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td></td><td><br/><input type="submit" value="Update Season" /></td></tr>
	</table>
	<input type="hidden" name="seasonID" value="<?php echo $seasonID; ?>" />
</form>