<?php
	global $core;
	global $database;
	global $session;
	global $error;
	
	/*$result = $database->db_query("select MAX(skinNum) as 'nextNum' FROM Skins");
	$row = mysqli_fetch_object($result);
	$nextNum = $row->nextNum+1;*/
?>

<b>Add a New Physical Item</b><br/>
<form enctype="multipart/form-data" action="/process/addPhysical" method="POST">
	<table border="0">
		<tr><td>Name</td><td><input type="text" name="name" /></td></tr>
		<tr><td valign="top">Description</td><td><textarea name="description"></textarea></td></tr>
		<tr><td>Munniez</td><td><input type="text" name="munniez" /></td></tr>
		<tr><td>Credits</td><td><input type="text" name="credits" /></td></tr>
		<tr><td>Type</td><td>
			<select name="type">
				<option value="hair">Hair</option>
				<option value="eyes">Eyes</option>
				<option value="eyebrows">Eyebrows</option>
			</select>
		</td></tr>
		<tr><td>Color</td><td>
			<select name="color">
				<option value="red">Red</option>
				<option value="orange">Orange</option>
				<option value="yellow">Yellow</option>
				<option value="green">Green</option>
				<option value="blue">Blue</option>
				<option value="purple">Purple</option>
				<option value="pink">Pink</option>
				<option value="ltbrown">Lt. Brown</option>
				<option value="brown">Brown</option>
				<option value="black">Black</option>
				<option value="white">White</option>
			</select>
		</td></tr>
		<tr><td>PNG</td><td><input type="file" name="png" /></td></tr>
		<tr><td>Hair Front<br/>Left Eyebrow<br/>Eyes</td><td valign="top"><input type="file" name="s1" /></td></tr>
		<tr><td>Hair Back<br/>Right Eyebrow</td><td valign="top"><input type="file" name="s2" /></td></tr>
		<tr><td colspan="2"><div style="height: 10px;"></div></td></tr>
		<tr><td>Sex</td><td>male<input type="radio" name="sex" value="m" CHECKED> female<input type="radio" name="sex" value="f"></td></tr>
		<input type="hidden" name="admin" value="1"/>
		<tr><td colspan="2"><div style="height: 30px;"></div></td></tr>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>