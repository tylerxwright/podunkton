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
	
	swfobject.embedSWF("/theme/flash/home.swf", "homeBanner", "467", "242", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
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
	
	<?php if($session->user){ ?>
	swfobject.embedSWF("/theme/flash/monthlyHome.swf", "registerButton", "310", "241", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/theme/flash/registerButton.swf", "registerButton", "310", "241", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } ?>
</script>

<div id="construction1">
	<div id="homeBanner">
		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/></a></p>
	</div>
</div>
<div id="construction2">
	<div id="registerButton">
		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
	</div>
</div>

<div style="clear: both; width: 792px; height: 8px; line-height: 1px; font-size: 1px;"></div>
<div class="site_box" style="width: 415px; float: left;">
	<div class="site_box_head">
		<div class="front_title">LATEST ANNOUNCEMENT</div>
	</div>
	<?php
		$result = $database->db_query("SELECT p.threadID, u.name, u.userID, u.sex, s.icon, t.subject, p.dateAdded, p.post FROM Forum_Post as p JOIN Forum_Thread as t ON p.threadID = t.threadID JOIN Forum_Subcategory as s ON s.subcategoryID = t.subcategoryID JOIN Users as u ON u.userID = t.author WHERE s.safeName = 'podunkton_news' ORDER BY t.dateAdded DESC LIMIT 0,1");
		$row = mysqli_fetch_object($result);
	?>
	<div class="site_box_content" style="background-color: #fff;">
		<div class="front_blue">

			<div id="latest_thumb">
				<?php echo $podunkton->imageAvatar($row->userID, $row->sex, 47, 1, "frontImageAvatar"); ?>
			</div>
			<div id="latest_box">
				<table border="0" style="border-spacing: 0px; padding-left: 5px; line-height: 10px; padding-top: 4px;">
					<tr><th>Title</th><th>:</th><th><a href="/forums/podunkton_news/oldest/<?php echo $row->threadID; ?>">"<?php echo $prettyprint->smallString($row->subject, 30); ?>"</a></th></tr>
					<tr><td>Posted By</td><td>:</td><td><a href="/user/<?php echo $row->name; ?>"><?php echo $row->name; ?></a></td>
					<tr><td>Date</td><td>:</td><td><?php echo $prettyprint->prettydate($row->dateAdded, "[M] [D], [Y]"); ?></td></tr>
				</table>
			</div>
		</div>
		<div class="front_box_inner">
			<?php echo $prettyprint->smallString($row->post, 600); ?>
		</div>
	</div>
</div>
<div id="front_bot_middle">
	<div id="front_thread_top"></div>
	<div id="front_thread_mid">
		<?php 
			$result = $database->db_query("SELECT t.threadID, t.subject, t.dateAdded FROM Forum_Thread as t JOIN Forum_Subcategory as s ON t.subcategoryID = s.subcategoryID WHERE s.safeName = 'podunkton_news' ORDER BY t.dateAdded DESC LIMIT 1,8");
			while($row = mysqli_fetch_object($result)) {
		?>
			<div class="front_thread_row">
				<div class="front_thread_left"><a class="blue" href="/forums/podunkton_news/oldest/<?php echo $row->threadID; ?>"><?php echo $prettyprint->smallString($row->subject, 30); ?></a></div>
				<div class="front_thread_right"><?php echo $prettyprint->prettydate($row->dateAdded, "[M] [D], [Y]"); ?></div>
			</div>
		<?php } ?>
	</div>
	<div id="front_thread_bot"></div>
</div>
<div style="clear: both; width: 792px; height: 8px; line-height: 1px; font-size: 1px;"></div>

<div id="front_bottom_row">
	<div style="float: left;">
		<a href="http://www.newgrounds.com/refer/cycon"><img src="/theme/images/newgrounds_button.png" /></a>
	</div>
	<div style="float: left;">
		<img src="/theme/images/googlead_home.png" />
	</div>
	<div style="float: left; padding-left: 5px; padding-top: 8px;">
	<!--<img src="/theme/images/paypal_home.png" />-->
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="margin: 0px; padding: 0px; overflow: hidden;">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="image" src="/theme/images/paypal_logo.png" style="behavior: url(/iepngfix.htc); border="0" name="submit" width="100" height="30" alt="PayPal - The safer, easier way to pay online!">
					<!--<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">-->
					<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
					">
		</form>
		&nbsp&nbsp<span style="font-weight: bold; color: #555;">Donate?</span>
	</div>
	<div style="clear: both;"></div>
</div>


<div style="clear: both; width: 792px; height: 8px; line-height: 1px; font-size: 1px;"></div>
