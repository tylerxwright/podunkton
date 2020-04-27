<?php
	global $core;
	
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "category":
				include_once("adminPanel/forum_category.tpl.php");
				break;
			case "subcategory":
				include_once("adminPanel/forum_subcategory.tpl.php");
				break;
			case "post":
				//include_once("adminPanel/category_delete.tpl.php");
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		
		include_once("adminPanel/forum_main.tpl.php");
	}
?>