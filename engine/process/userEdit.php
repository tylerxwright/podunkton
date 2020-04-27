<?php
	//include('engine/htmlpurifier/library/HTMLPurifier.auto.php');

	global $session;
	global $database;
	global $core;
	global $error;
	global $msgObj;
	global $podunkton;
	
	$user = $session->user;
	$username = $session->username;
	
	if($user) {
		
		$catchphrase = cleanInput($_POST['catchphrase']);
		$realName = cleanInput($_POST['realName']);
		$sign = cleanInput($_POST['sign']);
		$email = cleanInput($_POST['email']);
		$aim = cleanInput($_POST['aim']);
		$website = cleanInput($_POST['website']);
		$activities = nl2br(cleanInput($_POST['activities']));
		$music = nl2br(cleanInput($_POST['music']));
		$movies = nl2br(cleanInput($_POST['movies']));
		$television = nl2br(cleanInput($_POST['television']));
		$quotes = nl2br(cleanInput($_POST['quotes']));
		
		tagIt($activities, 1);
		tagIt($music, 2);
		tagIt($movies, 3);
		tagIt($television, 4);
		
		if(!valid_email($email)) {
			$error->setError("The email you entered is not valid");
			header("Location: /$username");
		}
		
		$result = $database->db_query("UPDATE Users SET catchphrase = '$catchphrase', realName = '$realName', sign = '$sign', email = '$email', aim = '$aim', website = '$website', quotes = '$quotes' WHERE userID = $user");
		
		$msg = "updated their information";
		$podunkton->recentActivity($session->user, "edittedProfile", $msg);
		
		$msgObj->setMsg("Your info has been updated!");
		header("Location: /user/$username");
		die();
	} else {
		$error->setError("You must be logged in to edit your account!");
		header("Location: /");
		die();
	}
	
	function cleanInput($text) {
		$purifier = new HTMLPurifier();
		$text = $purifier->purify($text);
		$text = addslashes($text);
		return $text;
	}
	
	function tagIt($str, $type) {
		global $session;
		global $database;
		
		$tmpArr = explode(",", $str);
		foreach($tmpArr as $tag) {
			$newTag = strtolower(trim($tag));
			
			$result = $database->db_query("SELECT COUNT(tagID) as 'count', tagID FROM Tags WHERE name = '$newTag' GROUP BY tagID");
			$rowCount = mysqli_fetch_object($result);
			if($rowCount->count == 0){
				$result = $database->db_query("INSERT INTO Tags(name) VALUES('$newTag')");
				$id = mysql_insert_id();
				$result = $database->db_query("INSERT INTO Users_has_Tags(userID, tagID, tagTypeID) VALUES(".$session->user.", $id, $type)");
			} else {
				$result = $database->db_query("SELECT COUNT(uht.id) as 'count' FROM Users_has_Tags as uht WHERE uht.userID = ".$session->user." AND uht.tagID = (SELECT t.tagID FROM Tags as t WHERE t.name = '$newTag') GROUP BY uht.id");
				$rowCount2 = mysqli_fetch_object($result);
				if($rowCount2->count == 0) {
					$result = $database->db_query("INSERT INTO Users_has_Tags(userID, tagID, tagTypeID) VALUES(".$session->user.", ".$rowCount->tagID.", $type)");
				}
			}
		}
	}
	
	function valid_email($email) {
	  // First, we check that there's one @ symbol, and that the lengths are right
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	  }
	  // Split it into sections to make life easier
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++) {
		 if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
		  return false;
		}
	  }  
	  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
		  if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
			return false;
		  }
		}
	  }
	  return true;
	} 
?>