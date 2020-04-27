<?php
	global $core;
	global $database;
	
	$gameID = $core->args[4];
	$castID = $core->args[5];
	
	$result = $database->db_query("SELECT t.name as 'tname', u.name as 'uname' FROM Games as t JOIN Games_has_Cast as c JOIN Users as u ON c.userID = u.userID WHERE t.gameID = $gameID AND c.id = $castID");
	$row = mysqli_fetch_object($result);
?>
<h2>Editting a cast member for <?php echo $row->name; ?></h2>
<form action="/process/editGameCastMember" method="POST">
	<table border="0" width="100%">
		<tr><td>Name: </td><td><input class="adminInput2" name="cname" value="<?php echo $row->uname; ?>" /><input type="submit" value="Update Cast Member" /></td></tr>
	</table>
	<input type="hidden" name="gameID" value="<?php echo $gameID; ?>" />
	<input type="hidden" name="castID" value="<?php echo $castID; ?>" />
</form>