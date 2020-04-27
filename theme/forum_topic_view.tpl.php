<?php
	global $core;
	global $database;
?>

<?php
	$result = $database->db_query("SELECT posts.title, posts.postid as 'id' FROM Posts as posts JOIN Forum_subcategory as sub ON posts.subcategory = sub.subcategoryID WHERE parent = 0");
	while($row = mysqli_fetch_object($result)){
		print "<a href='/forum/".$core->args[1]."/".$row->id."'>".$row->title."</a><br/>";
	}
?>