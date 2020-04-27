<?php
	global $core;
	global $database;
?>
<?php
	$result = $database->db_query("SELECT sub.name as 'title' FROM Forum_subcategory as sub JOIN Posts as posts ON posts.subcategory = sub.subcategoryID WHERE posts.postID = ".$core->args[2]." LIMIT 1");
	$title = mysqli_fetch_object($result);
	print "<b>Viewing Forum: ".$title->title."</b><br/><br/>";
	
	$result = $database->db_query("SELECT title, text FROM Posts WHERE postID = ".$core->args[2]);
	$starter = mysqli_fetch_object($result);
	print $starter->title."<br/>".$starter->text."<br/><br/>";
	
	$result = $database->db_query("SELECT title, text FROM Posts WHERE parent = ".$core->args[2]);
	while($row = mysqli_fetch_object($result)){
		print $row->title."<br/>".$row->text."<br/><br/>";
	}
?>