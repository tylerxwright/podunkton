<?php
	global $core;
	global $database;
	global $session;
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/shops.css" />
<?php
	if(isset($core->args[1])){
		if($core->args[1] == "barber_shop") {
			include_once("theme/shops_barber.tpl.php");
		} else {
			include_once("theme/shops_store.tpl.php");
		}
	} else {
		include_once("theme/shops_main.tpl.php");
	}
?>