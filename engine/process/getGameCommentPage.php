<?php
	global $database;
	global $core;
	global $prettyprint;
	global $podunkton;
	
	$gameID = $core->args[2];
	$page = $core->args[3];
	
	$startRow = ($page-1)*COMMENTS_PER_PAGE;
	
	$return = "";
	$i = 0;
	$result = $database->db_query("SELECT u.name, u.userID, u.sex, tc.comment, tc.dateSubmitted FROM Users as u JOIN Games_Comments as tc ON tc.userID = u.userID WHERE tc.gameID = $gameID ORDER BY tc.dateSubmitted DESC LIMIT $startRow, ".COMMENTS_PER_PAGE);
	while($row = mysqli_fetch_object($result)){
		$uid = $row->userID;
		$sex = $row->sex;
		$size = 35;
		
		$return .=  "<div class='user_comment_left'>";
		
		$return .= "<div class='user_comment_icon'>";
		$return .= $podunkton->imageAvatar($row->userID, $row->sex, 35, $i, "toonCommentAvatar");
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
