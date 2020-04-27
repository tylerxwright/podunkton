<?php
	global $core;
	global $session;
	if(!$session->user) {
?>
<div>
	<br/><br/>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="792" height="507" id="logo" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="/characterBuilder/register/registeration.swf?betacode=<?php echo $_SESSION['betacode']; ?>&dummy=<?php echo time(); ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/characterBuilder/register/registeration.swf?betacode=<?php echo $_SESSION['betacode']; ?>&dummy=<?php echo time(); ?>" quality="high" bgcolor="#ffffff" width="792" height="507" name="logo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</div>
<div style="width: 792px; height: 20px;"></div>
<?php 
	} else {
		include_once("theme/errordocs/404.tpl.php");
	}
?>