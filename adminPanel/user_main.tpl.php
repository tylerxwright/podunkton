<?php
	global $database;
?>
<form action="/process/admin_search_user" method="POST">
	User Search: <input type="text" name="username">
	<input type="submit" value="Find">
</form>
<br/>
# Users
<?php
		$result = $database->db_query("SELECT COUNT(userID) as 'count' FROM Users");
		$row = mysqli_fetch_object($result);
		print $row->count;
?>
<br/><br/>
<?php
	$result = $database->db_query("SELECT * FROM Users");
	while($row = mysqli_fetch_object($result)){
		print "<a href='/admin/user/".$row->userID."'>".$row->name."</a><br/>";
	}
?>