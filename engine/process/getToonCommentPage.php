<?php
	global $database;
	global $core;
	global $prettyprint;
	
	$toonID = $core->args[2];
	$page = $core->args[3];
	
	$startRow = ($page-1)*COMMENTS_PER_PAGE;
	
	$return = "";
	$i = 0;
	$result = $database->db_query("SELECT u.name, u.userID, u.sex, tc.comment, tc.dateSubmitted FROM Users as u JOIN Toons_Comments as tc ON tc.userID = u.userID WHERE tc.toonID = $toonID ORDER BY tc.dateSubmitted DESC LIMIT $startRow, ".COMMENTS_PER_PAGE);
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
		
		$i++;
	}
	
	echo $return;
	die();
?>

