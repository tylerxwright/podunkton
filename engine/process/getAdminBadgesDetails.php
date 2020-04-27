<?php
	global $database;
	global $session;
	global $core;
	global $prettyprint;
	
	$badgeID = $core->args[2];
	$return = "";
	
	if(!$session->user){
		die();
	}
	
	$result = $database->db_query("SELECT * FROM Badges WHERE badgeID = $badgeID");
	$row = mysqli_fetch_object($result);
	
	$return .= "<table border='0' width='100%' style='font-size: 9pt;'>";
	$return .= "<tr><td colspan='2' style='border-bottom: solid 1px #333; color: #fff; background-color: #647DB8;'><b>Badge Name:".$row->name."</b> ".$row->badgeID." </td></tr>";
	$return .= "<tr><td width='20%'>Image: </td><td><img src='/content/badges/".$row->icon."' /></td></tr>";
	$return .= "<tr><td valign='top'>Description: </td><td>".$row->description."</td></tr>";
	$return .= "<tr><td valign='top'>Message: </td><td>".$row->message."</td></tr>";
	$return .= "</table>";
	
	echo $return;
	die();
	
?>
