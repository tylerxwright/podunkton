<?php
	global $database;
	
	$toonID = $core->args[3];
	$result = $database->db_query("SELECT * FROM Toons WHERE toonID = $toonID");
	$row = mysqli_fetch_object($result);
?>
<b>Editting <?php echo $row->name; ?></b><br/>
<form enctype="multipart/form-data" action="/process/editToon" method="POST">
	<table>
		<tr><td>Name:</td><td><input type="text" name="name" value="<?php echo $row->name; ?>"/></td></tr>
		<tr><td>Season:</td><td>
			<select name="seasonID">
		<?php
			$result2 = $database->db_query("SELECT seasonID, name FROM Toon_Seasons ORDER BY seasonOrder");
			while($row2 = mysqli_fetch_object($result2)) {
				if($row2->seasonID == $row->season) {
		?>
			<option value="<?php echo $row2->seasonID; ?>" SELECTED><?php echo $row2->name; ?></option>
		<?php 	} else {?>
			<option value="<?php echo $row2->seasonID; ?>"><?php echo $row2->name; ?></option>
		<?php 
				} 
			}
		?>
			</select>
		</td></tr>
		<tr><td>SWF File:</td><td><input type="file" name="swf" /></td></tr>
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td>Icon:</td><td><input type="file" name="icon" /></td></tr>
		<tr><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current image)</span></td></tr>
		<tr><td colspan="2"><div style="height: 8px; width: 8px;"></div></td></tr>
		<tr><td>Release Date:</td><td><input type="text" name="rDate" value="<?php echo $row->releaseDate; ?>" /></td></tr>
		<tr><td>New Grounds Link:</td><td><input type="text" name="NG_Link" value="<?php echo $row->ngLink; ?>" /></td></tr>
		<tr><td valign="top">Description:</td><td><textarea cols="40" rows="5" name="description"><?php echo $row->description; ?></textarea></td></tr>
		<tr><td>Episode:</td><td><input type="text" name="episode" value="<?php echo $row->episode; ?>" /></td></tr>
		<tr><td>MPAA Rating: </td><td>
			<select name="mpaaRating" class="adminInput2">
		<?php
			$result2 = $database->db_query("SELECT mpaaID, name FROM MPAA_Ratings");
			while($row2 = mysqli_fetch_object($result2)) {
				if($row2->mpaaID == $row->mpaaRating) {
		?>
			<option value="<?php echo $row2->mpaaID; ?>" SELECTED><?php echo $row2->name; ?></option>
		<?php 	}  else {?>
			<option value="<?php echo $row2->mpaaID; ?>"><?php echo $row2->name; ?></option>
		<?php
				}
			}
		?>
			</select>
		</td></tr>
		<tr><td>Munniez:</td><td><input type="text" name="munniez" value="<?php echo $row->munniez; ?>" /></td></tr>
		<tr><td>Credits:</td><td><input type="text" name="credits" value="<?php echo $row->credits; ?>" /></td></tr>
		<tr><td>Munniez on View:</td><td><input type="text" name="munniezOnView" value="<?php echo $row->munniezOnView; ?>" /></td></tr>
		<tr><td></td><td><br/><input type="submit" value="Submit" /></td></tr>
	</table>
	<input type="hidden" name="toonID" value="<?php echo $row->toonID; ?>" />
</form>