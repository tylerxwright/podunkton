<?php
	global $database;
	global $core;
	
	$bandID = $core->args[3];
	$result = $database->db_query("SELECT * FROM Bands WHERE bandID = $bandID");
	$row = mysqli_fetch_object($result);
?>
<h2><?php echo $row->name; ?></h2>
