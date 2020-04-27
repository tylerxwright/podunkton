<?php
	global $core;
	global $database;
	global $session;
	
	$vote = $core->args[2];
	$thumbID = $core->args[3];
	$postID = $core->args[4];
	$user = $session->user;
	
	$str = "";
	
	if($vote == 1) {
		$vote = -1;
	} elseif($vote == 2) {
		$vote = 1;
	} else {
		echo "fail";
		die();
	}
	
	if($user) {
		$result = $database->db_query("UPDATE Forum_Post SET tolerance = tolerance + $vote WHERE postID = $postID");
		
		$result = $database->db_query("SELECT p.threadID, p.tolerance, p.author, u.goodevil FROM Forum_Post as p JOIN Users as u ON p.author = u.userID WHERE postID = $postID");
		$row = mysqli_fetch_object($result);
		
		$author = $row->author;
		$goodevil = $row->goodevil;
		
		if($vote == 1) {
			$newmunniez = MUNNIEZ_PER_THUMB;
			if($goodevil != 37) {
				$newgoodevil = $goodevil - 1;
			} else {
				$newgoodevil = $goodevil;
			}
			$newTolerance = $row->tolerance + 1;
		} else {
			$newmunniez = 0;
			if($goodevil != -37) {
				$newgoodevil = $goodevil + 1;
			} else {
				$newgoodevil = $goodevil;
			}
			$newTolerance = $row->tolerance - 1;
		}
		
		$result = $database->db_query("UPDATE Forum_Thread SET tolerance = tolerance + $vote WHERE threadID = ".$row->threadID);
		
		$result = $database->db_query("UPDATE Users SET goodevil = $newgoodevil, munniez = munniez + $newmunniez WHERE userID = $author");
		$result = $database->db_query("UPDATE Users SET experience = experience + ".EXP_PER_THUMB." WHERE userID = $user");
		
		$result = $database->db_query("INSERT INTO Forum_Thumb_Users(userID, postID) VALUES($user, $postID)");
		
		if($row->tolerance > 0) {
			$str = "+".$row->tolerance;
		} elseif($row->tolerance < 0) {
			$str = $row->tolerance;
		} else {
			$str = $row->tolerance;
		}
		
		$result = $database->db_query("SELECT COUNT(userID) as 'count' FROM Forum_Thumb_Users WHERE userID = $user");
		$row = mysqli_fetch_object($result);
		if($row->count == 100){
			$podunkton->addBadge(16);
		}
		
	}
	
	echo "<div class='forums_thumb_vote'>".$str." Thumbs</div>";
	die();
	
?>