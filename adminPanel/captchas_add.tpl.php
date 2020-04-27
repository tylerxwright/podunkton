<?php
	global $core;
	global $database;
	global $session;
	global $error;
?>
<b>Add a New Captcha</b>
<form enctype="multipart/form-data" action="/process/addCaptcha" method="POST">
	<table border="0">
		<tr><td>Text:</td><td><input type="text" name="text" /></td></tr>
		<tr><td>Captcha:</td><td colspan="2"><input type="file" name="captcha" /></td></tr>
		<tr><td colspan="2"><div style="height: 30px;"></div></td></tr>
		<input type="hidden" name="admin" value="1"/>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>
	