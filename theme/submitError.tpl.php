<?php if($session->user) { ?>
<div style="width: 792px; height: 20px;"></div>
<form action="/process/submitError" method="POST">
	<table border="0">
		<tr><td>Subject:</td><td colspan="2"><input style="width: 400px;" type="text" name="subject" /></td></tr>
		<tr><td valign="top">Report:</td><td colspan="2"><textarea style="width: 400px; height: 400px;" name="message"></textarea></td></tr>
		<tr><td></td><td><input type="submit" value="Submit" /></td><td align="right"><a href="/"><button>Cancel</button></a></td></tr>
	</table>
</form>
<div style="width: 792px; height: 20px;"></div>
<?php 
	} else { 
		include_once("theme/errordocs/404.tpl.php");
	}
?>