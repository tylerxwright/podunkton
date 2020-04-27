<?php
	global $database;
	global $core;
	
	$bandID = $core->args[5];
	$result = $database->db_query("SELECT name FROM Bands WHERE bandID = $bandID");
	$row = mysqli_fetch_object($result);
	
?>

<h2>Adding an album to <?php echo $row->name; ?></h2>
<form enctype="multipart/form-data" action="/process/addAlbum" method="POST">
	<table border="0">
		<tr><td class="alabel">Album Name: </td><td><input type="input" name="aname" class="albumInput3" /></td></tr>
		<tr><td class="alabel">Release Date: </td><td><input type="input" name="date" class="albumInput3" /> <span style="font-size: 8pt;">(YYYY-MM-DD)</span></td></tr>
		<tr><td class="alabel">Producer: </td><td><input type="input" name="producer" class="albumInput3" /> <span style="font-size: 8pt;">(Real site username)</span></td></tr>
		<tr><td class="alabel">Munniez: </td><td><input type="input" name="munniez" class="albumInput3" /></td></tr>
		<tr><td class="alabel">Credits: </td><td><input type="input" name="credits" class="albumInput3" /></td></tr>
		<tr><td class="alabel">Studio: </td><td><input type="input" name="label" class="albumInput3" /></td></tr>
		<tr><td class="alabel">Cover Art: </td><td><input class="adminInput3" type="file" name="coverArt" /></td></tr>	
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" value="submit" /></td></tr>
	</table>
	<input type="hidden" name="bandID" value="<?php echo $bandID; ?>" />
</form>