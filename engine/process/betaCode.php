<?php
	global $core;
	global $session;
	global $database;
	
	$code = $core->args[2];
	
	$result = $database->db_query("SELECT id FROM Beta WHERE code = '$code' AND valid = 1");
	$count = mysqli_num_rows($result);
	$row = mysqli_fetch_object($result);
	
	echo $row->id;
	
	if($count > 0) {
		$_SESSION['betacode'] = $row->id;
		$_SESSION['beta'] = 2;
		header("Location: /register");
		die();
	} else {
		header("Location: /");
		die();
	}
	
	
?>