<?php
	global $core;
	global $session;
	global $error;
	global $database;		
	
	$purifier = new HTMLPurifier();
	
	$errorExists = 0;
	$success = 0;
	
	$uname = $purifier->purify($_POST['uname']);
	$pword = $purifier->purify($_POST['pword']);
	$pword2 = $purifier->purify($_POST['pword2']);
	$sex = $purifier->purify($_POST['sex']);
	$month = $_POST['month'];
	$day = $_POST['day'];
	$year = $_POST['year'];
	$email = $_POST['email'];
	$aim = $_POST['aim'];
	$msn = $_POST['msn'];
	$icq = $_POST['icq'];
	
	if(isset($_POST['admin'])){
		$goodevil = $_POST['goodevil'];
		$points = $_POST['points'];
		$rankid = $_POST['rankid'];
		$experience = $_POST['experience'];
		$favoriteToon = $_POST['favoriteToon'];
		$favoriteGame = $_POST['favoriteGame'];
		$featured = $_POST['featured'];
		$forumView = $_POST['forumView'];
		$permissions = $_POST['permissions'];
	}
	
	if($uname == ""){
		$errorExists = 1;
		$error->setError("You must enter a valid username");
	}
	
	if($pword != $pword2){
		$errorExists = 1;
		$error->setError("Passwords don't match");
	}
	
	if($month == ""){
		$errorExists = 1;
		$error->setError("You must fill out your birthday's month");
	}
	
	if($day == ""){
		$errorExists = 1;
		$error->setError("You must fill out your birthday's day");
	}
	
	if($year == ""){
		$errorExists = 1;
		$error->setError("You must fill out your birthday's year");
	}
	
	if($email == ""){
		$errorExists = 1;
		$error->setError("You must fill out your email");
	}
	
	if($day < 10){
		$date = $year."-".$month."-0".$day;
	} else {
		$date = $year."-".$month."-".$day;
	}
	
	if(!$errorExists){
		if(isset($_POST['admin'])){
			$success = $database->registerFull($uname, $pword, $sex, $date, $email, $aim, $msn, $icq, $goodevil, $points, $rankid, $experience, $favoriteToon, $favoriteGame, $featured, $forumView, $permissions);
		} else {
			$success = $session->register($uname, $pword, $sex, $date, $email, $aim, $msn, $icq);
		}
	}
	
	if(!$success){
		$errorExists = 1;
		$error->setError("Failed to register");
		
	}
	
	if($errorExists){
		header('Location: /' . $session->referrer);
	} else {
		if(isset($_POST['admin'])){
			$error->setError("User Added");
			header('Location: /admin');
		} else {
			$session->login($uname, $pword, 0);
			header('Location: /');
		}
	}
?>