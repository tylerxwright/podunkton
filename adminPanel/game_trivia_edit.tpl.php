<?php
	global $core;
	global $database;
	
	$gameID = $core->args[4];
	$triviaID = $core->args[5];
	
	$result = $database->db_query("SELECT t.name as 'tname', tt.trivia, tt.triviaOrder FROM Games as t JOIN Games_Trivia as tt ON t.gameID = tt.gameID WHERE tt.triviaID = $triviaID");
	$row = mysqli_fetch_object($result);
?>
<h2>Adding trivia for <?php echo $row->tname; ?></h2>
<form action="/process/editGameTrivia" method="POST">
	<table border="0" width="100%">
		<tr><td>Order: </td><td><input class="adminInput2" name="order" value="<?php echo $row->triviaOrder; ?>" /></td></tr>
		<tr><td valign="top">Trivia: </td><td><textarea name="trivia" rows="6" cols="40"><?php echo $row->trivia; ?></textarea></td></tr>
		<tr><td></td><td><input type="submit" value="Update Trivia Item" /></td></tr>
	</table>
	<input type="hidden" name="gameID" value="<?php echo $gameID; ?>" />
	<input type="hidden" name="triviaID" value="<?php echo $triviaID; ?>" />
</form>