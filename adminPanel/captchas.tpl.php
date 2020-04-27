<?php
	global $core;
	global $database;
	global $session;
?>
<?php
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "add":
				include_once("adminPanel/captchas_add.tpl.php");
				break;
			case "edit":
				include_once("adminPanel/captchas_main.tpl.php");
				break;
			case "delete":
				include_once("adminPanel/captchas_delete.tpl.php");
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		include_once("adminPanel/captchas_main.tpl.php");
	}
?>