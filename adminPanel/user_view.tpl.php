<?php
	global $core;
	global $database;
?>
<form action="/process/admin_search_user" method="POST">
	User Search: <input type="text" name="username">
	<input type="submit" value="Find">
</form>
<form action="/process/admin_edit_user" method="POST">
	<table cellspacing="10">
<?php
	$result = $database->db_query("SELECT * FROM Users WHERE userID = ".$core->args[2]);
	while($row = mysqli_fetch_object($result)){
		print "<tr><td><b>USER</b></td><td><b>".$row->name."</b></td></tr>";
		print "<tr><td>id</td><td>".$row->userID."</td></tr>";
		print "<tr><td>name</td><td><input type='text' name='name' value='".$row->name."' /></td></tr>";
		print "<tr><td>sex</td><td><input type='text' name='sex' value='".$row->sex."' /></td></tr>";
		print "<tr><td>birthday</td><td><input type='text' name='birthday' value='".$row->birthday."' /></td></tr>";
		print "<tr><td>email</td><td><input type='text' name='email' value='".$row->email."' /></td></tr>";
		print "<tr><td>aim</td><td><input type='text' name='aim' value='".$row->aim."' /></td></tr>";
		print "<tr><td>msn</td><td><input type='text' name='msn' value='".$row->msn."' /></td></tr>";
		print "<tr><td>icq</td><td><input type='text' name='icq' value='".$row->icq."' /></td></tr>";
		print "<tr><td>goodevil</td><td><input type='text' name='goodevil' value='".$row->goodevil."' /></td></tr>";
		print "<tr><td>points</td><td><input type='text' name='points' value='".$row->points."' /></td></tr>";
		print "<tr><td>rankID</td><td><input type='text' name='rankID' value='".$row->rankID."' /></td></tr>";
		print "<tr><td>experience</td><td><input type='text' name='experience' value='".$row->experience."' /></td></tr>";
		print "<tr><td>favoriteToon</td><td><input type='text' name='favoriteToon' value='".$row->favoriteToon."' /></td></tr>";
		print "<tr><td>favoriteGame</td><td><input type='text' name='favoriteGame' value='".$row->favoriteGame."' /></td></tr>";
		print "<tr><td>featured</td><td><input type='text' name='featured' value='".$row->featured."' /></td></tr>";
		print "<tr><td>forumView</td><td><input type='text' name='forumView' value='".$row->forumView."' /></td></tr>";
		print "<tr><td>permissions</td><td><input type='text' name='permissions' value='".$row->permissions."' /></td></tr>";
?>
	</table>
	<input type="submit" name="edit" value="save changes" />
	<input type="submit" name="delete" value="Delete User" />
	<input type='hidden' name='<?php print $row->name; ?>' value='<?php print $row->userID; ?>' />
	<input type='hidden' name='userid' value='<?php print $row->userID; ?>' />
</form>
<?php } ?>