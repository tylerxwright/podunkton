<?php
	global $session;
	global $core;
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/mail.css" />
<?php
	if($session->user) {
		if($core->args[1] == "inbox"){
			if(isset($core->args[2])){
				include_once("theme/mail_view_inbox.tpl.php");
			} else {
				include_once("theme/mail_main.tpl.php");
			}
		} elseif($core->args[1] == "sent") {
			if(isset($core->args[2])){
				include_once("theme/mail_view_sentbox.tpl.php");
			} else {
				include_once("theme/mail_sentbox.tpl.php");
			}
		} elseif($core->args[1] == "compose") {
			include_once("theme/mail_compose.tpl.php");
		} else {
			include_once("theme/mail_main.tpl.php");
		}
	} else {
		include_once("theme/errordocs/404.tpl.php");
	}
?>