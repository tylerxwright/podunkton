<?php
	global $database;
	global $core;
	
	$albumID = $core->args[6];
	$songID = $core->args[7];
	
	if($albumID > 0) {
		$result = $database->db_query("SELECT name FROM Albums WHERE albumID = $albumID");
		$rowAlbum = mysqli_fetch_object($result);
		
		$result = $database->db_query("SELECT * FROM Songs WHERE songID = $songID");
		$row = mysqli_fetch_object($result);
?>
<h2>Editting a song on <?php echo $rowAlbum->name; ?></h2>	
<form enctype="multipart/form-data" action="/process/editSong" method="POST">
	<table border="0">
		<tr><td>Name: </td><td><input type="text" name="sname" class="adminInput" value="<?php echo $row->name; ?>" /></td><td></td></tr>
		<tr><td>Track: </td><td><input type="text" name="track" class="adminInput" value="<?php echo $row->track; ?>" /></td><td></td></tr>
		<tr><td>Length: </td><td><input type="text" name="length" class="adminInput" value="<?php echo $row->length; ?>" /></td><td><span style="font-size: 8pt">(In seconds)</span></td></tr>
		<tr><td>Munniez: </td><td><input type="text" name="munniez" class="adminInput" value="<?php echo $row->munniez; ?>" /></td><td></td></tr>
		<tr><td>Credits: </td><td><input type="text" name="credits" class="adminInput" value="<?php echo $row->credits; ?>" /></td><td></td></tr>
		<tr><td>Song: </td><td><input type="file" name="song" class="adminInput" /></td><td><span style="font-size: 8pt">(.mp3)</span></td></tr>
		<tr><td></td><td colspan="2" align="left"><span style="font-size: 8pt">(Leave empty to keep old song)</span></td></tr>
		<tr><td colspan="3" align="center"><div style="width: 2px; height: 40px;"></div></td></tr>
		<tr><td colspan="3" align="center"><input type="submit" value="Update this song" /></td></tr>
	</table>
	<input type="hidden" name="albumID" value="<?php echo $albumID; ?>" />
	<input type="hidden" name="songID" value="<?php echo $songID; ?>" />
</form>
<?php } else { ?>
<h2>Error: AlbumID not set</h2>
<?php } ?>