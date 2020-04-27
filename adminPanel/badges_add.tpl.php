<?php
	global $core;
	global $database;
?>
<h2>Adding a badge</h2>
<form enctype="multipart/form-data" action="/process/addBadge" method="POST">
	<table border="0" width="100%">
		<tr><td>Name: </td><td><input class="adminInput2" name="name" /></td></tr>
		<tr><td>Icon:</td><td><input type="file" name="icon" /> (33x33)</td></tr>
		<tr><td valign="top">Description:</td><td><textarea cols="40" rows="5" name="description"></textarea></td></tr>
		<tr><td valign="top">Message:</td><td><textarea cols="40" rows="5" name="message"></textarea></td></tr>
		<tr><td></td><td><input type="submit" value="Add Badge" /></td></tr>
	</table>
</form>
