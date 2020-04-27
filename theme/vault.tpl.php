<link rel="stylesheet" type="text/css" href="/theme/scripts/vault.css" />
<?php
	if(isset($core->args[1])){
		include_once("theme/vault_view.tpl.php");
	} else {
		include_once("theme/vault_main.tpl.php");
	}
?>