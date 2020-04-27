<?php
	global $core;
	global $database;
	
	$toonID = $core->args[4];
	$castID = $core->args[5];
	
	$result = $database->db_query("SELECT t.name as 'tname', u.name as 'uname' FROM Toons as t JOIN Toons_has_Cast as c JOIN Users as u ON c.userID = u.userID WHERE t.toonID = $toonID AND c.id = $castID");
	$row = mysqli_fetch_object($result);
?>
<h2>Editting a cast member for <?php echo $row->name; ?></h2>
<form action="/process/editToonCastMember" method="POST">
	<table border="0" width="100%">
		<tr><td>Name: </td><td><input class="adminInput2" name="cname" value="<?php echo $row->uname; ?>" /><input type="submit" value="Update Cast Member" /></td></tr>
	</table>
	<input type="hidden" name="toonID" value="<?php echo $toonID; ?>" />
	<input type="hidden" name="castID" value="<?php echo $castID; ?>" />
</form>