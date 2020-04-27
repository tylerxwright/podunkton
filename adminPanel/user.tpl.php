<?php
	global $core;
?>
<?php
	if(isset($core->args[2])){
		if(is_numeric($core->args[2])){
			include_once("adminPanel/user_view.tpl.php");
		} else {
			switch($core->args[2]){
				case "add":
					include_once("adminPanel/user_add.tpl.php");
					break;
				case "edit":
					include_once("adminPanel/user_main.tpl.php");
					break;
				case "delete":
					include_once("adminPanel/user_delete.tpl.php");
					break;
				default:
					include_once("theme/errordocs/404.tpl.php");
					break;
			}
		}
	} else {
		include_once("adminPanel/user_main.tpl.php");
	}
?>