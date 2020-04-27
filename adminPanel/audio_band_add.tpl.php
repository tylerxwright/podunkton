<?php
	global $database;
?>
<h2>Add a new band</h2>
<form enctype="multipart/form-data" action="/process/addBand" method="POST">
	<table border="0">
		<tr><td><b>General</b></td><td></td></tr>
		<tr><td>Name: </td><td><input class="adminInput2" name="bname" /></td></tr>
		<tr><td>Genre: </td><td>
			<select name="genre" class="adminInput2">
		<?php
			$result = $database->db_query("SELECT genreID, name FROM Genres ORDER BY name ASC");
			while($row = mysqli_fetch_object($result)) {
		?>
			<option value="<?php echo $row->genreID; ?>"><?php echo $row->name; ?></option>
		<?php } ?>
			</select>
		</td></tr>
		<tr><td>Record Label: </td><td>
			<select name="label" class="adminInput2">
		<?php
			$result = $database->db_query("SELECT labelID, name FROM Record_Labels ORDER BY name ASC");
			while($row = mysqli_fetch_object($result)) {
		?>
			<option value="<?php echo $row->labelID; ?>"><?php echo $row->name; ?></option>
		<?php } ?>
			</select>
		</td></tr>
		<tr><td>Homepage: </td><td><input class="adminInput2" name="homepage" value="http://" /></td></tr>
		<tr><td>Band Picture: </td><td><input class="adminInput2" type="file" name="bandPicture" /></td></tr>
		<tr><td valign="top">Biography: </td><td><textarea class="adminTextArea" name="biography"></textarea></td></tr>
		<tr><td valign="bottom" height="50"></td><td align="right"><input type="submit" value="submit" /></td></tr>
	</table>
</form>