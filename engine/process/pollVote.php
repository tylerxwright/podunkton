<?php
	global $database;
	global $error;
	global $msgObj;
	global $core;
	global $session;
	
	$purifier = new HTMLPurifier();
	
	header('Content-Type: text/plain');
	
	$optionArr = array();
	$total = 0;
	$pollID = 0;
	$user = $session->user;
	$return = "<table border='0' style='width: 780px;'>";
	
	if(is_numeric($core->args[2])){
		$optionID = $purifier->purify($core->args[2]);
		
		$result = $database->db_query("UPDATE Forum_Poll_Option SET votes = votes+1 WHERE optionID=".$optionID);
	}
	
	$result = $database->db_query("SELECT fo.optionQ, fo.votes, fo.pollID FROM Forum_Poll_Option as fo WHERE fo.pollID = (SELECT o.pollID FROM Forum_Poll_Option as o WHERE optionID=".$optionID." )");
	while($row = mysqli_fetch_object($result)) {
		$pollID = $row->pollID;
		$tmp = array($row->optionQ, $row->votes);
		array_push($optionArr, $tmp);
		$total += $row->votes;
	}
	
	$insert = $database->db_query("INSERT Forum_Poll_Users(pollID, userID) VALUES($pollID, $user)");
	$result = $database->db_query("UPDATE Users SET munniez = munniez + ".MUNNIEZ_PER_POLL." WHERE userID = $user");
	
	foreach($optionArr as $option) {
		if($option[1] == 0){
			$percent = 0;
		} else {
			$percent = $option[1]*100/$total;
		}
		$return .= "<tr><td width='47%' align='right'>".$option[0].": </td><td width='53%' align='left' style='padding-top: 5px;'><div class='xpside'></div><div class='xpmain'><div class='xpfill' style='width: ".$percent."%;'></div></div><div class='xpside'></div><div style='float: left; font-size: 7pt; line-height: 4pt; padding-left: 5px;'>".round($percent)."%</div><div style='clear: both;'></div></td></tr>";
	}
	
	print $return.="</table>";
	
	// Ajax apps must die!
	die();
?>