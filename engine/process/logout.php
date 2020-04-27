<?php
	global $core;
	global $session;
	global $error;
	global $database;
	
	if($session->user) {
		$result = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online WHERE userid = ".$session->user);
		$data = mysqli_fetch_object($result);
		if($data->count > 0) {
			$result2 = $database->db_query("DELETE FROM Users_online WHERE userid = ".$session->user);
		}
		
		$session->logout();
		
		if(BETA == 1) {
			$_SESSION['beta'] = 0;
		}
	}
	
	header('Location: /');
?>