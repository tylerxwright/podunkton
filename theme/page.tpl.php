<?php
	global $core;
	global $session;
	global $error;
	global $database;
	
	if($core->args[0] == ""){
		$filename = "theme/front.tpl.php";
	} elseif($core->args[0] == "process"){
		include_once("engine/Process.php");
	} elseif($core->args[0] == "admin"){
		$filename = "adminPanel/admin.tpl.php";
	} else {
		$filename = "theme/".$core->args[0].".tpl.php";
	}
	
	if(BETA == 1) {
		if($_SESSION['beta'] == 2) {
			$filename = "theme/register.tpl.php";
		}
	}
	
	if($session->user) {
		if(isset($_SESSION['page_timer'])) {
			if(time() >= $_SESSION['page_timer']+SECONDS_PER_PAGE) {
				srand(time());
				$_SESSION['page_timer'] = time();
				$result = $database->db_query("UPDATE Users SET munniez = munniez + ".rand(1, (int)MUNNIEZ_PER_PAGE_MAX)." WHERE userID = ".$session->user);
			}
		} else {
			$_SESSION['page_timer'] = time();
		}
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome to Podunkton</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/theme/scripts/podunkton.css" /> 
<script type="text/javascript" src="/engine/Ajax.js"></script>
<script type="text/javascript" src="/engine/jquery.js"></script>
<script type="text/javascript">
	
	function cancelPopup() {
		overlayBox = document.getElementById("overlay");
		box = document.getElementById("overlay_message_box");
		overlayBox.style.display = "none";
		box.style.display = "none";
		document.body.style.overflow='auto';
	}
	
	function showError(str) {
		var ajaxError = document.getElementById("ajaxErrorBox");
		ajaxError.innerHTML = str;
		$('div#ajaxErrorBox').slideDown("slow");
	}
	
	function showMsg(str) {
		var ajaxMsg = document.getElementById("ajaxMsgBox");
		ajaxMsg.innerHTML = str;
		$('div#ajaxMsgBox').slideDown("slow");
	}
	
	function addLoadEvent(func){    
	    var oldonload = window.onload;
	    if (typeof window.onload != 'function')
	    {
	        window.onload = func;
	    } 
	    else 
	    {
	        window.onload = function()
	        {
	            oldonload();
	            func();
	        }
	    }
	}
	
</script>
<script type="text/javascript" src="/engine/swfobject/swfobject.js"></script>
<script type="text/javascript" src="/theme/scripts/browser_selector.js"></script>
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->
<!-- [if IE]>
<style type="text/css">
#main_container{height: 100%;}
#container {background-image: none;}
/*overlay {filter: alpha(opacity=50);}*/
</style>
<![endif]-->

</head>
<body>

	<div id="overlay_message_box">
		<div id="overlay_box" class="site_box" style="width: 100%; height: 100%;">
			<table width="auto" height="auto" cellpadding="0" cellspacing="0">
				<tr>
					<td id="pop_top_left"><img src="/theme/images/pop_up/top_left.png" /></td>
					<td id="pop_top_middle"><div id="podunktonPresents" style="float:left;"><!--<img src="/theme/images/pop_up/podunk_presents.png" />--></div><div id="headerTitle" class="overlay_title">TEST NAME</div>
					<div style="float: right; padding-top: 3px;"><img onclick="cancelPopup();" style="cursor: pointer;" src="/theme/images/pop_up/x_icon_blue.png" /></div>
					</td>
					<td id="pop_top_right"><img src="/theme/images/pop_up/top_right.png" /></td>
				</tr>
				<tr>
					<td id="pop_content" colspan="3" style="background-color: #fff; border-left: 1px solid #7e7e7e; border-right: 1px solid #7e7e7e;">
						<div id="overlay_inner" class="site_box_content_inner">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center" style="background-color: #fff; border-left: 1px solid #7e7e7e; border-right: 1px solid #7e7e7e;">
						<div id="overlayAddBox"></div>
					</td>
				</tr>
				<tr>
					<td id="pop_bot_left"></td>
					<td id="pop_bot_middle"></td>
					<td id="pop_bot_right"></td>
				</tr>
			<div style="clear: both;"></div>
			</table>
		</div>
			
	</div>
	
	<div id="overlay"></div>
	<div id="main_container">
		<div id="inner_container">
			<div id="container">
<?php include_once("theme/header.tpl.php"); ?>
				<div id="main_content">
					<!--<div id="main_content_top">-->
					<!--	<div id="main_content_top_left"></div>-->
					<!--	<div id="main_content_top_center"></div>-->
					<!--	<div id="main_content_top_right"></div>-->
					<!--</div>-->
					<div id="main_content_inner">
						
						<div id='ajaxErrorBox' class="ajaxError"></div>
						<div id='ajaxMsgBox' class="ajaxMsg"></div>
<?php
if($error->errorMsg){
	print "<div id='errorBox'>".$error->getError()."</div>";
}
?>
<?php
if($msgObj->msg){
	print "<div id='msgBox'>".$msgObj->getMsg()."</div>";
}
?>
<?php
if(file_exists($filename)){
	include($filename);
} else {
	include_once("theme/errordocs/404.tpl.php");
}
?>
					</div>
				</div>
<?php include_once("theme/sidebars/footer.tpl.php"); ?>
			</div>
		</div>
	</div>
<?php /*
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-2134239-2");
pageTracker._initData();
pageTracker._trackPageview();
</script>
*/ ?>

</body>
</html>
<?php
$database->close();
?>
