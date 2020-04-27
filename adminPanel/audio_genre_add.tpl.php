<?php

?>
<h2>Add a new Genre</h2>
<form action="/process/addGenre" method="POST">
	<table border="0">
		<tr><td>Name: </td><td><input type="text" class="adminInput" name="gname" /></td></tr>
		<tr><td valign="top">Description: </td><td><textarea class="adminTextArea" name="description"></textarea></td></tr>
		<tr><td></td><td align="right"><input type="submit" name="name" value="submit" /></td></tr>
	</table>
</form>