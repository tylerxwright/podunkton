<?php
	include_once("engine/Converter.php");

	global $database;
	global $session;
	global $core;
	global $prettyprint;
	
	$purifier = new HTMLPurifier();
	
	$gameID = $core->args[2];
	$userID = $session->user;
	$text = $purifier->purify($core->args[3]);
	
	$return = "";
	
	if($session->user AND $text != "") {
		$result = $database->db_query("INSERT INTO Games_Comments(gameID, userID, comment, dateSubmitted) VALUES($gameID, $userID, '$text', NOW())");
		$result = $database->db_query("SELECT u.name, u.userID, u.sex, tc.dateSubmitted, tc.comment FROM Users as u JOIN Games_Comments as tc ON u.userID = tc.userID WHERE tc.gameID = $gameID ORDER BY tc.dateSubmitted DESC LIMIT 0, ".COMMENTS_PER_PAGE);
		while($row = mysqli_fetch_object($result)){
			$uid = $row->userID;
			$sex = $row->sex;
			$size = 35;
			
			$return .=  "<div class='user_comment_left'>";
			
			$return .= "<div class='user_comment_icon'>";
			$return .= "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0' width='$size' height='$size' id='imageviewer_".$sex."_1' align='middle'>";
			$return .= "<param name='allowScriptAccess' value='sameDomain' />";
			$return .= "<param name='movie' value='/characterBuilder/viewers/imageviewer_".$sex."_1.swf?uid=$uid&dummy=$time' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' /><embed src='/characterBuilder/viewers/imageviewer_".$sex."_1.swf?uid=$uid&dummy=$time' quality='high' bgcolor='#ffffff' width='$size' height='$size' name='imageviewer_".$sex."_1' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />";
			$return .= "</object>";
			$return .= "</div>";
			
			$return .= "</div><div class='user_comment_right'>";
			$return .= "<div class='user_comment_top'><a class='blue' href='/user/".$row->name."'>".$row->name."</a> said<br/>at ".$prettyprint->prettydate($row->dateSubmitted, "[x][cz] on [m] [d], [Y]")."</div>";
			$return .= "<div class='user_comment_bot'>";
			$return .= $row->comment;
			$return .= "</div></div><div style='clear: both;'></div>";
		}
		echo $return;
		die();
	} else {
		echo "Error";
		die();
	}
	
?>