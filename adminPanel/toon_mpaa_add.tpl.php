<?php
	global $database;
?>
<b>Add New MPAA Rating</b><br/>
<form enctype="multipart/form-data" action="/process/addMPAA" method="POST">
	<table>
		<tr><td>Name:</td><td><input type="text" name="mname" /></td></tr>
		<tr><td>Line 1:</td><td><input type="text" name="line1" /></td></tr>
		<tr><td>Line 2:</td><td><input type="text" name="line2" /></td></tr>
		<tr><td>Line 3:</td><td><input type="text" name="line3" /></td></tr>
		<tr><td>Icon:</td><td><input type="file" name="icon" /> <span style="font-size: 8pt;">(47x63)</span></td></tr>
		<tr><td></td><td><br/><input type="submit" value="Add MPAA Rating" /></td></tr>
	</table>
</form>