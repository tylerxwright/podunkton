<?php
	global $session;
	global $database;
	global $core;
	
	$user = $session->user;
	
	if($user) {
?>

<?php 
	} else {
		include_once("theme/errordocs/permission.tpl.php");
	} 
?>