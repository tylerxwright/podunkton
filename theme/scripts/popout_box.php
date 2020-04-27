<?php
	global $core;
	if( $core->args[3] == "game"){
		$game = $core->args[1];
		$gameID = $core->args[2];
		$result = $database->db_query("UPDATE Games SET views = views + 1 WHERE gameID = $gameID");
	} else {
		$toon = $core->args[1];
		$toonID = $core->args[2];
		$result = $database->db_query("UPDATE Toons SET views = views + 1 WHERE toonID = $toonID");
	}
?>
<html>
<head>
<title>Popout Content Viewer</title>
</head>
<body style="padding: 0px; margin: 0px;">
	<div id="toon">
		<?php if($core->args[3] == "game") { ?>
		<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='<?php echo $core->args[4]; ?>' height='<?php echo $core->args[5]; ?>' id='logo' align='middle'>
		<?php } else { ?>
		<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='600' height='500' id='logo' align='middle'>
		<?php } ?>
		<param name='allowScriptAccess' value='sameDomain' />
		<?php if($core->args[3] == "game") { ?>
		<param name='movie' value='/content/games/swfs/<?php echo $game; ?>' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' /><embed src='/content/games/swfs/<?php echo $game; ?>' quality='high' bgcolor='#ffffff' width='<?php echo $core->args[4]; ?>' height='<?php echo $core->args[5]; ?>' name='logo' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
		<?php } else { ?>
		<param name='movie' value='/content/toons/swfs/<?php echo $toon; ?>' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' /><embed src='/content/toons/swfs/<?php echo $toon; ?>' quality='high' bgcolor='#ffffff' width='600' height='500' name='logo' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />	
		<?php } ?>
		</object>
	<div>
</body>
</html>