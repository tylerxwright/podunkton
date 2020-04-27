<?php
	global $core;
	global $session;
	global $database;
?>

<h3>BETA Admin - Add User</h3>
<form action="/process/addBeta" method="POST">
	<table border="0">
		<tr><td>Email</td><td><input type="text" name="email" /></td></tr>
		<tr><td></td><td><input type="submit" name="submit" value="submit"/></td></tr>
	</table>
</form>