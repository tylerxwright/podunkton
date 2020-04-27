<?php
	global $session;
	global $database;
	global $core;
	global $msgObj;
	
	$email = $_POST['email'];
	$code = "";
	
	srand(time());
	for($i=0; $i<25; $i++) {
		$type = rand(1, 3);
		switch(rand(1, 3)) {
			case 1:
				$code .= chr(rand(48, 57));
				break;
			case 2:
				$code .= chr(rand(65, 90));
				break;
			case 3:
				$code .= chr(rand(97, 122));
				break;
		}
	}
	
	$result = $database->db_query("INSERT INTO Beta(code, email) VALUES('$code', '$email')");
	
	$msgObj->setMsg("Beta tester added!");
	header("Location: /admin/beta");
	
?>