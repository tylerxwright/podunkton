<?php
	global $core;
	global $session;
	global $error;
	
	$purifier = new HTMLPurifier();
	
	$success = $session->login($purifier->purify($_POST['user']), $purifier->purify($_POST['pass']), $purifier->purify($_POST['remember']));
	
	if(!$success){
		$error->setError("Login incorrect");
	}
	
	// Fix this!
	//header('Location: /' . $session->referrer);
	header("Location: /");
?>