<?php
	global $core;
	global $database;
	global $session;
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/trade.css" />
<?php
	
	if($session->user){
		$result = $database->db_query("SELECT tradePass FROM Users WHERE userID = ".$session->user);
		$rowPass = mysqli_fetch_object($result);
		$trading = $rowPass->tradePass;	
	
		if($trading == 1){
			if(isset($core->args[1])){
				if(is_numeric($core->args[1])) {
					include_once("theme/trade_main.tpl.php");
				} else {
					if($session->user) {
						include_once("theme/trade_phases.tpl.php");
					} else {
						include_once("theme/errordocs/permission.tpl.php");
					}
				}
			} else {
				if($session->user) {
					include_once("theme/trade_phases.tpl.php");
				} else {
					include_once("theme/errordocs/permission.tpl.php");
				}
			} 
		} else {
			include_once("theme/trade_trading_pass.tpl.php");
		}
	} else {
		include_once("theme/errordocs/permission.tpl.php");
	}
?>