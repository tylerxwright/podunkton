<?php
	global $core;
	global $database;
	global $session;
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/user.css" />
<?php
	if(isset($core->args[1])){
		$result = $database->db_query("SELECT userID FROM Users WHERE name = '".$core->args[1]."'");
		$count = mysqli_num_rows($result);
		if($count > 0) {
			if($core->args[2] == "edit") {
				include_once("theme/user_edit.tpl.php");
			} else {
				include_once("theme/user_main.tpl.php");
			}
		} else {
			echo "User not found";
		}
	} else {
		echo "User not found";
	}
?>