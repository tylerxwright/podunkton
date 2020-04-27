<?php
	global $database;
?>
<b>Add New Toon Season</b><br/>
<form enctype="multipart/form-data" action="/process/addToonSeason" method="POST">
	<table>
		<tr><td>Name:</td><td><input type="text" name="sname" /></td></tr>
		<tr><td>Order:</td><td><input type="text" name="order" /></td></tr>
		<tr><td>Blue Picture:</td><td><input type="file" name="picture" /></td></tr>
		<tr><td>Hover Picture:</td><td><input type="file" name="hpicture" /></td></tr>
		<tr><td></td><td><br/><input type="submit" value="Submit" /></td></tr>
	</table>
</form>