<?php
	global $core;
	global $database;
?>
<h2>Podunkton Forums</h2>
<?php
	if($core->args[1] && $core->args[2]){
		include_once("theme/forum_threads.tpl.php");
	} elseif($core->args[1]){
		include_once("theme/forum_topic_view.tpl.php");
	} else {
		include_once("theme/forum_main_view.tpl.php");
	}
?>
