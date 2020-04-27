<?php
	global $core;
	global $session;
	global $database;
?>
<h3>Add a new category</h3>
<form enctype="multipart/form-data" action="/process/addForumCategory" method="POST">
	<table border="0">
		<tr><td>Name</td><td><input type="text" name="name" style="width: 150px;"></td></tr>
		<tr><td>Color</td>
			<td>
				<select name="color" style="width: 150px;">
					<option value="blue">Blue</option>
					<option value="red">Red</option>
					<option value="green">Green</option>
				</select>
			</td>
		</tr>
		<tr><td>Icon</td><td><input type="file" name="icon" /> (13x13 PNG)</td></tr>
		<tr><td>Order</td><td><input type="text" name="order" size="2"> Leave blank for next highest</td></tr>
		<input type="hidden" name="admin" value="1"/>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>