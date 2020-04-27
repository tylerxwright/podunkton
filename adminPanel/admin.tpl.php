<?php
	global $core;
	global $database;
	global $session;
?>
<?php
	if($session->user){
		$result = $database->db_query("SELECT permissions FROM Users WHERE userID = ".$session->user);
		$row = mysqli_fetch_object($result);
		if($row->permissions == 1){
?>
<link rel="stylesheet" type="text/css" href="/adminPanel/adminScripts/admin.css" />
<table border="0">
<tr>
<td valign="top" style="width: 180px; border-right: solid 1px #000; background-color: #f3f3f3; padding-bottom: 10px;">
	<?php include_once("sidebar.tpl.php"); ?>
</td>
<td valign="top" style="width: 580px; padding-left: 10px;">
<?php
			if(!isset($core->args[1])){
				include_once("main.tpl.php");
			} elseif($core->args[1] == "user"){
				include_once("user.tpl.php");
			} elseif($core->args[1] == "forum"){
				include_once("forum.tpl.php");
			} elseif($core->args[1] == "toon"){
				include_once("toon.tpl.php");
			} elseif($core->args[1] == "game"){
				include_once("game.tpl.php");
			} elseif($core->args[1] == "character"){
				include_once("character.tpl.php");
			} elseif($core->args[1] == "captchas"){
				include_once("captchas.tpl.php");
			} elseif($core->args[1] == "store"){
				include_once("store.tpl.php");
			} elseif($core->args[1] == "badges"){
				include_once("badges.tpl.php");
			} elseif($core->args[1] == "audio"){
				include_once("audio.tpl.php");
			} elseif($core->args[1] == "vault"){
				include_once("vault.tpl.php");
			} elseif($core->args[1] == "beta"){
				if(isset($core->args[2])) {
					if($core->args[2] == "add") {
						include_once("beta_add.tpl.php");
					} else {
						if(isset($core->args[3])) {
							include_once("beta_view.tpl.php");
						} else {
							include_once("beta_errors.tpl.php");
						}
					}
				} else {
					include_once("beta.tpl.php");
				}
			}
			echo "</td></tr></table>";
		} else {
			include_once("theme/errordocs/permission.tpl.php");
		}
	} else {
		include_once("theme/errordocs/permission.tpl.php");
	}
?>