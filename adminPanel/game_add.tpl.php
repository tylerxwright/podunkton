<?php
	global $database;
?>
<b>Add New Game</b><br/>
<form enctype="multipart/form-data" action="/process/addGame" method="POST">
	<table>
		<tr><td>Name:</td><td><input type="text" name="name" /></td></tr>
		<tr><td>SWF File:</td><td><input type="file" name="swf" /></td></tr>
		<tr><td>Frame Size:</td><td><input type="text" name="frameSize" /> wxh</td></tr>
		<tr><td>Icon:</td><td><input type="file" name="icon" /> (220x160)</td></tr>
		<tr><td>Release Date:</td><td><input type="text" name="rDate" /></td></tr>
		<tr><td>New Grounds Link:</td><td><input type="text" name="NG_Link" /></td></tr>
		<tr><td valign="top">Description:</td><td><textarea cols="40" rows="5" name="description"></textarea></td></tr>
		<tr><td>MPAA Rating: </td><td>
			<select name="mpaaRating" class="adminInput2">
		<?php
			$result = $database->db_query("SELECT mpaaID, name FROM MPAA_Ratings");
			while($row = mysqli_fetch_object($result)) {
		?>
			<option value="<?php echo $row->mpaaID; ?>"><?php echo $row->name; ?></option>
		<?php } ?>
			</select>
		</td></tr>
		<tr><td>Munniez:</td><td><input type="text" name="munniez" /></td></tr>
		<tr><td>Credits:</td><td><input type="text" name="credits" /></td></tr>
		<tr><td>Munniez on View:</td><td><input type="text" name="munniezOnView" /></td></tr>
		<tr><td></td><td><br/><input type="submit" value="Submit" /></td></tr>
	</table>
</form>