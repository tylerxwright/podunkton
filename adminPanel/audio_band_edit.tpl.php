<?php
	global $database;
	global $core;
	
	$bandID = $core->args[4];
	
	$result = $database->db_query("SELECT b.name as 'bname', b.homepage, b.picture, b.biography, g.name as 'gname', r.name as 'rname', g.genreID, r.labelID FROM Bands as b JOIN Genres as g ON g.genreID = b.genre JOIN Record_Labels as r ON r.labelID = b.label WHERE bandID = $bandID");
	$row = mysqli_fetch_object($result);
?>
<h2>Editting <?php echo $row->bname; ?></h2>
<form enctype="multipart/form-data" action="/process/editBand" method="POST">
	<table border="0">
		<tr><td><b>General</b></td><td></td></tr>
		<tr><td>Name: </td><td><input class="adminInput2" name="bname" value="<?php echo $row->bname; ?>"/></td></tr>
		<tr><td>Genre: </td><td>
			<select name="genre" class="adminInput2">
		<?php
			$result = $database->db_query("SELECT genreID, name FROM Genres ORDER BY name ASC");
			while($row2 = mysqli_fetch_object($result)) {
		?>
			<option value="<?php echo $row2->genreID; ?>" <?php if($row2->genreID == $row->genreID) echo "selected='selected'"; ?>><?php echo $row2->name; ?></option>
		<?php } ?>
			</select>
		</td></tr>
		<tr><td>Record Label: </td><td>
			<select name="label" class="adminInput2">
		<?php
			$result = $database->db_query("SELECT labelID, name FROM Record_Labels ORDER BY name ASC");
			while($row3 = mysqli_fetch_object($result)) {
		?>
			<option value="<?php echo $row3->labelID; ?>" <?php if($row3->labelID == $row->labelID) echo "selected='selected'"; ?>><?php echo $row3->name; ?></option>
		<?php } ?>
			</select>
		</td></tr>
		<tr><td>Homepage: </td><td><input class="adminInput2" name="homepage" value="<?php if($row->homepage == ""){echo "http://";} else {echo $row->homepage;} ?>" /></td></tr>
		<tr><td>Band Picture: </td><td><input class="adminInput2" type="file" name="bandPicture" /></td></tr>		
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td valign="top">Biography: </td><td><textarea class="adminTextArea" name="biography"><?php echo $row->biography; ?></textarea></td></tr>
		<tr><td valign="bottom" height="50"></td><td align="right"><input type="submit" value="submit" /></td></tr>
	</table>
	<input type="hidden" name="bandID" value="<?php echo $bandID; ?>" />
</form>