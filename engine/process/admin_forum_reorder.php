<?php
	global $core;
	global $database;
	
	$ids = explode('=', $core->args[2]);
	
	for($i=0; $i < count($ids); $i++){
		$x = $i+1;
		$query = "UPDATE Forum_category SET position = ".$x." WHERE categoryID = ".$ids[$i];
		$result = $database->db_query($query);
	}
	die();
?>