<?php
	global $database;
	global $session;
	global $core;
	
	$page = $core->args[2];
	$return = "";
	
	if(!$session->user){
		die();
	}
	
	$result = $database->db_query("SELECT name, png, itemID FROM Items WHERE groups = 0 LIMIT ".($page-1)*ADMIN_ITEMS_PER_PAGE.", ".ADMIN_ITEMS_PER_PAGE);
	while($row = mysqli_fetch_object($result)){
		$return .= "<div style='width: 100%; border-bottom: solid 1px #333;'>";
		$return .= "<div style='float: left; padding-right: 10px;'><img src='/characterBuilder/images/".$row->png."' onmouseover='getDetails(1, ".$row->itemID.")' onmouseout='closeDetails();' /></div>";
		$return .= "<div style='float: left; padding-top: 8px;'>".$row->name."</div>";
		$return .= "<div style='float: right; padding-top: 8px;'>";
		$return .= "<div title='Edit' class='editBtn' style='float: left;' onclick='location=\"/admin/characterBuilder/item/edit/".$row->itemID."\";'></div>";
		$return .= "<div title='Delete' class='deleteBtn' style='float: right;' onclick='deleteItem(".$row->itemID.")'></div>";
		$return .= "<div style='clear: both;'></div>";
		$return .= "</div>";
		$return .= "<div style='clear: both'></div>";
		$return .= "</div>";
	}
	
	echo $return;
	
	die();
?>

