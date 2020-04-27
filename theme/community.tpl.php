<?php
	global $core;
	global $database;
?>
<script type="text/javascript">
	function checkEnterUser(event) {
		if(event && event.which == 13) {
			location='/user/'+document.getElementById('citizen').value;
		} else {
			return false;
		}
	}
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
	
	swfobject.embedSWF("/theme/flash/home.swf", "communityScroller", "470", "242", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
</script>
<script type="text/javascript">
	swfobject.embedSWF("/theme/flash/trendbanner01.swf", "trendBanner", "174", "80", "8", "/engine/swfobject/expressInstall.swf");
</script>
<link rel="stylesheet" type="text/css" href="/theme/scripts/community.css" />

<div id="community_top_left">
	<?php /*
	<div class="site_box" style="width: 120px;">
		<div class="site_box_head">
			<img src="/theme/images/site_box/head_status.png" />
		</div>
		<div class="site_box_content">
			<table id="table_status" border="0">
				<tr>
					<td>DATE</td><td align="right">04-19-08</td>
				</tr>
				<tr>
					<td>DELETED POSTS</td><td align="right">9999</td>
				</tr>
				<tr>
					<td>CONDITION<td align="right">FAIR</td>
				</tr>
				<tr>
					<td>OVERALL AURA</td><td align="right">NEUTRAL</td>
				</tr>
				<tr>
					<td>INSPECTION</td><td align="right">04-01-08</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<a class="dark" href="#">CLICK HERE FOR DETAILS</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	*/ ?>
	<!--<div style="width: 120px; height: 8px; line-height: 0px; font-size: 1px;"></div>-->
	<div class="site_box" style="width: 120px; margin-top: 0px;">
		<div class="site_box_head">
			<img src="/theme/images/site_box/head_donate.png" />
		</div>
		<div class="site_box_content">
			<div id="donate_container" style="height: 40px;">
				
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="margin: 0px; padding: 0px; overflow: hidden;">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="image" src="/theme/images/paypal_logo.png" style="behavior: url(/iepngfix.htc); border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
								<!--<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">-->
								<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
								">
				</form>Support Your Community!
			</div>
		</div>
	</div>
	<!--<div style="width: 122px; height: 8px; line-height: 1px; font-size: 1px;"></div>-->
	<div class="site_box" style="width: 120px; margin-top: 8px;">
		<div class="site_box_head">
		<?php if($session->user) { ?>
		<img border="0" src="/theme/images/site_box/head_friends.png" />
		<?php } else { ?>
			<div class="community_title">RANDOM USERS</div>
		<?php } ?>
		</div>
		<div class="site_box_content" style="width: 120px; background-color: #fff;">
			<div class="site_box_content_inner" style="width: 110px; overflow: hidden; min-height: 475px; height: expression( this.scrollHeight < 476 ? "475px" : "auto" );">
				<?php 
					if($session->user) {
						$resultFriends = $database->db_query("SELECT u.name, u.userID, u.sex FROM Users_has_Friends as uhf JOIN Users as u ON uhf.friendID = u.userID WHERE uhf.userID = ".$session->user." AND confirmed = 1 ORDER BY RAND() LIMIT 4");
						$numFriends = mysqli_fetch_object($resultFriends);
					} else {
						$resultFriends = $database->db_query("SELECT name, userID, sex FROM Users ORDER BY RAND() LIMIT 5");
					}
					$x = 0;
					while($rowFriends = mysqli_fetch_object($resultFriends)) {
				?>
				<div class="user_friend_selector" style="overflow: none;">
				<!--<div class="user_friend_selector" style="overflow: hidden;">-->
					<div class="user_friend_icon">
						<?php echo $podunkton->imageAvatar($rowFriends->userID, $rowFriends->sex, 35, $x, "friendAvatar"); ?>
					</div>
					<div class="user_friend_link"><a class="blue" href="/user/<?php echo $rowFriends->name; ?>"><?php echo $rowFriends->name; ?></a></div>
				</div>
				<?php
						$x++; 
					} 
				?>
				<?php 
					if($session->user) { 
						if($numFriends > 0){
				?>
				<div id="user_friend_all"><a class="grey" href="#">View All Friends</a></div>
				<?php 	} else { ?>
				<div id="user_friend_all">You have no friends</div>
				<?php 	
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
<div id="community_top_middle">
	<div id="community_ad_scroller">
		<div id="communityScroller">
		
		</div>
	</div>
	<!--<div style="width: 120px; height: 8px; line-height: 0px; font-size: 1px;"></div>-->
	<div id="community_citizen_search" style="margin-top: 8px;">
		<!--<form action="" method="POST">-->
			<table border="0" width="232" style="margin-top: 40px;">
				<tr><td align="center"><select style="width: 150px; margin-bottom: 0px;"><option value="username">Usernames</option></select></td></tr>
				<tr><td align="center"><input style="width: 146px; margin-top: 0px;" type="text" id="citizen" onkeydown="checkEnterUser(event);" /></td></tr>
				<tr><td align="center"><input style="width: 95px; margin-left: 55px;" type="button" value="Find Friends" onclick="location='/user/'+document.getElementById('citizen').value;"/></td></tr>
			</table>
		<!--</form>-->
	</div>
	<div id="community_featured_citizen" style="margin-top: 8px;">
		<div id="community_featured_character">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="141" height="181" id="logo" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="/characterBuilder/viewers/viewer_m_1.swf?uid=35&dummy=<?php echo time(); ?>" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#ffffff" /><embed src="/characterBuilder/viewers/viewer_m_1.swf?uid=35&dummy=<?php echo time(); ?>" quality="high" wmode="transparent" bgcolor="#ffffff" width="141" height="181" name="logo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
		</div>
		<div id="community_featured_citizen_name"><a href="/user/king/">KING</a></div>
	</div>
	<div style="clear: both;"></div>
	<!--<div style="width: 122px; height: 8px;"></div>-->
	<div id="community_forums" style="margin-top: 8px;">
		<a href="/forums"><img src="/theme/images/forums_button_2.png" /></a>
	</div>
</div>
<div id="community_top_right">
	
	<div style="width: 182px;">
		<a href="/store"><img src="/theme/images/monthlyItem1.png" /></a>
	</div>
	<!--<div style="width: 182px; height: 10px; line-height: 0px; font-size: 1px;"></div>-->
	<div class="site_box" style="width: 180px; margin-top: 8px;">
		<div class="site_box_head">
			<img border="0" src="/theme/images/site_box/head_flea_random.png" />
		</div>
		<div class="site_box_content" style="overflow: hidden;">
			<div id="flea_box">
				<div id="ticker">
				<a href="/shops">
					<div id="trendBanner">
					
					</div>
				</a>
				</div>
				<div id="flea_bottom">
					<div id="flea_bottom_head">RANDOM ITEMS</div>
					<?php
						$result = $database->db_query("SELECT i.itemID, s.safeName, i.name, i.png, i.munniez FROM Items as i JOIN Store as s ON i.store = s.storeID WHERE isPhysical = 0 AND defaultEquip = 0 AND monthly = 0 ORDER BY RAND() LIMIT 0, 6");
						while($rowItems = mysqli_fetch_object($result)){
					?>
					<div id="flea_bottom_items">
						<a href="/shops/<?php echo $rowItems->safeName; ?>">
							<div class="flea_item">
								<div class="flea_item_pic">
									<div style="padding: 5px;">
										<img src="/characterBuilder/images/<?php echo $rowItems->png; ?>" />
									</div>
								</div>
								<div class="flea_item_desc">
									<div class="flea_item_desc_top">
										<?php echo $rowItems->name; ?>
									</div>
									<div class="flea_item_desc_bot">
										<div class="flea_item_price"><?php echo $rowItems->munniez; ?></div>
										<?php /*<div class="flea_item_change" style="color: #00730B">
											<img src="/theme/images/arrow_green.png" /> 9999%
										</div> */ ?>
									</div>
								</div>
							</div>
						</a>
						<div style="width: 180px; height: 5px; line-height: 0px; font-size: 1px;"></div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div style="clear: both;"></div>
<!--<div style="width: 180px; height: 8px; line-height: 0px; font-size: 1px;"></div>-->
<div id="community_bot_left" style="margin-top: 9px;">
	<a href="/toons"><img src="/theme/images/toons_exp2.png" /></a>
<div style="width: 120px; height: 10px; line-height: 0px; font-size: 1px;"></div>
	<a href="/games"><img src="/theme/images/games_exp2.png" /></a>
</div>
<div id="community_bot_middle" style="margin-top: 8px;">
	<div id="community_thread_top"></div>
	<div id="community_thread_mid">
		<?php 
			$result = $database->db_query("SELECT t.threadID, t.subject, t.tolerance, s.safeName FROM Forum_Thread as t JOIN Forum_Subcategory as s ON t.subcategoryID = s.subcategoryID ORDER BY t.tolerance DESC LIMIT 0, 8");
			while($row = mysqli_fetch_object($result)) {
		?>
			<div class="community_thread_row">
				<div class="community_thread_left"><a class="blue" href="/forums/<?php echo $row->safeName; ?>/oldest/<?php echo $row->threadID; ?>"><?php echo $prettyprint->smallString($row->subject, 30); ?></a></div>
				<div class="community_thread_right"><?php echo $row->tolerance; ?></div>
			</div>
		<?php } ?>
	</div>
	<div id="community_thread_bot"></div>
</div>
<div id="community_bot_right" style="margin-top: 9px;">
	<a href="/shops"><img src="/theme/images/community_shops.png" /></a>
</div>
<div style="clear: both;"></div>
<div style="width: 792px; height: 8px; line-height: 0px; font-size: 1px;"></div>
<div id="community_ad2">
	<img src="/theme/images/forums_ad2.png" />
</div>