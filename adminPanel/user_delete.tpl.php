<?php
	global $core;
	global $database;
?>
<form action="/process/admin_search_user" method="POST">
	User Search: <input type="text" name="username">
	<input type="submit" value="Find">
</form>
<br/>
<b>Delete a User</b><br/><br/>
<form action="/process/admin_delete_user" method="POST">
<?php
	$result = $database->db_query("SELECT userID, name FROM Users");
	while($row = mysqli_fetch_object($result)){
		print "<input type='checkbox' name='".$row->name."' value='".$row->userID."' /> ".$row->name."<br/>";
	}
?>
	<br/>
	<input type="submit" value="Delete User(s)">
</form>