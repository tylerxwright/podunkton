<?php
	global $core;
	global $session;
	global $database;
	
	$user = $session->user;
	
	$mid = $core->args[2];
	$result = $database->db_query("SELECT * FROM Messages as m JOIN Sent as i ON m.mid = i.mid WHERE i.mid = $mid AND sender = $user ORDER BY postdate DESC");
	$numRows = mysqli_num_rows($result);
	if($numRows > 0) {
		$row = mysqli_fetch_object($result);
		
		$result2 = $database->db_query("UPDATE Sent SET isread = 1 WHERE id = ".$row->id);
		
		$resultU = $database->db_query("SELECT * FROM Users WHERE userID = ".$row->sender);
		$rowU = mysqli_fetch_object($resultU);
		$date = $prettyprint->prettyDate($rowU->signup, "[m] [d], [y]");
		if($data->sex == "m"){
			$usersex = "Male";
		} else {
			$usersex = "Female";
		}
		
		$resultThem = $database->db_query("SELECT name FROM Users WHERE userID = ".$row->reciever);
		$rowThem = mysqli_fetch_object($resultThem);
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/forums_topic.css" />
<div id="mail_head" style="border: none;">
	<img src="/theme/images/mail_sign.png" />
</div>
<div class="compose_top2">
	<div style="float: left;">
		<?php /*
		<div class="compose_top_a"><a class="blue" href="/mail">Previous message</a></div>
		<div class="compose_seperator2"></div>
		<div class="compose_top_a"><a class="blue" href="/mail">Go to Next message</a></div>
		<div class="compose_seperator2"></div>
		*/ ?>
		<div class="compose_top_a"><a class="blue" href="/mail">Back to Inbox</a></div>
		<div class="compose_seperator2"></div>
		<div class="compose_top_a"><a class="blue" href="/mail/sent">Go to Sentbox</a></div>
		<div style="clear: both;"></div>
	</div>
	<div style="float: right;">
		<!--<a class="blue" href="#">Mark as Unread</a>-->
	</div>
	<div style="clear: both;"></div>
</div>
<div class="compose_message_bar">
	<a style="float: left;" href="/mail/compose/<?php echo $row->sender; ?>/<?php echo $row->mid; ?>"><img src="/theme/images/reply_to_sender" /></a>
	<!--<a style="float: left; margin-left: 8px;" href="/mail/compose/all"><img src="/theme/images/reply_to_all" /></a>-->
	<a style="float: left;" href="/process/deleteMessage/<?php echo $row->mid; ?>"><img style="margin-left: 8px;" src="/theme/images/delete_message.png" /></a>
	<div style="clear: both;"></div>
</div>
<div id="mail_view_head">
	<div style="font-weight: bold; color: #111; font-size: 8pt; float: left;">Title: RE: <?php echo $row->subject; ?></div>
	<div style="float: right;"><?php echo $prettyprint->prettyDate($row->postdate, "[M] [D], [Y] at [x] [CZ]"); ?></div>
	<div style="clear: both;"></div>
	From: <a class="blue" href="/user/<?php echo $rowU->name; ?>"><?php echo $rowU->name; ?></a><br/>
	To: <a class="blue" href="/user/<?php echo $rowThem->name; ?>"><?php echo $rowThem->name; ?></a>
</div>
<div class="site_box" style="width: 792px;">
	<div class="site_box_head" style="text-align: left;">
		<div class="forum_head">
			<div class="forum_head_icon">
				<img src="/theme/images/onlineicon.png" />
			</div>
			<div class="forum_head_center">
				<span class="whitebold10"><?php echo $rowU->name; ?></span>
			</div>
			<div class="forum_head_right">
				
			</div>
		</div>
	</div>
	<div class="forums_post_content">
		<div class="forums_post_left">
		
<script type="text/javascript">
	var flashvars = {
		uid: "<?php echo $rowU->userID; ?>",
		dummy: 	"<?php echo time(); ?>"
		<?php if($rowU->isCrew == 1) { ?>, crewSwf: <?php echo "'".$rowU->crewFull."'"; } ?>
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#ffffff"
	};
	<?php if($rowU->isCrew == 1) { ?>
	swfobject.embedSWF("/characterBuilder/viewers/crewviewer.swf", "forumsLeftViewer", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $rowU->sex; ?>_1.swf", "forumsLeftViewer", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);	
	<?php } ?>
</script>

			<a href="/user/<?php echo $rowU->name; ?>">
			<div class="forums_post_character">
				<div style="cursor: pointer;" onclick="location='/user/<?php echo $rowU->name; ?>';">
					<div id="forumsLeftViewer">
					
					</div>
				</div>
			</div>
			</a>
			<div class="forums_post_info">
				<table border="0" width="131">
					<tr><td>LEVEL</td><td class="td_righty"><?php echo $podunkton->calculateLevel($rowU->experience); ?></td></tr>
					<tr><td>Sign-up</td><td class="td_righty"><?php echo $date; ?></td></tr>
					<tr><td>Posts</td><td class="td_righty"><?php echo $rowU->posts; ?></td></tr>
				</table>
				<table border="0">
					<tr><td>EXP</td>
						<td colspan="2">
							<?php echo $podunkton->showExp($rowU->experience); ?>
						</td>
					</tr>
					<tr>
						<?php echo $podunkton->goodevil2($rowU->goodevil); ?>
					</tr>
				</table>
			</div>
		</div>
		<div class="forums_post_right">
			<div class="forums_post">
				<div class="forums_post_content_left">
					<div class="forums_bubble_left"></div>
				</div>
				<div class="forums_post_content_right">
					<div class="forums_post_bubble_top_row">
						<div class="forums_bubble_top_left"></div>
						<div class="forums_bubble_top"></div>
						<div class="forums_bubble_top_right"></div>
						<div style="clear: both;"></div>
					</div>
					<div class="forums_bubble_inner">
						<div class="forums_bubble_inner_top">
							<div style="float: left;"><a href="/user/<?php echo $rowU->name; ?>" class="blue"><?php echo $rowU->name; ?></a> said:</div>
							<div style="float: right;">Posted on <?php echo $prettyprint->prettyDate($row->postdate, "[M] [D], [Y] at [x] [CZ]"); ?></div>
						</div>
						<div  class="forums_bubble_inner_bot">
							<div class="forums_post_thepost">
								<?php echo stripslashes($row->message); ?>
							</div>
						</div>
					</div>
					<div class="forums_post_bubble_bot_row">
						<div class="forums_bubble_bot_left"></div>
						<div class="forums_bubble_bot"></div>
						<div class="forums_bubble_bot_right"></div>
						<div style="clear: both;"></div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div class="forums_post_tools">
				<div class="forums_post_tools_left">
				</div>
				<div class="forums_post_tools_right">
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<div style="width: 792px; height: 8px;"></div>
<div class="compose_message_bar">
	<a style="float: left;" href="/mail/compose/<?php echo $row->sender; ?>/<?php echo $row->mid; ?>"><img src="/theme/images/reply_to_sender" /></a>
	<!--<a style="float: left; margin-left: 8px;" href="/mail/compose/all"><img src="/theme/images/reply_to_all" /></a>-->
	<a style="float: left;" href="/process/deleteMessage/<?php echo $row->mid; ?>"><img style="margin-left: 8px;" src="/theme/images/delete_message.png" /></a>
	<div style="clear: both;"></div>
</div>
<div class="compose_top2">
	<div style="float: left;">
		<?php /*
		<div class="compose_top_a"><a class="blue" href="/mail">Previous message</a></div>
		<div class="compose_seperator2"></div>
		<div class="compose_top_a"><a class="blue" href="/mail">Go to Next message</a></div>
		<div class="compose_seperator2"></div>
		*/ ?>
		<div class="compose_top_a"><a class="blue" href="/mail">Back to Inbox</a></div>
		<div class="compose_seperator2"></div>
		<div class="compose_top_a"><a class="blue" href="/mail/sent">Go to Sentbox</a></div>
		<div style="clear: both;"></div>
	</div>
	<div style="float: right;">
		<!--<a class="blue" href="#">Mark as Unread</a>-->
	</div>
	<div style="clear: both;"></div>
</div>
<?php 
	} else { 
		include_once("theme/errordocs/404.tpl.php");
	}
?>