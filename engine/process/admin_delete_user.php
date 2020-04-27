<?php
	global $database;
	global $error;
	global $session;
	
	$id = '';
	$errorString = '';
	
	
	if(!count($_POST)){
		$errorString = 'You did not select any users to delete';
	} else {
		$errorString = 'Deleted users: ';
		
		for($i=0; $i < count($_POST); $i++){
			if($i == count($_POST) - 1){
				$id .= "userID = ".current($_POST);
				$errorString .= key($_POST).".";
			} else {
				$id .= "userID = ".current($_POST)." AND ";
				$errorString .= key($_POST).", ";
			}
			next($_POST);
		}
		
		$query = "DELETE FROM Users WHERE ".$id;
		
		$result = $database->db_query($query);
	}
	
	$error->setError($errorString);
	
	header('Location: /admin/user');
?>