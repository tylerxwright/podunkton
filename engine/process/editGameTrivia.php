<?php
	global $database;
	global $error;
	global $msgObj;
	
	$gameID = $_POST['gameID'];
	$triviaID = $_POST['triviaID'];
	$trivia = $_POST['trivia'];
	$order = $_POST['order'];
	
	if($order == "") {
		$order = 10;
	}
	
	if($trivia == "") {
		$error->setError("You must give this trivia item some text");
		header("Location: /admin/game/trivia/edit/$gameID/$triviaID");
		die();
	}
	
	$result = $database->db_query("UPDATE Games_Trivia SET triviaOrder = $order, trivia = '$trivia' WHERE triviaID = $triviaID");
	if(!result) {
		$error->setError("Error: Update of trivia item failed");
		header("Location: /admin/game/trivia/edit/$gameID/$triviaID");
		die();
	}
	
	$msgObj->setMsg("You updated a trivia item");
	header("Location: /admin/game/$gameID");
	die();
	
?>