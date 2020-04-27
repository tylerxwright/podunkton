<?php
	global $database;
	global $core;
	
	$albumID = $core->args[6];
	if($albumID > 0) {
		$result = $database->db_query("SELECT name FROM Albums WHERE albumID = $albumID");
		$row = mysqli_fetch_object($result);
?>
<h2>Adding a song to <?php echo $row->name; ?></h2>	
<form enctype="multipart/form-data" action="/process/addSong" method="POST">
	<table border="0">
		<tr><td>Name: </td><td><input type="text" name="sname" class="adminInput" /></td><td></td></tr>
		<tr><td>Track: </td><td><input type="text" name="track" class="adminInput" /></td><td></td></tr>
		<tr><td>Length: </td><td><input type="text" name="length" class="adminInput" /></td><td><span style="font-size: 8pt">(In seconds)</span></td></tr>
		<tr><td>Munniez: </td><td><input type="text" name="munniez" class="adminInput" /></td><td></td></tr>
		<tr><td>Credits: </td><td><input type="text" name="credits" class="adminInput" /></td><td></td></tr>
		<tr><td>Song: </td><td><input type="file" name="song" class="adminInput" /></td><td><span style="font-size: 8pt">(.mp3)</span></td></tr>
		<tr><td colspan="3" align="center"><div style="width: 2px; height: 40px;"></div></td></tr>
		<tr><td colspan="3" align="center"><input type="submit" value="Add this song" /></td></tr>
	</table>
	<input type="hidden" name="albumID" value="<?php echo $albumID; ?>" />
</form>
<?php } else { ?>
<h2>Error: AlbumID not set</h2>
<?php } ?>