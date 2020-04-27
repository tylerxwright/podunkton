<?php
	global $core;
	
	if(isset($core->args[3])){
		if(is_numeric($core->args[3])){
			//include_once("adminPanel/category_view.tpl.php");
		} else {
			switch($core->args[3]){
				case "add":
					//include_once("adminPanel/category_add.tpl.php");
					break;
				case "edit":
					include_once("adminPanel/category_main.tpl.php");
					break;
				case "delete":
					//include_once("adminPanel/category_delete.tpl.php");
					break;
				default:
					include_once("theme/errordocs/404.tpl.php");
					break;
			}
		}
	} else {
		include_once("adminPanel/category_main.tpl.php");
	}
?>