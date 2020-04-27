<?php
	global $database;
	global $error;
	global $msgObj;
	
	$gameID = $_POST['gameID'];
	$order = $_POST['order'];
	$trivia = $_POST['trivia'];
	
	if($order == "") {
		$order = 10;
	}
	
	if($trivia == "") {
		$error->setError("You must give this trivia item some text");
		header("Location: /admin/game/trivia/add/$gameID");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Games_Trivia(triviaOrder, trivia, gameID) VALUES ($order, '$trivia', $gameID)");
	if(!result) {
		$error->setError("Error: Insert of new trivia failed");
		header("Location: /admin/game/trivia/add/$gameID");
		die();
	}
	
	$msgObj->setMsg("You added a new trivia item");
	header("Location: /admin/game/$gameID");
	die();
	
?>