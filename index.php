<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

include_once("engine/Core.php");
include_once('engine/htmlpurifier/library/HTMLPurifier.auto.php');

$core->setArgs($_GET['q']);

// This is a hack!
if($core->args[0] == "popout_box"){
	include_once("theme/scripts/popout_box.php");
	die();
}

// Another hack!
if($session->user) {
	if($core->args[0] == "forums") {
		$result = $database->db_query("UPDATE Users_online SET inForums = 1 WHERE userid = ".$session->user);
	} else {
		$result = $database->db_query("UPDATE Users_online SET inForums = 0 WHERE userid = ".$session->user);
	}
	
	$result = $database->db_query("SELECT COUNT(uo.userid) as 'count' FROM Users_online as uo WHERE uo.inForums = 1");
	$rowForums = mysqli_fetch_object($result);
	
	$result = $database->db_query("SELECT Most_Users_In_Forums as 'most' FROM Site_Variables");
	$rowForums2 = mysqli_fetch_object($result);
	
	if($rowForums->count > $rowForums2->most) {
		$result = $database->db_query("UPDATE Site_Variables SET Most_Users_In_Forums = ".$rowForums->count);
	}
	
}

if(BETA == 1) {
	if($_SESSION['beta'] > 0) {
		include_once("theme/page.tpl.php");
	} else {
		if($core->args[1] == "login") {
			global $core;
			global $session;
			global $error;
			
			$success = $session->login($_POST['user'], $_POST['pass'], 0);
			
			header("Location: /");
			die();
		} elseif($core->args[0] == "betaregister") {
			
			$code = $core->args[1];
			
			$result = $database->db_query("SELECT id FROM Beta WHERE code = '$code' AND valid = 1");
			$count = mysqli_num_rows($result);
			
			$row = mysqli_fetch_object($result);
			
			if($count > 0) {
				$_SESSION['betacode'] = $row->id;
				$_SESSION['beta'] = 2;
			}
			
			header("Location: /");
			die();
			
		} elseif($core->args[1] == "closed") { 
			$username = $_POST['user'];
			$password = $_POST['pass'];
			
			if($username == "admin" and $password == "B1urr999"){
				$_SESSION['beta'] = 1;
			} else {
				//$error->setError("Login incorrect");
			}
			
			header("Location: /");
			die();
		} else {
			include_once("theme/beta.tpl.php");
		}
	}
} else {
	include_once("theme/page.tpl.php");
}

?>
