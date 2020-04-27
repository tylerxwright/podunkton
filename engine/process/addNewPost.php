<?php
	include_once("engine/Converter.php");

	global $database;
	global $error;
	global $msgObj;
	global $core;
	global $session;
	global $podunkton;
	
	$purifier = new HTMLPurifier();
	
	$pollArr = array();
	
	$errorVal = 0;
	
	$message = $_POST['message'];
	$threadID = $_POST['threadID'];
	$safeName = $_POST['safeName'];
	$page = $_POST['page'];
	$type = $_POST['type'];
	$user = $session->user;
	$diceExists = $_POST['diceExists'];
	$randomExists = $_POST['randomExists'];
	$actionOn = 0;
	
	srand(time());
	
	if($type != "post") {
		$postID = $_POST['postID'];
	}
	
	if($message == "") { // Need to check length as well
		$error->setError("You must have something to say");
		header("Location: /forums");
		$errorVal++;
	}
	
	if($diceExists == 1){
		$dice = $_POST['dice'];
		$diceRoll = rand(1, $dice);
		$actionMessage = "<a class='blue' href='/user/".$session->username."'>".$session->username."</a> rolled a ".$dice."-sided dice and it came up with ".$diceRoll;
		$actionOn = 1;
	} else {
		$diceExists = 0;
	}
	
	if($randomExists == 1){
		$randomMin = abs($_POST['minRand']);
		$randomMax = abs($_POST['maxRand']);
		
		if($randomMin == ""){
			if($randomMax == "") { 
				$randomMin = 1;
			} else {
				$randomMin = rand(0, $randomMax-1);
			}
		}
		
		if($randomMax == ""){ 
			if($randomMin == "") { 
				$randomMax = 100;
			} else {
				$randomMax = rand($randomMin+1, $randomMin+100);
			}
		}
		
		if($randomMax < $randomMin){
			$randomMax = $randomMin + 1;
		}
		
		$randomNumber = rand($randomMin, $randomMax);
		$actionMessage = "<a class='blue' href='/user/".$session->username."'>".$session->username."</a> gave chance a try and chance gave him the number ".$randomNumber;
		$actionOn = 1;
	} else {
		$randomExists = 0;
	}
	
	$clean_html = $purifier->purify($message);
	
	if($type == "quote") {
		$quoteResult = $database->db_query("SELECT u.userID, u.name, f.post FROM Users as u JOIN Forum_Post as f ON u.userID = f.author WHERE postID=".$postID);
		$rowQ = mysqli_fetch_object($quoteResult);
		$clean_html = "[quote]".$rowQ->post."[/quote]".$clean_html;
		$clean_html = $converter->convert($clean_html, $rowQ->name);
	} else {
		$clean_html = $converter->convert($clean_html, "");
	}
	
	$clean_html = addslashes($clean_html);
	
	$clean_html = nl2br($clean_html);
	
	if($errorVal == 0){
		
		if($actionOn == 1){
			$actionMessage = addslashes($actionMessage);
			
			$result = $database->db_query("INSERT INTO Forum_Actions(message) VALUES('$actionMessage')");
			$actionID = mysql_insert_id();	
		} else {
			$actionID = 0;
		}
		
		if($type == "reply") {
			$result = $database->db_query("INSERT INTO Forum_Post(threadID, post, author, dateAdded, tolerance, parent, actionID) VALUES($threadID, '$clean_html', $user, NOW(), 0, $postID, $actionID)");
		} else {
			$result = $database->db_query("INSERT INTO Forum_Post(threadID, post, author, dateAdded, tolerance, actionID) VALUES($threadID, '$clean_html', $user, NOW(), 0, $actionID)");
		}
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
		}
		else
		{
			// Update exp and munniez
			$updateU = $database->db_query("UPDATE Users SET experience = experience+".EXP_PER_POST.", posts = posts+1, munniez = munniez + ".MUNNIEZ_PER_POST." WHERE userID=$user");
			$msgObj->setMsg("You got ".EXP_PER_POST." experience points and ".MUNNIEZ_PER_POST." munniez for posting!");
		

			$result = $database->db_query("SELECT c.name FROM Forum_Category as c JOIN Forum_Subcategory as s ON c.categoryID = s.categoryID WHERE s.safeName = '$safeName'");
			$rowName = mysqli_fetch_object($result);
			$rName = $rowName->name;
			$msg = "posted in <a class='blue' href='/forums/$safeName/oldest/$threadID'>$rName</a>";
			$podunkton->recentActivity($session->user, "postedForum", $msg);
			
			$result = $database->db_query("SELECT posts FROM Users WHERE userID = ".$session->user);
			$row = mysqli_fetch_object($result);
			
			switch($row->posts){
				case 10:
					$podunkton->addBadge(2);
					break;
				case 50:
					$podunkton->addBadge(3);
					break;
				case 100:
					$podunkton->addBadge(4);
					break;
				case 500:
					$podunkton->addBadge(5);
					break;
				case 1000:
					$podunkton->addBadge(6);
					break;
				case 2500:
					$podunkton->addBadge(7);
					break;
				case 5000:
					$podunkton->addBadge(8);
					break;
				case 10000:
					$podunkton->addBadge(9);
					break;
				case 20000:
					$podunkton->addBadge(10);
					break;
				case 30000:
					//$podunkton->addBadge(11);
					break;
				case 50000:
					//$podunkton->addBadge(11);
					break;
				case 100000:
					$podunkton->addBadge(11);
					break;
				case 250000:
					$podunkton->addBadge(12);
					break;
				case 500000:
					$podunkton->addBadge(13);
					break;
				case 1000000:
					$podunkton->addBadge(14);
					break;
			}
		}
		
		$_SESSION['post_timer'] = time();
		
		header("Location: /forums/".$safeName."/oldest/$threadID/$page");
	}
	
?>
