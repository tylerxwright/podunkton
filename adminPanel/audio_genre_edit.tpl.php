<?php
	global $database;
	global $core;
	
	$genreID = $core->args[4];
	
	$result = $database->db_query("SELECT * FROM Genres WHERE genreID = $genreID");
	$row = mysqli_fetch_object($result);
?>
<h2>Editting the genre "<?php echo $row->name; ?>"</h2>
<form action="/process/editGenre" method="POST">
	<table border="0">
		<tr><td>Name: </td><td><input type="text" class="adminInput" name="gname" value="<?php echo $row->name; ?>"/></td></tr>
		<tr><td valign="top">Description: </td><td><textarea class="adminTextArea" name="description"><?php echo $row->description; ?></textarea></td></tr>
		<tr><td></td><td align="right"><input type="submit" name="name" value="update" /></td></tr>
	</table>
	<input type="hidden" name="genreID" value="<?php echo $genreID; ?>" />
</form>