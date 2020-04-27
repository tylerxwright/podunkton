<?php
	global $database;
	global $error;
	
	$userid = 0;
	
	if(isset($_POST['delete'])){
		$name = $_POST['name'];
		$id = $_POST['userid'];
		$_POST = '';
		$_POST = array($name => $id);
		$this->procAdminDeleteUser();
	} else {
		$userid = $_POST['userid'];
		
		array_pop($_POST);
		array_pop($_POST);
		array_pop($_POST);
		$fields = '';
		for($i=0; $i < count($_POST); $i++){
			if($i == count($_POST) - 1){
				$fields .= key($_POST)."=";
				if(!is_numeric(current($_POST))){
					$fields .= "'".current($_POST)."'";
				} else {
					$fields .= current($_POST);
				}
			} else {
				$fields .= key($_POST)."=";
				if(!is_numeric(current($_POST))){
					$fields .= "'".current($_POST)."', ";
				} else {
					$fields .= current($_POST).", ";
				}
			}
			next($_POST);
		}
		
		$query = "UPDATE Users SET ".$fields." WHERE userID = ".$userid;
		$result = $database->db_query($query);
		
		if($result) {
			$error->setError("Changes Saved");
		} else {
			$error->setError("Error in changes");
		}
		
		header("Location: /admin/user/$userid");
	}
?>