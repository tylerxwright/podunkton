<?php
	global $database;
	global $error;
	global $msgObj;
	
	$toonID = $_POST['toonID'];
	$order = $_POST['order'];
	$trivia = $_POST['trivia'];
	
	if($order == "") {
		$order = 10;
	}
	
	if($trivia == "") {
		$error->setError("You must give this trivia item some text");
		header("Location: /admin/toon/trivia/add/$toonID");
		die();
	}
	
	$result = $database->db_query("INSERT INTO Toons_Trivia(triviaOrder, trivia, toonID) VALUES ($order, '$trivia', $toonID)");
	if(!result) {
		$error->setError("Error: Insert of new trivia failed");
		header("Location: /admin/toon/trivia/add/$toonID");
		die();
	}
	
	$msgObj->setMsg("You added a new trivia item");
	header("Location: /admin/toon/$toonID");
	die();
	
?>