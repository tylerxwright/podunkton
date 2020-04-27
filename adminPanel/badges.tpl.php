<?php
	global $core;
	global $database;
	global $session;
?>
<div id="adminMenu">
	<div class="adminButton" <?php if(!isset($core->args[2])) { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/badges">Main</a>
	</div>
	<div style="clear: both;"></div>
</div>
<?php
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "add":
				include_once("adminPanel/badges_add.tpl.php");
				break;
			case "edit":
				include_once("adminPanel/badges_edit.tpl.php");
				break;
			default:
				include_once("adminPanel/badges_main.tpl.php");
				break;
		}
	} else {
		include_once("adminPanel/badges_main.tpl.php");
	}
?>