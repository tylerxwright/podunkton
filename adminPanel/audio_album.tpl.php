<?php
	global $database;
	global $core;
	
	$albumID = $core->args[4];
	$result = $database->db_query("SELECT a.albumID, a.name as 'aname', a.releaseDate, a.coverArt, a.producer, a.munniez, a.credits, a.studio, b.name as 'bname', b.bandID FROM Albums as a JOIN Bands_has_Albums as bha ON a.albumID = bha.albumID JOIN Bands as b ON bha.bandID = b.bandID WHERE a.albumID = $albumID");
	$row = mysqli_fetch_object($result);
?>
<h2>
	<?php echo $row->bname; ?> - <?php echo $row->aname; ?>
	<div title="Delete" class="deleteBtn" onclick="location='/process/deleteAlbum/<?php echo $row->albumID; ?>/<?php echo $row->bandID; ?>';"></div>
</h2>
<div id="coverArt"><img src="/content/audio/albumArt/<?php echo $row->coverArt; ?>" border="0" /></div>
<div id="audioTopRight">
	<form enctype="multipart/form-data" action="/process/editAlbum" method="POST">
		<table border="0">
			<tr><td class="alabel">Album Name: </td><td><input type="input" name="aname" class="albumInput3" value="<?php echo $row->aname; ?>" /></td></tr>
			<tr><td class="alabel">Release Date: </td><td><input type="input" name="date" class="albumInput3" value="<?php echo $row->releaseDate; ?>" /></td></tr>
			<?php
				$result = $database->db_query("SELECT name FROM Users WHERE userID = ".$row->producer);
				$rowUser = mysqli_fetch_object($result);
			?>
			<tr><td class="alabel">Producer: </td><td><input type="input" name="producer" class="albumInput3" value="<?php echo $rowUser->name; ?>" /></td></tr>
			<tr><td class="alabel">Munniez: </td><td><input type="input" name="munniez" class="albumInput3" value="<?php echo $row->munniez; ?>" /></td></tr>
			<tr><td class="alabel">Credits: </td><td><input type="input" name="credits" class="albumInput3" value="<?php echo $row->credits; ?>" /></td></tr>
			<tr><td class="alabel">Studio: </td><td><input type="input" name="label" class="albumInput3" value="<?php echo $row->studio; ?>" /></td></tr>
			<tr><td class="alabel">Cover Art: </td><td><input class="adminInput3" type="file" name="coverArt" /></td></tr>	
			<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
			<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
			<tr><td colspan="2" align="center"><input type="submit" value="submit" /></td></tr>
		</table>
		<input type="hidden" name="albumID" value="<?php echo $albumID; ?>" />
	</form>
</div>
<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Songs</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/audio/band/album/song/add/<?php echo $row->albumID; ?>';" title="Add a new song"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>
<div class="genreBar">
	<div class="genreName">Song List</div>
	<div class="genreRight">
	</div>
	<div style="clear: both;"></div>
</div>
<table border="0" id="songHolder" cellpadding="0" cellspacing="0">
	<tr class="headerRow">
		<th>#</th>
		<th>Name</th>
		<th>Mp3 File</th>
		<th>Length</th>
		<th>Plays</th>
		<th>Rating</th>
		<th>$Z</th>
		<th>$C</th>
		<th>Rate#</th>
		<th style="border-right: none;">Actions</th>
	</tr>
<?php
	$c = 1;
	$result = $database->db_query("SELECT s.* FROM Songs as s JOIN Albums_has_Songs as ahs ON s.songID = ahs.songID WHERE ahs.albumID = $albumID ORDER BY s.track ASC");
	while($rowSong = mysqli_fetch_object($result)) {
?>
	<tr class="songRow" <?php if($c%2!=0) {echo "style='background-color: #F1F5FA;'";} ?> onmouseover="this.style.backgroundColor = '#3D80DF';" onmouseout="this.style.backgroundColor = '<?php if($c%2!=0) {echo "#F1F5FA";}else{echo "#fff";} ?>';">
		<td class="songItem"><?php echo $rowSong->track; ?></td>
		<td class="songItem"><?php echo $rowSong->name; ?></td>
		<td class="songItem"><?php echo $rowSong->song; ?></td>
		<td class="songItem"><?php echo $rowSong->length; ?></td>
		<td class="songItem"><?php echo $rowSong->plays; ?></td>
		<td class="songItem"><?php echo $rowSong->rating; ?></td>
		<td class="songItem"><?php echo $rowSong->munniez; ?></td>
		<td class="songItem"><?php echo $rowSong->credits; ?></td>
		<td class="songItem"><?php echo $rowSong->numRaters; ?></td>
		<td class="songItem" style="border-right: none;">
			<div style="width: 100%;">
				<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/audio/band/album/song/edit/<?php echo $albumID; ?>/<?php echo $rowSong->songID; ?>';"></div>
				<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteSong/<?php echo $albumID; ?>/<?php echo $rowSong->songID; ?>';"></div>
				<div style="clear: both;"></div>
			</div>
		</td>
	</tr>
<?php 
		$c++;
	} 
?>
</table>
