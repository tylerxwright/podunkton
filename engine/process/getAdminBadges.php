<?php
	global $database;
	global $session;
	global $core;
	
	$page = $core->args[2];
	$return = "";
	
	if(!$session->user){
		die();
	}
	
	$result = $database->db_query("SELECT name, icon, badgeID FROM Badges ORDER BY name ASC LIMIT ".($page-1)*ADMIN_BADGES_PER_PAGE.", ".ADMIN_BADGES_PER_PAGE);
	while($row = mysqli_fetch_object($result)){
		$return .= "<div style='width: 100%; border-bottom: solid 1px #333;'>";
		$return .= "<div style='float: left; padding-right: 10px;'><img src='/content/badges/".$row->icon."' onmouseover='getDetails(1, ".$row->badgeID.")' onmouseout='closeDetails();' /></div>";
		$return .= "<div style='float: left; padding-top: 8px;'>".$row->name."</div>";
		$return .= "<div style='float: right; padding-top: 8px;'>";
		$return .= "<div title='Edit' class='editBtn' style='float: left;' onclick='location=\"/admin/badges/edit/".$row->badgeID."\";'></div>";
		$return .= "<div title='Delete' class='deleteBtn' style='float: right;' onclick='deleteItem(".$row->badgeID.")'></div>";
		$return .= "<div style='clear: both;'></div>";
		$return .= "</div>";
		$return .= "<div style='clear: both'></div>";
		$return .= "</div>";
	}
	
	echo $return;
	
	die();
?>
