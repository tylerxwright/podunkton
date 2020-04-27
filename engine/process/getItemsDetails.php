<?php
	global $database;
	global $session;
	global $core;
	global $prettyprint;
	
	$itemID = $core->args[2];
	$return = "";
	
	if(!$session->user){
		die();
	}
	
	$result = $database->db_query("SELECT i.*, s.name as 'storeName' FROM Items as i JOIN Store as s ON i.store = s.storeID WHERE itemID = $itemID");
	$row = mysqli_fetch_object($result);
	
	$return .= "<table border='0' width='100%' style='font-size: 9pt;'>";
	$return .= "<tr><td colspan='2' style='border-bottom: solid 1px #333; color: #fff; background-color: #647DB8;'><b>Item Name:".$row->name."</b></td></tr>";
	$return .= "<tr><td width='20%'>Image: </td><td><img src='/characterBuilder/images/".$row->png."' /></td></tr>";
	$return .= "<tr><td>Munniez: </td><td>".$row->munniez."</td></tr>";
	$return .= "<tr><td>Credits: </td><td>".$row->credits."</td></tr>";
	$return .= "<tr><td>Shop: </td><td>".$row->storeName."</td></tr>";
	//$return .= "<tr><td>Default: </td><td>".$row->isDefault."</td></tr>";
	$return .= "<tr><td>Type: </td><td>".$row->type."</td></tr>";
	$return .= "<tr><td>Sex: </td><td>".$row->sex."</td></tr>";
	//$return .= "<tr><td>Added on: </td><td>".$prettyprint->prettydate($row->dateAdded, "[M] [D], [Y]")."</td></tr>";
	$return .= "<tr><td valign='top'>Description: </td><td>".$row->description."</td></tr>";
	$return .= "</table>";
	
	echo $return;
	die();
	
?>