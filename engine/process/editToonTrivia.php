<?php
	global $database;
	global $error;
	global $msgObj;
	
	$toonID = $_POST['toonID'];
	$triviaID = $_POST['triviaID'];
	$trivia = $_POST['trivia'];
	$order = $_POST['order'];
	
	if($order == "") {
		$order = 10;
	}
	
	if($trivia == "") {
		$error->setError("You must give this trivia item some text");
		header("Location: /admin/toon/trivia/edit/$toonID/$triviaID");
		die();
	}
	
	$result = $database->db_query("UPDATE Toons_Trivia SET triviaOrder = $order, trivia = '$trivia' WHERE triviaID = $triviaID");
	if(!result) {
		$error->setError("Error: Update of trivia item failed");
		header("Location: /admin/toon/trivia/edit/$toonID/$triviaID");
		die();
	}
	
	$msgObj->setMsg("You updated a trivia item");
	header("Location: /admin/toon/$toonID");
	die();
	
?>