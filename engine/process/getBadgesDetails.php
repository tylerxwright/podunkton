<?php
	global $database;
	global $session;
	global $core;
	global $prettyprint;
	
	$badgeID = $core->args[2];
	$return = "";
	
	$result = $database->db_query("SELECT b.name, b.icon, b.description, uhb.dateAquired FROM Badges as b JOIN Users_has_Badges as uhb ON b.badgeID = uhb.badgeID WHERE b.badgeID = $badgeID");
	$row = mysqli_fetch_object($result);
	
	$return .= "<table border='0' width='100%' style='font-size: 9pt;'>";
	$return .= "<tr><td colspan='2' style='border-bottom: solid 1px #333; color: #fff; background-color: #647DB8;'><b>".$row->name."</b></td></tr>";
	$return .= "<tr><td width='20%'>Badge: </td><td><img src='/content/badges/".$row->icon."' /></td></tr>";
	$return .= "<tr><td>Date Acquired: </td><td>".$prettyprint->prettydate($row->dateAquired, "[M] [D], [Y]")."</td></tr>";
	$return .= "<tr><td valign='top'>Description: </td><td>".$row->description."</td></tr>";
	$return .= "</table>";
	
	echo $return;
	die();
	
?>