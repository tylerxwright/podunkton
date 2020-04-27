<?php
	global $core;
	global $database;
	global $session;
?>
<?php
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "tag":
				include_once("theme/forums_category_list_tag.tpl.php");
				break;
			case "list":
				include_once("theme/forums_category_list.tpl.php");
				break;
			case "newtopic":
				include_once("theme/forums_newtopic.tpl.php");
				break;
			case "newpost":
				if(is_numeric($core->args[3])){
					include_once("theme/forums_newpost.tpl.php");
				} else {
					include_once("theme/forums_category_main.tpl.php");
				}
				break;
			case "newest":
			case "oldest":
				include_once("theme/forums_topic.tpl.php");
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		include_once("theme/forums_category_main.tpl.php");
	}
?>