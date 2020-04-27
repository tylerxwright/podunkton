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
	$tagsArr = array();
	
	$errorVal = 0;
	
	$subject = strip_tags($purifier->purify($_POST['subject']));
	$tags = strip_tags($purifier->purify($_POST['tags']));
	$message = $_POST['message'];
	$pollExists = $_POST['pollExists'];
	$subcategoryID = $_POST['subcategoryID'];
	$user = $session->user;
	$category = $core->args[1];
	$toleranceMin = $_POST['toleranceMin'];
	$diceExists = $_POST['diceExists'];
	$randomExists = $_POST['randomExists'];
	$actionOn = 0;
	
	srand(time());
	
	$result2 = $database->db_query("SELECT safeName, adminOnly FROM Forum_Subcategory WHERE subcategoryID=$subcategoryID");
	$row2 = mysqli_fetch_object($result2);
	
	if($row2->adminOnly == 1 and !$session->admin){
		$error->setError("Only admins can post here");
		header("Location: /forums/".$row2->safeName);
		die();
	}
	
	if($pollExists == "on") {
		$pollQuestion = strip_tags($_POST['pollQuestion']);
		$pollLength = strip_tags($_POST['pollLength']);
		array_push($pollArr, strip_tags($_POST['pollOption1']));
		
		if($pollQuestion == ""){
			$error->setError("You must give your poll a question");
			header("Location: /forums/".$row2->safeName);
			die();
		}
		
		if($pollLength == "") {
			$pollLength = 0;
		}
		
		if($pollArr[0] == "") {
			$error->setError("Your poll must have at least one question");
			header("Location: /forums/".$row2->safeName."/newtopic");
			$errorVal++;
		}
		
		$counter = 2;
		while($option = $_POST['pollOption'.$counter]) {
			if($option != ""){
				array_push($pollArr, $option);
			}
			$counter++;
		}
		
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
	
	// User decided tolerance
	$toleranceMin = abs($toleranceMin);
	
	if(!is_numeric($toleranceMin)) {
		$toleranceMin = 11111;
	}
	
	if(!$toleranceMin) {
		$toleranceMin = 11111;
	}
	
	
	if($tags != "") {
		$tagsArr = explode(",", $tags);
	}
	
	if($subject == "") {
		$error->setError("You must give your topic a subject");
		header("Location: /forums/".$row2->safeName."/newtopic");
		$errorVal++;
	}
	
	if($message == "") { // Need to check length as well
		$error->setError("You must have something to say");
		header("Location: /forums/".$row2->safeName."/newtopic");
		$errorVal++;
	}
	
	$clean_html = $purifier->purify($message);
	
	$clean_html = $converter->convert($clean_html, "");
	
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
		
		$result = $database->db_query("INSERT INTO Forum_Thread(subject, author, dateAdded, tolerance, subcategoryID, toleranceMin) VALUES('$subject', $user, NOW(), 0, $subcategoryID, $toleranceMin)");
		$threadID = mysql_insert_id();
		
		$result = $database->db_query("INSERT INTO Forum_Post(threadID, post, author, dateAdded, tolerance, actionID) VALUES($threadID, '$clean_html', $user, NOW(), 0, $actionID)");
		$postID = mysql_insert_id();
		
		foreach($tagsArr as $tag){
			$tagResult = $database->db_query("SELECT tagID, name FROM Tags WHERE name='$tag'");
			if(mysqli_num_rows($tagResult) > 0) {
				$row = mysqli_fetch_object($tagResult);
				$tagID = $row->tagID;
			} else {
				$resultTags = $database->db_query("INSERT INTO Tags(name) VALUES('$tag')");
				$tagID = mysql_insert_id();
			}
			
			$resultHasTags = $database->db_query("INSERT INTO Thread_has_Tags(threadID, tagID) VALUES($threadID, $tagID)");
		}
		
		if($pollExists == "on") {
			$result = $database->db_query("INSERT INTO Forum_Poll(question, length, threadID) VALUES('$pollQuestion', $pollLength, $threadID)");
			$pollID = mysql_insert_id();
			
			foreach($pollArr as $option) {
				$result = $database->db_query("INSERT INTO Forum_Poll_Option(optionQ, pollID) VALUES('$option', $pollID)");
			}
		}
		
		if (!$result)
		{
			$error->setError("There was a snake in my boot!");
			header("Location: /forums/".$row2->safeName."/newtopic");
		}
		else
		{
			$updateU = $database->db_query("UPDATE Users SET experience = experience+".EXP_PER_POST.", posts = posts+1, munniez = munniez + ".MUNNIEZ_PER_TOPIC." WHERE userID=$user");
			$msgObj->setMsg("You got ".EXP_PER_TOPIC." experience points and ".MUNNIEZ_PER_TOPIC." munniez for creating a new topic!");
			
			$result = $database->db_query("SELECT c.name FROM Forum_Category as c JOIN Forum_Subcategory as s ON c.categoryID = s.categoryID WHERE s.safeName = '".$row2->safeName."'");
			$rowName = mysqli_fetch_object($result);
			$rName = $rowName->name;
			$msg = "created a topic in <a class='blue' href='/forums/".$row2->safeName."/oldest/$threadID'>$rName</a>";
			$podunkton->recentActivity($session->user, "startTopic", $msg);
			
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
			
			$_SESSION['post_timer'] = time();
			
			header("Location: /forums/".$row2->safeName."/oldest/$threadID");
		}
	}
	
?>