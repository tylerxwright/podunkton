<?php
	global $core;
	
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "add":
				include_once("adminPanel/store_add.tpl.php");
				break;
			case "edit":
				include_once("adminPanel/store_edit.tpl.php");
				break;
			case "delete":
				include_once("adminPanel/store_delete.tpl.php");
				break;
			case "center":
				include_once("adminPanel/store_center_edit.tpl.php");
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		
		include_once("adminPanel/store_main.tpl.php");
	}
?>