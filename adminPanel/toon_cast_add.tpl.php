<?php
	global $core;
	global $database;
	
	$toonID = $core->args[4];
	
	$result = $database->db_query("SELECT name FROM Toons WHERE toonID = $toonID");
	$row = mysqli_fetch_object($result);
?>
<h2>Add a new cast member to <?php echo $row->name; ?></h2>
<form action="/process/addToonCastMember" method="POST">
	<table border="0" width="100%">
		<tr><td>Name: </td><td><input class="adminInput2" name="cname" /><input type="submit" value="Add New Cast Member" /></td></tr>
	</table>
	<input type="hidden" name="toonID" value="<?php echo $toonID; ?>" />
</form>