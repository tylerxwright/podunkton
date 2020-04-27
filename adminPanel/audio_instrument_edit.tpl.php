<?php
	global $database;
	global $core;
	
	$instrumentID = $core->args[4];
	
	$result = $database->db_query("SELECT * FROM Instruments WHERE instrumentID = $instrumentID");
	$row = mysqli_fetch_object($result);
?>
<h2>Editting the Instrument "<?php echo $row->name; ?>"</h2>
<form action="/process/editInstrument" method="POST">
	<table border="0">
		<tr><td>Name: </td><td><input type="text" class="adminInput" name="gname" value="<?php echo $row->name; ?>"/></td></tr>
		<tr><td></td><td align="right"><input type="submit" name="name" value="update" /></td></tr>
	</table>
	<input type="hidden" name="instrumentID" value="<?php echo $instrumentID; ?>" />
</form>