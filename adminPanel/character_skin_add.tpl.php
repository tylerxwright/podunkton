<?php
	global $core;
	global $database;
	global $session;
	global $error;
	
	$result = $database->db_query("select MAX(skinNum) as 'nextNum' FROM Skins");
	$row = mysqli_fetch_object($result);
	$nextNum = $row->nextNum+1;
?>

<b>Add a New Skin</b><br/>
All you need to is add the correct SWF to the correct slot<br/>then your done!<br/><br/>
<form enctype="multipart/form-data" action="/process/addSkin" method="POST">
	<table border="0">
		<tr><th>Slot</th><th>SWF</th></tr>
		<tr><td>Head</td><td><input type="file" name="s1" /></td></tr>
		<tr><td>Forearm1</td><td><input type="file" name="s2" /></td></tr>
		<tr><td>Arm1</td><td><input type="file" name="s3" /></td></tr>
		<tr><td>Body</td><td><input type="file" name="s4" /></td></tr>
		<tr><td>Forearm2</td><td><input type="file" name="s5" /></td></tr>
		<tr><td>Arm2</td><td><input type="file" name="s6" /></td></tr>
		<tr><td>Legs</td><td><input type="file" name="s7" /></td></tr>
		<tr><td colspan="2"><div style="height: 10px;"></div></td></tr>
		<tr><td>Sex</td><td>male<input type="radio" name="sex" value="m"> female<input type="radio" name="sex" value="f"></td></tr>
		<tr><td colspan="2"><div style="height: 30px;"></div></td></tr>
		<input type="hidden" name="admin" value="1"/>
		<input type="hidden" name="nextNum" value="<?php echo $nextNum; ?>"/>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>