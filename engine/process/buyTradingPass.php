<?php
/*
 * Created on Oct 6, 2008
 */
	global $database;
	global $session;
	global $error;
	global $msgObj;
	global $podunkton;
	
	$userID = $session->user;
	
	if(!$userID) {
		$error->setError("You must be logged in to buy a trading pass!");
		header("Location: /trade");
		die();
	}
	
	// Check for existing pass
	$result = $database->db_query("SELECT tradePass, munniez FROM Users WHERE userID = $userID");
	$row = mysqli_fetch_object($result);
	if($row->tradePass) {
		$error->setError("You already own a trading pass! Why buy another?");
		header("Location: /trade");
		die();
	}
	
	// Check for enough munniez
	if($row->munniez < TRADING_PASS_COST){
		$error->setError("You don't have enough munniez, a trading pass costs ".TRADING_PASS_COST."mz. You only have ".$row->munniez);
		header("Location: /trade");
		die();
	}
	
	// Buy pass
	$result = $database->db_query("UPDATE Users SET munniez = munniez - ".TRADING_PASS_COST.", tradePass = 1 WHERE userID = $userID");
	if(!$result){
		$error->setError("There was an error when trying to buy your pass. Please try again. If it persists, please contact Vallos at vallosdck@gmail.com");
		header("Location: /trade");
		die();
	} else {
		$msg = "bought a trading pass!";
		$podunkton->recentActivity($session->user, "itemPurchase", $msg);
		$msgObj->setMsg("You purchased a shiny new trading pass, now you can trade all you want!");
		header("Location: /trade");
		die();
	}
	
?>

