<?php
	global $core;
	
	if(isset($core->args[3])){
		switch($core->args[3]){
			case "add":
				include_once("adminPanel/forum_category_add.tpl.php");
				break;
			case "edit":
				//include_once("adminPanel/forum_category_edit.tpl.php");
				break;
			case "delete":
				//include_once("adminPanel/forum_category_delete.tpl.php");
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		
		include_once("adminPanel/forum_category_main.tpl.php");
	}
?>