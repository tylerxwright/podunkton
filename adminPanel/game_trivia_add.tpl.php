<?php
	global $core;
	global $database;
	
	$gameID = $core->args[4];
	
	$result = $database->db_query("SELECT t.name as 'tname' FROM Games as t WHERE t.gameID = $gameID");
	$row = mysqli_fetch_object($result);
?>
<h2>Adding trivia for <?php echo $row->tname; ?></h2>
<form action="/process/addGameTrivia" method="POST">
	<table border="0" width="100%">
		<tr><td>Order: </td><td><input class="adminInput2" name="order" /></td></tr>
		<tr><td valign="top">Trivia: </td><td><textarea name="trivia" rows="6" cols="40"></textarea></td></tr>
		<tr><td></td><td><input type="submit" value="Add Trivia Item" /></td></tr>
	</table>
	<input type="hidden" name="gameID" value="<?php echo $gameID; ?>" />
</form>