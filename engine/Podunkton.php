<?php
 /**
 *	Podunkton.php
 *	Core Crap
 *
 *	Written by Tyler Wright
 * 	Last Modified: 9.12.2008
 */

class Podunkton {
	
	function __construct() {
	}
	
	function stars($rating) {
		
		$return = "<div class='stars' style='width: 80px;'>";
		
		$fullStars = floor($rating);
		$half = $rating - $fullStars;
		
		if($half > .75) {
			$extra = 1;
			$backStars = 5 - ($fullStars+1);
		} elseif($half >= .25 AND $half <= .75) {
			$extra = 2;
			$backStars = 5 - ($fullStars+1);
		} else {
			$extra = 0;
			$backStars = 5 - $fullStars;
		}
		
		for($i=1; $i<=$fullStars; $i++) {
			$return .= "<div class='star_fill'></div>";
		}
		
		
		if($extra == 1) {
			$return .= "<div class='star_fill'></div>";
		} elseif($extra == 2) {
			$return .= "<div class='star_half'></div>";
		}
		
		for($i=1; $i<=$backStars; $i++) {
			$return .= "<div class='star_back'></div>";
		}
		
		$return .= "<div style='clear: both;'></div></div>";
		
		return $return;
	}
	
	function PrintUserTags($type, $userID) {
		global $database;
		
		$return = '';
		$i = 0;
		$resultActivities = $database->db_query("SELECT t.name FROM Tags as t JOIN Users_has_Tags as uht ON t.tagID = uht.tagID WHERE uht.userID = $userID AND uht.tagTypeID = $type");
		$numActRows = mysqli_num_rows($resultActivities);
		while($rowAct = mysqli_fetch_object($resultActivities)){
			$return .= "<a class='blue' href='/search/1/".$rowAct->name."'>".$rowAct->name."</a>";
			$i++;
			if($i != $numActRows){
				$return .= ", ";
			}
		}
		return $return;
	}
	
	function PrintUserTags2($type, $userID) {
		global $database;
		
		$return = '';
		$i = 0;
		$resultActivities = $database->db_query("SELECT t.name FROM Tags as t JOIN Users_has_Tags as uht ON t.tagID = uht.tagID WHERE uht.userID = $userID AND uht.tagTypeID = $type");
		$numActRows = mysqli_num_rows($resultActivities);
		while($rowAct = mysqli_fetch_object($resultActivities)){
			$return .= $rowAct->name;
			$i++;
			if($i != $numActRows){
				$return .= ", ";
			}
		}
		return $return;
	}
	
	/// Good/Evil start ///
	
	function goodevil($score) {
		
		$score += 38;
		
		$returnStr = "";
		
		if($score <= 25) {
			$returnStr .= "<div class='angel'></div>";
		}
		
		$returnStr .= "<div class='good_evil_bar'><div class='good_evil_marker' style='left: ".$score."px;'></div></div>";
		
		if($score >= 51) {
			$returnStr .= "<div class='devil'></div>";
		}
		
		$returnStr .= "<div style='clear: both;'></div>";
		
		echo $returnStr;
	}
	
	function goodevil2($score) {
		
		$score += 38;
		
		$returnStr = "";
		
		$returnStr .= "<td><div class='angel' style='float: none;'></div></td><td><div class='good_evil_bar' style='float: none;'><div class='good_evil_marker' style='left: ".$score."px;'></div></div></td><td><div class='devil' style='float: none;'></div></td>";	
		
		echo $returnStr;
	}
	
	function showAura($score) {
		if($score <= -18){
		$aura = "GOOD AURA";
		} elseif($score >= 18) {
			$aura = "EVIL AURA";
		} else {
			$aura = "NEUTRAL";
		}
		
		$score = -$score;
		
		echo "<span style='font-size: 7pt;'>".$score." ($aura)</span>";
		
	}
	
	function showAuraBig($score) {
		if($score <= -18){
		$aura = "GOOD AURA";
		} elseif($score >= 18) {
			$aura = "EVIL AURA";
		} else {
			$aura = "NEUTRAL";
		}
		
		$score = -$score;
		
		echo $score." ($aura)";
		
	}
	
	/// Good/Evil end ///
	
	function recentActivity($userID, $type, $msg) {
		global $database;
		global $session;

		// Get name
		$name = $session->username;

		$msg = addslashes("<a class='blue' href='/user/$name'>$name</a> ".$msg);

		// Add recent activity
		$result = $database->db_query("INSERT INTO Users_Recent_Activity(userID, message, dateAdded, timeAdded, activityTypeID) VALUES($userID, '$msg', NOW(), NOW(), (SELECT typeID FROM Recent_Activity_Types WHERE name = '$type'))");

		// Get num rows
		$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_Recent_Activity WHERE userID = $userID");
		$numRows = mysqli_fetch_object($result);

		if($numRows->count > 10) {
			$result = $database->db_query("SELECT id FROM Users_Recent_Activity WHERE userID = $userID ORDER BY timeAdded ASC LIMIT 0, 1");
			$rowID = mysqli_fetch_object($result);
			$id = $rowID->id;
			// Remove last row
			$result = $database->db_query("DELETE FROM Users_Recent_Activity WHERE id = $id");
		}

		return 1;
	}
	
	function recentActivitySignup($name, $userID, $type, $msg) {
		global $database;
		global $session;

		// Get name
		//$name = $session->username;

		$msg = addslashes("<a class='blue' href='/user/$name'>$name</a> ".$msg);

		// Add recent activity
		$result = $database->db_query("INSERT INTO Users_Recent_Activity(userID, message, dateAdded, timeAdded, activityTypeID) VALUES($userID, '$msg', NOW(), NOW(), (SELECT typeID FROM Recent_Activity_Types WHERE name = '$type'))");

		// Get num rows
		$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_Recent_Activity WHERE userID = $userID");
		$numRows = mysqli_fetch_object($result);

		if($numRows->count > 10) {
			$result = $database->db_query("SELECT id FROM Users_Recent_Activity WHERE userID = $userID ORDER BY timeAdded ASC LIMIT 0, 1");
			$rowID = mysqli_fetch_object($result);
			$id = $rowID->id;
			// Remove last row
			$result = $database->db_query("DELETE FROM Users_Recent_Activity WHERE id = $id");
		}

		return 1;
	}

	function showExp($exp){
		$returnStr = "";
		
		//$exp = 124;
		
		$level = $this->calculateLevel($exp);
		
		$boundArr = $this->getExpBounds($level);
		
		$percentage = ($exp-$boundArr[0])*100/($boundArr[1]-$boundArr[0]);
		
		$returnStr .= "<div class='xpside'></div><div class='xpmain'>";
		$returnStr .= "<div class='xpfill' style='width: $percentage%;'></div>";
		$returnStr .= "</div><div class='xpside'></div><div style='clear: both;'></div>";
		
		echo $returnStr;
		
	}
	
	function getExpBounds($level){
		$tmpArr = array();
		
		$baseExpForLevel = EXP_BASE_VAR*(($level-1)*EXP_MODIFIER);
		$nextLevelExp = EXP_BASE_VAR*(($level)*EXP_MODIFIER);
		
		array_push($tmpArr, $baseExpForLevel);
		array_push($tmpArr, $nextLevelExp);
		
		return $tmpArr;
	}
	
	function calculateLevel($exp, $expSpent = 0, $curLevel = 1){
		
		$expSpent = EXP_BASE_VAR*(($curLevel)*EXP_MODIFIER);
		if($expSpent >= $exp) {
			return $curLevel;
		}
		$curLevel++;
		return $this->calculateLevel($exp, $expSpent, $curLevel);
		
	}
	
	function imageAvatar($uid, $sex, $size, $offset, $name) {
		global $database;
		
		$return = '';
		$time = time();
		
		if($uid > 0){
			$resultCrew = $database->db_query("SELECT isCrew, crewAvatar FROM Users WHERE userID = $uid");
			$rowCrew = mysqli_fetch_object($resultCrew);
			
			if($rowCrew->isCrew == 0){
				// Send vars
				$return .= "<script type='text/javascript'>var flashvars = {uid: $uid, dummy: $time};";
				$return .= "var params = {menu: 'false', quality: 'high', wmode: 'transparent', bgcolor: '#ffffff'};";
				
				// SwfObject converter
				$return .= "swfobject.embedSWF('/characterBuilder/viewers/imageviewer_".$sex."_1.swf', '".$name."$offset', '$size', '$size', '8', '/engine/swfobject/expressInstall.swf', flashvars, params);</script>";
				
				$return .= "<div style='width: ".$size."px; height: ".$size."px;' id='".$name."$offset'>";
				$return .= "<p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a></p>";
				$return .= "</div>";
			} else {
				// Send vars
				$return .= "<script type='text/javascript'>var flashvars = {uid: $uid, dummy: $time, crewSwf: '".$rowCrew->crewAvatar."'};";
				$return .= "var params = {menu: 'false', quality: 'high', wmode: 'transparent', bgcolor: '#ffffff'};";
				
				// SwfObject converter
				$return .= "swfobject.embedSWF('/characterBuilder/viewers/crewavatar.swf', '".$name."$offset', '$size', '$size', '8', '/engine/swfobject/expressInstall.swf', flashvars, params);</script>";
				
				$return .= "<div style='width: ".$size."px; height: ".$size."px;' id='".$name."$offset'>";
				$return .= "<p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a></p>";
				$return .= "</div>";
			}
		}
		
		echo $return;
	}

	function imageAvatarReturn($uid, $sex, $size, $offset, $name) {
		global $database;
		
		$return = '';
		$time = time();
		
		if($uid > 0){
			$resultCrew = $database->db_query("SELECT isCrew, crewAvatar FROM Users WHERE userID = $uid");
			$rowCrew = mysqli_fetch_object($resultCrew);
			
			if($rowCrew->isCrew == 0){
				// Send vars
				$return .= "<script type='text/javascript'>var flashvars = {uid: $uid, dummy: $time};";
				$return .= "var params = {menu: 'false', quality: 'high', wmode: 'transparent', bgcolor: '#ffffff'};";
				
				// SwfObject converter
				$return .= "swfobject.embedSWF('/characterBuilder/viewers/imageviewer_".$sex."_1.swf', '".$name."$offset', '$size', '$size', '8', '/engine/swfobject/expressInstall.swf', flashvars, params);</script>";
				
				$return .= "<div style='width: ".$size."px; height: ".$size."px;' id='".$name."$offset'>";
				$return .= "<p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a></p>";
				$return .= "</div>";
			} else {
				// Send vars
				$return .= "<script type='text/javascript'>var flashvars = {uid: $uid, dummy: $time, crewSwf: '".$rowCrew->crewAvatar."'};";
				$return .= "var params = {menu: 'false', quality: 'high', wmode: 'transparent', bgcolor: '#ffffff'};";
				
				// SwfObject converter
				$return .= "swfobject.embedSWF('/characterBuilder/viewers/crewavatar.swf', '".$name."$offset', '$size', '$size', '8', '/engine/swfobject/expressInstall.swf', flashvars, params);</script>";
				
				$return .= "<div style='width: ".$size."px; height: ".$size."px;' id='".$name."$offset'>";
				$return .= "<p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a></p>";
				$return .= "</div>";
			}
		}
		
		return $return;
	}

	function addBadge($badgeID){
		global $session;
		global $database;
		global $sysmsg;
		
		$return = 0;
		
		if($session->user and $badgeID > 0){
			$userID = $session->user;
			
			$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_has_Badges WHERE userID = $userID AND badgeID = $badgeID");
			$row = mysqli_fetch_object($result);
			
			if($row->count < 1){
				$result = $database->db_query("INSERT INTO Users_has_Badges(userID, badgeID, dateAquired) VALUES($userID, $badgeID, NOW())");
				
				$result = $database->db_query("SELECT name, message FROM Badges WHERE badgeID = $badgeID");
				$row = mysqli_fetch_object($result);
				
				$sysmsg->send($userID, "System: New Badge!", $row->message);
				
				$msg = "acquired the ''".$row->name."' badge";
				$this->recentActivity($session->user, "gotBadge", $msg);
				
				$return = 1;
			}
			
		}
		
		echo $return;
		
	}
	
	function addBadgeReturn($badgeID){
		global $session;
		global $database;
		global $sysmsg;
		
		$return = 0;
		
		if($session->user and $badgeID > 0){
			$userID = $session->user;
			
			$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_has_Badges WHERE userID = $userID AND badgeID = $badgeID");
			$row = mysqli_fetch_object($result);
			
			if($row->count < 1){
				$result = $database->db_query("INSERT INTO Users_has_Badges(userID, badgeID, dateAquired) VALUES($userID, $badgeID, NOW())");
				
				$result = $database->db_query("SELECT name, message FROM Badges WHERE badgeID = $badgeID");
				$row = mysqli_fetch_object($result);
				
				$sysmsg->send($userID, "System: New Badge!", $row->message);
				
				$msg = "acquired the ''".$row->name."' badge";
				$this->recentActivity($session->user, "gotBadge", $msg);
				
				$return = 1;
			}
			
		}
		
		return $return;
		
	}
	
	function addBadgeSignup($badgeID, $userID, $name){
		global $session;
		global $database;
		global $sysmsg;
		
		$return = 1;
		
		$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_has_Badges WHERE userID = $userID AND badgeID = $badgeID");
		$row = mysqli_fetch_object($result);
		
		$result = $database->db_query("INSERT INTO Users_has_Badges(userID, badgeID, dateAquired) VALUES($userID, $badgeID, NOW())");
		
		$result = $database->db_query("SELECT name, message FROM Badges WHERE badgeID = $badgeID");
		$row = mysqli_fetch_object($result);
		
		$sysmsg->send($userID, "System: New Badge!", $row->message);
		
		$msg = "acquired the ''".$row->name."' badge";
		$this->recentActivitySignup($name, $userID, "gotBadge", $msg);
		
		echo $return;
		
	}
	
	function sendBeta() {
		global $database;
		global $sysmsg;
		
		$message = "Hey Beat Users,<br/><br/>We'd like to personally thank you for your help during our closed beta. As promised, we've added some goodies to your accounts and hope you'll stick around now that we've got the full site up and running. You guys are the pioneers of Podunkton! Think of yoruselves as pilgrims, looking to kill some indians. When the indians show up now that we're launched, you be sure you discriminate with extreme prejudice!<br/><br/>Ok, ok, I'm just kidding. But seriously, we really appreciate you helping us and look forward to hopefully continuing to have your help as we press into a much bigger realm. We may not remember every single one of you by name, but just know that you will always be remembered as making this possible in some way. Thanks much, and enjoy your presents!<br/><br/>See you guys around Podunkton!'";
		
		$result = $database->db_query("SELECT userID FROM Users WHERE 1");
		while($row = mysqli_fetch_object($result)){
			$sysmsg->send($row->userID, "System: BETA USER!", $message);
		}
		
	}

}

$podunkton = new Podunkton;

?>
