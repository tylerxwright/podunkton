<link rel="stylesheet" type="text/css" href="/theme/scripts/header.css" />
<script type="text/javascript">
	
	if(document.images){
		btn1on = new Image(78, 37);
		btn1on.src = "/theme/images/main_button_home2.png";
		
		btn1off = new Image(78, 37);
		btn1off.src = "/theme/images/main_button_home.png";
		
		btn2on = new Image(87, 37);
		btn2on.src = "/theme/images/main_button_toons2.png";
		
		btn2off = new Image(87, 37);
		btn2off.src = "/theme/images/main_button_toons.png";
		
		btn3on = new Image(85, 37);
		btn3on.src = "/theme/images/main_button_games2.png";
		
		btn3off = new Image(85, 37);
		btn3off.src = "/theme/images/main_button_games.png";
		
		btn4on = new Image(86, 37);
		btn4on.src = "/theme/images/main_button_audio2.png";
		
		btn4off = new Image(86, 37);
		btn4off.src = "/theme/images/main_button_audio.png";
		
		btn5on = new Image(136, 37);
		btn5on.src = "/theme/images/main_button_community2.png";
		
		btn5off = new Image(136, 37);
		btn5off.src = "/theme/images/main_button_community.png";
		
		btn6on = new Image(110, 37);
		btn6on.src = "/theme/images/main_button_store2.png";
		
		btn6off = new Image(110, 37);
		btn6off.src = "/theme/images/main_button_store.png";
	}
	
	function lightup(imgName){
		if(document.images){
			imgOn = eval(imgName + "on.src");
			document[imgName].src = imgOn;
		}
	}
	
	function turnoff(imgName){
		if(document.images){
			imgOff = eval(imgName + "off.src");
			document[imgName].src = imgOff;
		}
	}
	
	var nav_menu;
	
	function home1() {
		//obj.style.backgroundImage.src = "/theme/images/main_button_home2.png";
		nav_menu = document.getElementById("nav_menu2_left");
		str = "<a class='nav2_link' href='/forums/podunkton_news'>News</a>"+
			  "<a class='nav2_link' href='/vault'>Vault</a>"+
			  "<a class='nav2_link' href='/faq'>FAQ/Help</a>";
		//replaceHTML(nav_menu, str);
		nav_menu.innerHTML = str;
	}
	
	function toons() {
		str = "<a class='nav2_link' href='/toons/view/cycon_dooby_dont'>Featured Toon</a>"+
			  "<a class='nav2_link' href='/toons/classic'>Classic</a>"+
			  "<a class='nav2_link' href='/toons/pre_season'>Pre-Season</a>"+
			  <!--"<a class='nav2_link' href='/toons/season_one'>Season 1</a>";-->
			  "<a class='nav2_link' href='/forums/cartoon_discussion'>Toons Forum</a>";
		//replaceHTML(nav_menu, str);
		nav_menu.innerHTML = str;
	}
	
	function games() {
		str = "<a class='nav2_link' href='/games/drunk_klunk'>Featured Game</a>"+
			  "<a class='nav2_link' href='/forums/gaming_discussion'>Games Forum</a>";
		//replaceHTML(nav_menu, str);
		nav_menu.innerHTML = str;
	}
	
	function audio() {
		str = "<a class='nav2_link' href='/audio/hickabilly_holler'>Featured Artist</a>"+
			  "<a class='nav2_link' href='/audio/list'>Artist Listings</a>";
		nav_menu.innerHTML = str;
	}
	
	function community() {
		str = "<a class='nav2_link' href='/shops'>Shops</a>"+
			  "<a class='nav2_link' href='/shops/barber_shop'>Barber Shop</a>"+
			  "<a class='nav2_link' href='/forums'>Forums</a>"+
			  <?php if($session->user) { ?>
			  "<a class='nav2_link' href='/store'>Monthly Item</a>";
			  <?php } else { ?>
			  "<a class='nav2_link' href='/store'></a>";
			  <?php } ?>
		nav_menu.innerHTML = str;
	}
	
	function vault() {
		str = "";
		nav_menu.innerHTML = str;
	}
	
	function checkEnter(event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			document.login_form.submit();
		}
		return false;
		
		/*if(event && event.which == 13) {
			document.login_form.submit();
		} else {
			return false;
		}*/
	}
	
	function checkEnterHeaderSearch(event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			advancedSearch();
		}
		return false;
		
		/*if(event && event.which == 13) {
			advancedSearch();
		}*/
	}
	
	function advancedSearch() {
		searchstr = document.getElementById('searchStr');
		location='/search/1/'+searchstr.value;
	}
	
	addLoadEvent(home1);
	
	
</script>
<div id="header">
	<div id="header_left">
		<img src="/theme/images/header_test01.png" />
	</div>
	<div id="header_right">
<?php
	if($session->user):
?>
<?php
	$query = sprintf("SELECT sex, permissions, isCrew, crewFull, crewAvatar FROM Users WHERE userID = %d", $session->user);
	$result = mysqli_query($database->connection, $query);
	$row = mysqli_fetch_object($result);
	$sex = $row->sex;
?>

<script type="text/javascript">
	var flashvars = {
		uid: 	"<?php echo $session->user; ?>",
		dummy: 	"<?php echo time(); ?>",
		header: "1"
		<?php if($row->isCrew == 1) { ?>, crewSwf: <?php echo "'".$row->crewFull."'"; } ?>
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#ffffff"
	};
	<?php if($row->isCrew == 1) { ?>
	swfobject.embedSWF("/characterBuilder/viewers/crewviewer.swf", "headerViewer", "91", "135", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $sex; ?>_1.swf", "headerViewer", "91", "135", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);	
	<?php } ?>
</script>

<script type="text/javascript">
	var flashvars = {
		dummy: 	"<?php echo time(); ?>"
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#ffffff"
	};
	
	swfobject.embedSWF("/theme/flash/clock.swf", "headerClock", "88", "19", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
</script>
		<div id="login_head2"><a class="login_link" style="color: #f9f9f9;" style="margin-left: 8px;" href="/process/logout">Logout</a></div>
		<div id="login_bot2">
			<div id="login_char">
				<div id="headerViewer">
					<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
				</div>
			</div>
			<div id="login_toolbox">
				<div id="tool_inner">
					<span style="color: #000000; font-weight: bold;">
						<?php print $session->username; ?>
					</span>
					<!--<a class="logout2" style="margin-left: 8px;" href="/process/logout">(Logout)</a>-->
						<?php 
							$result = $database->db_query("SELECT munniez, credits FROM Users WHERE userID=".$session->user);
							$row1 = mysqli_fetch_object($result);
						?>
					<div style="width: 120px;">
						<div class="login_content_font" style="margin-top: 6px; margin-left: 12px;">Munniez: <span id="munniez"><?php echo $row1->munniez; ?></span></div>
						<div class="login_content_font" style="margin-top: 2px; margin-left: 12px;">Credits: <span id="credits"><?php echo $row1->credits; ?></span></div>
					</div>
					
					<div style="width 120;">
						<div class="login_content_font2" style="margin-top: 3px;"> Quick Links</div>
						
						<div>
							<div class="login_content_gen" style="float: left;"><img src="/theme/images/icon_user.png" style="behavior: url(/iepngfix.htc);"/></div>
							<div style="float: left; margin-top: 2px; margin-left: 6px;">
								<a class="light" href="/user/<?php print $session->username; ?>">
									My User Page
								</a>
							</div>
							<div style="clear: both;"></div>
						</div>
						
						
						
						<div>
							<div class="login_content_gen" style="float: left;"><img src="/theme/images/icon_mail.png" style="behavior: url(/iepngfix.htc);"/></div>
							<div style="float: left; margin-top: 3px; margin-left: 6px;">
								<a class="light" href="/mail/inbox">
									<?php
										$result = $database->db_query("SELECT COUNT(id) AS 'count' FROM Inbox WHERE isread=0 AND reciever=".$session->user);
										$row2 = mysqli_fetch_object($result);
										if($row2->count > 0){
											echo "Inbox (".$row2->count.")";
										} else {
											echo "Inbox";
										}
									?>
								</a>
							</div>
							<div style="clear: both;"></div>
						</div>
						
						<div>
							<div class="login_content_gen" style="float: left;"><img src="/theme/images/icon_trade_small.png" style="behavior: url(/iepngfix.htc);"/></div>
							<div style="float: left; margin-top: 3px; margin-left: 4px;">
								<a class="light" href="/trade">Trades
								</a>
							</div>
							<div style="clear: both;"></div>
						</div>
						
						<?php if($row->permissions == 1) { ?>
						<div>
							<div class="login_content_gen" style="float: left;"><img src="/theme/images/icon_user.png" style="behavior: url(/iepngfix.htc);"/></div>
							<div style="float: left; margin-top: 2px; margin-left: 6px;">
								<a class="light" href="/admin">Admin
								</a>
							</div>
							<div style="clear: both;"></div>
						</div>
						<?php } ?>
						
					</div>
					
					
					
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
<?php
	else:
?>
		<div id="login_head"><a class="login_link" href="/register">register</a></div>
		<div id="login_bot">
			<form action="/process/login" method="POST" name="login_form">
				<table border="0" style="margin-left: 105px; font-size: 8pt; color: #333; font-weight: bold;" >
					<tr class="header"><td class="header" colspan="2">username</td></tr>
					<tr class="header"><td class="header" colspan="2"><input class="login" type="text" name="user" onkeydown="checkEnter(event);" /></td></tr>
					<tr class="header"><td class="header" colspan="2">password</td></tr>
					<tr class="header"><td class="header" colspan="2"><input class="login" type="password" name="pass" onkeydown="checkEnter(event);" /></td></tr>
					<tr class="header"><td class="header" colspan="2"><input type="checkbox" name="remember" /> remember me</td></tr>
					<tr class="header"><td class="header"><img style="cursor: pointer;" src="/theme/images/login_button.png" onclick="document.login_form.submit();" /></td><td></td></tr>
				</table>
			</form>
		</div>
<?php
	endif;
?>
	</div>
	
</div>


<div id="header_smooth_bar">
	<div id="smooth_bar_top"></div>
	<div id="nav_container">
		<div id="nav_menu">
			<ul>
				<li id="home" onmouseover="home1(); lightup('btn1');" onmouseout="turnoff('btn1');">
					<a id="header_link" href="/">
						<img src="/theme/images/main_button_home.png" border="0" name="btn1"/>
					</a>
				</li><li class="spacer"></li>
				<li id="toons" onmouseover="toons(); lightup('btn2');" onmouseout="turnoff('btn2');">
					<a id="header_link" href="/toons">
						<img src="/theme/images/main_button_toons.png" border="0" name="btn2"/>
					</a>
				</li><li class="spacer"></li>
				<li id="games" onmouseover="games(); lightup('btn3');" onmouseout="turnoff('btn3');">
					<a id="header_link" href="/games">
						<img src="/theme/images/main_button_games.png" border="0" name="btn3"/>
					</a>
				</li><li class="spacer"></li>
				
				<li id="audio" onmouseover="audio(); lightup('btn4');" onmouseout="turnoff('btn4');">
					<a id="header_link" href="/audio">
						<img src="/theme/images/main_button_audio.png" border="0" name="btn4"/>
					</a>
				</li><li class="spacer"></li>
				<li id="community" onmouseover="community(); lightup('btn5');" onmouseout="turnoff('btn5');">
					<a id="header_link" href="/community">
						<img src="/theme/images/main_button_community.png" border="0" name="btn5"/>
					</a>
				</li><li class="spacer"></li>
				<li id="vault" onmouseover="vault(); lightup('btn6');" onmouseout="turnoff('btn6');">
					<a id="header_link" href="/store">
						<img src="/theme/images/main_button_store.png" border="0" name="btn6"/>
					</a>
				</li>
				
			</ul>
		</div>
		<div id="nav_menu2">
			<div id="nav_menu2_left"></div>
			<div id="nav_menu2_right"><span id="stupidLamer"></span></div>
		</div>
	</div>
	<div id="smooth_bar_right">
		<div id="usersOnline">
			<div style="float: left;">
				<img src="/theme/images/onlineicon.png" style="behavior: url(/iepngfix.htc);" />
			</div>
			<div style="float: left; text-align: center; padding-left: 5px; line-height: 7pt;">
				USERS ONLINE<br/>
				<span style="color: #59698E;"><?php print $session->usersOnline; ?></span>
			</div>
			<div style="float: left; padding-left: 5px;">
				<div id="headerClock">
				
				</div>
			</div>
		</div>
		<div id="searchArea">
			<input style="width: 95px;" type="text" id="searchStr" onkeydown="checkEnterHeaderSearch(event);" size="12"/>
			<input style="width: 70px;" type="button" value="SEARCH" onclick="advancedSearch();"/>
		</div>
		<div id="advancedSearch" style="overflow: hidden; padding: 0px; margin: 0px; padding-right: 10px;">
			<a id="advanced" href="/search">USER SEARCH</a>
		</div>
	</div>
</div>