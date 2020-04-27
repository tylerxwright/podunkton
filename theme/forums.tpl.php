<?php
	global $core;
	global $database;
	global $session;	
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/forums.css" />
<?php
	if(isset($core->args[1])){
		if($core->args[1] == "search") {
			include_once("theme/forums_search.tpl.php");
		} else {
			include_once("theme/forums_category.tpl.php");
		}
	} else {
		include_once("theme/forums_main.tpl.php");
	}
?>