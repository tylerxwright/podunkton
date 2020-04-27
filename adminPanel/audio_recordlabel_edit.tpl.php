<?php
	global $database;
	global $core;
	
	$labelID = $core->args[4];
	
	$result = $database->db_query("SELECT * FROM Record_Labels WHERE labelID = $labelID");
	$row = mysqli_fetch_object($result);
?>
<h2>Editting the Record Label "<?php echo $row->name; ?>"</h2>
<form action="/process/editRecordLabel" method="POST">
	<table border="0">
		<tr><td>Name: </td><td><input type="text" class="adminInput" name="gname" value="<?php echo $row->name; ?>"/></td></tr>
		<tr><td></td><td align="right"><input type="submit" name="name" value="update" /></td></tr>
	</table>
	<input type="hidden" name="labelID" value="<?php echo $labelID; ?>" />
</form>