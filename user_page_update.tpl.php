<?php
	global $core;
	global $session;
	global $database;
?>

<?php 
	//$data = $database->getUserData($core->args[1]); 
	$result = $database->db_query("SELECT * FROM Users WHERE name = '".$core->args[1]."'");
	$data = mysqli_fetch_object($result);
	
	$level = floor($data->experience/100)+1;
	if($data->experience < 10) {
		$exp = substr($data->experience, -1);
	} elseif($data->experience == 0) {
		$exp = 0;
	} else {
		$exp = substr($data->experience, -2);
	}
	$nextLevel = $level*100;
	$date = $prettyprint->prettyDate($data->signup, "[m] [D], '[y]");
	
	if($data->sex == "m"){
		$usersex = "Male";
	} else {
		$usersex = "Female";
	}
?>

<script type="text/javascript">
	
	var ajax = new Ajax();
	var previousFriendTag;
	
	function addFriend(uid) {
		var text = document.getElementById("addFriendText");
		previousFriendTag = text.innerHTML;
		text.innerHTML = "<div style='float: left; color: green;'>ADDING</div><div style='float: left; margin-left: 5px;'><img src='/theme/images/ajax-loader.gif' border='0' /></div><div style='clear: both;'></div>";
		ajax.doGet("/process/addFriend/"+uid, showResults);
	}
	
	function showResults(str) {
		if(str == "1"){
			var friendRow = document.getElementById("addFriendRow");
			friendRow.style.display = "none";
			showMsg("A confirmation message has been sent to <?php echo $data->name; ?>");
		} else {
			var text = document.getElementById("addFriendText");
			text.innerHTML = previousFriendTag;
			showError("There was an error in adding <?php echo $data->name; ?> as a friend...sorry");
		}
		
	}
	
	function addComment() {
		var text = document.getElementById("commentText").value;
		ajax.doGet("/process/addUserComment/<?php echo $data->userID; ?>/"+text, showComment);
	}
	
	function showComment(str) {
		if(str == "Error") {
			//str = "You must be logged in and you must provide a comment";
			//commentSection.innerHTML = str + commentSection;
		} else {
			document.getElementById("commentText").value = "";
			var commentSection = document.getElementById("commentSection");
			commentSection.innerHTML = str;
		}
	}
	
	function changeCommentPage() {
		var pageSelect = document.getElementById('pageSelect');
		ajax.doGet("/process/getUserCommentPage/<?php echo $data->userID; ?>/"+pageSelect.options[pageSelect.selectedIndex].value, showAllComments);
	}
	
	function showAllComments(str) {
		var commentSection = document.getElementById("commentSection");
		commentSection.innerHTML = str;
	}
	
</script>

<div id="user_left">
	<div class="site_box" style="width: 235px;">
		<div class="site_box_head">
			<div class="user_title"><?php echo $data->name; ?></div>
			<?php
				$userid = $data->userID;
				if(!$userid) {
					$userid = 0;
				}
				$onlineResult = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online WHERE userid = $userid");
				$onlinedata = mysqli_fetch_object($onlineResult);
				if($onlinedata->count > 0) {
			?>
					<div class="online">[online]</div>
			<?php } else { ?>
					<div class="offline">[offline]</div>
			<?php } ?>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="site_box_content_inner" style="width: 225px;">
<script type="text/javascript">
	var flashvars = {
		uid: "<?php echo $data->userID; ?>",
		bandID:	"1"
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#ffffff"
	};
	
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $data->sex; ?>_1.swf", "userViewer", "225", "298", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
</script>
				<div style="width: 225px; height: 298px;">
					<div id="userViewer">
					
					</div>
				</div>
			</div>
		</div>
	</div>

	<div style="width: 235px; height: 6px;"></div>
	<?php if($data->userID != $session->user AND $session->user) { ?>
	<div class="site_box" style="width: 235px;">
		<div class="site_box_head">
			<div class="user_title">CONTACTS</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="site_box_content_inner" style="width: 225px;">
				<!--<div class="user_contact_row" style="margin-top: 5px;"><div class="default_icon"></div><div class="user_contact_link"><a href="#">ADD TO FRIENDS</a></div><div style="clear: both;"></div></div>-->
				<div class="user_contact_row"><div class="default_icon"></div><div class="user_contact_link"><a href="/mail/compose/<?php echo $data->userID; ?>">SEND A MESSAGE</a></div><div style="clear: both;"></div></div>
				<?php
					$resultFriend = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_has_Friends WHERE userID = ".$session->user." AND friendID=".$data->userID);
					$rowIsFriend = mysqli_fetch_object($resultFriend);
					if($rowIsFriend->count == 0) {
				?>
				<div id="addFriendRow" class="user_contact_row"><div class="default_icon"></div><div id="addFriendText" class="user_contact_link"><a href="#" onclick="addFriend(<?php echo $data->userID; ?>);return false;">ADD AS A FRIEND</a></div><div style="clear: both;"></div></div>
				<?php } ?>
				<?php if($rowU->aim != "") { ?>
					<div class="user_contact_row"><div class="default_icon"></div><div class="user_contact_link"><a href="aim:goim?screenname=<?php echo $data->aim; ?>;message=Hail+from+Podunkton!">INSTANT MESSAGE (AIM)</a></div><div style="clear: both;"></div></div>
				<?php } ?>
				<form name="startTrade" action="/process/startTrade" method="POST">
					<input type="hidden" name="uname" value="<?php echo $data->name; ?>" />
					<div class="user_contact_row" style="margin-bottom: 5px;"><div class="default_icon"></div><div class="user_contact_link"><a href="#" onclick="document.startTrade.submit();">TRADE REQUEST</a></div><div style="clear: both;"></div></div>
				</form>
			</div>
		</div>
	</div>
	<div style="width: 235px; height: 6px;"></div>
	<?php } ?>
	
	
	
	
	<?php if(0) {	// Not finished stuff! ?>
	<div style="width: 235px; height: 8px;"></div>
	<div class="site_box" style="width: 235px;">
		<div class="site_box_head">
			<div class="user_title">MY STORE</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="user_badges_small">
				<div class="user_badges_left">Displaying 3/4000 Items</div><div class="user_badges_right"><a class="blue" href="#">See All</a></div><div style="clear: both;"></div>
			</div>
			<div class="site_box_content_inner" style="width: 225px;">
				<div class="user_item"></div><div class="user_item_right">Item Name Go Here<br/><span class="blue">4d 2h 37 min 10 sec Left</span></div><div style="clear: both;"></div>
				<div class="user_item"></div><div class="user_item_right">Item Name Go Here<br/><span class="blue">4d 2h 37 min 10 sec Left</span></div><div style="clear: both;"></div>
				<div class="user_item"></div><div class="user_item_right">Item Name Go Here<br/><span class="blue">4d 2h 37 min 10 sec Left</span></div><div style="clear: both;"></div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<div id="userTabs">
	<div class="tab"><img src="/theme/images/user/genTabAct.png" /></div>
	<div class="tab"><img src="/theme/images/user/actTabOff.png" /></div>
	<div class="tab"><img src="/theme/images/user/comTabOff.png" /></div>
	<div class="tab"><img src="/theme/images/user/badgTabOff.png" /></div>
	<div class="tab"><img src="/theme/images/user/statTabOff.png" /></div>
	<div class="tab"><img src="/theme/images/user/friendTabOff.png" /></div>
</div>

<div id="user_middle">
	<div class="site_box" style="width: 542px;">
		
		<div class="site_box_user" style="background-color: #fff;">	


			<div style="display: none;">
				<div class="user_general_top">
					"<?php echo stripslashes($data->catchphrase); ?>"
				</div>
				<div class="site_box_content_inner" style="width: 532px;">
					<table border="0" width="100%">
						<tr class="user"><th class="user" colspan="2">BASIC INFO</th></tr>
						<tr class="user"><td  class="user"width="30%">Name</td><td class="user" width="73%"><?php echo $data->name; ?></td></tr>
						<tr class="user"><td class="user">Real Name</td><td class="user"><?php echo stripslashes($data->realName); ?></td></tr>
						<tr class="user"><td class="user">Sex</td><td class="user"><?php echo $usersex; ?></td></tr>
						<tr class="user"><td class="user">Sign</td><td class="user"><?php echo stripslashes($data->sign); ?></td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 10px;"></div></th></tr>
						<tr class="user"><th class="user" colspan="2">CONTACT INFO</th></tr>
						<tr class="user"><td class="user" valign="top">Email</td><td class="user"><?php echo stripslashes($data->email); ?></td></tr>
						<tr class="user"><td class="user" valign="top">AIM</td><td class="user"><?php echo stripslashes($data->aim); ?></td></tr>
						<tr class="user"><td class="user" valign="top">Website</td><td class="user"><a class="blue" href="<?php echo $data->website; ?>"><?php echo $data->website; ?></a></td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 10px;"></div></th></tr>
						<tr class="user"><th class="user" colspan="2">PERSONAL INFO</th></tr>
						<tr class="user"><td class="user" valign="top">Activities</td><td class="user">
							<div><?php echo $podunkton->PrintUserTags(1, $data->userID); ?></div>
						</td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 8px;"></div></th></tr>
						<tr class="user"><td class="user" valign="top">Music</td><td class="user">
							<div style="overflow: hidden;"><?php echo $podunkton->PrintUserTags(2, $data->userID); ?></div>
						</td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 8px;"></div></th></tr>
						<tr class="user"><td class="user" valign="top">Movies</td><td class="user">
							<div style="overflow: hidden;"><?php echo $podunkton->PrintUserTags(3, $data->userID); ?></div>
						</td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 8px;"></div></th></tr>
						<tr class="user"><td class="user" valign="top">Television</td><td class="user">
							<div style="overflow: hidden;"><?php echo $podunkton->PrintUserTags(1, $data->userID); ?></div>
						</td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 8px;"></div></th></tr>
						<tr class="user"><td  class="user"valign="top">Quotes</td><td class="user"><div style="overflow: hidden;"><?php echo stripslashes($data->quotes); ?></div></td></tr>
						<tr class="user"><th class="user" colspan="2"></th></tr>
					</table>
				</div>
				
			</div>
			
			
			
			<div style="display: none;">
					<div class="site_box" style="width: 532px;">
				
				<div class="site_box_holder" style="background-color: #fff;">			
					<div class="user_badges_small">
						<div class="user_badges_left">Displaying <?php echo $numRecent; ?> Event<?php if($numRecent > 1) { echo "s"; } ?></div><div style="clear: both;"></div>
					</div>
					<div class="site_box_content_inner" style="width: 530px;">
						<?php
							$resultActivity = $database->db_query("SELECT message, dateAdded, timeAdded FROM Users_Recent_Activity WHERE userID = ".$data->userID." ORDER BY dateAdded DESC, timeAdded DESC LIMIT 0, 10");
							
							$curDate = date("Y-m-d");
							$yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
							
							$rowActivity = mysqli_fetch_object($resultActivity);
							if($rowActivity->dateAdded == $curDate) {
						?>
								<div class="user_activity_date">Today</div>
						<?php } elseif($rowActivity->dateAdded == $yesterday) { ?>
								<div class="user_activity_date">Yesterday</div>
						<?php } else { ?>
								<div class="user_activity_date"><?php echo $prettyprint->prettydate($rowActivity->dateAdded, "[M] [D], [Y]"); ?></div>
						<?php
							}
							
							$usingDate = $rowActivity->dateAdded;

							do {
								if($usingDate != $rowActivity->dateAdded) {
									if($rowActivity->dateAdded == $yesterday) {
						?>
								<div class="user_activity_date">Yesterday</div>
						<?php	} else { ?>
								<div class="user_activity_date"><?php echo $prettyprint->prettydate($rowActivity->dateAdded, "[M] [D], [Y]"); ?></div>
						<?php 
								} 
							}
						?>
						<div class="default_icon" style="margin-left: 5px; margin-right: 10px;"></div>
						<div class="user_activity_row">
							<div class="user_activity_left"><?php echo $rowActivity->message; ?></div>
							<div class="user_activity_right"><span class="grey"><?php echo $prettyprint->prettydate($rowActivity->timeAdded, "[x] [cz]"); ?></span></div>
							<div style="clear: both;"></div>
						</div>
						<div style="clear: both;"></div>
						<?php } while($rowActivity = mysqli_fetch_object($resultActivity)); ?>
					</div>
				</div>
				</div>
			
				<div style="clear: both;"></div>
			
			</div>
			
			
			
			<div>
					
				<?php if($session->user) { ?>
					<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
					<div style="width: 100%; float: left;">
					
						<div style="float: left; margin-left: 20px;"><textarea id="commentText" style="width: 440px; height: 40px; margin: 0px; padding: 0px;">Add a Comment...</textarea></div>
						<div style="float: left; margin-top: 20px; margin-left: 6px;"><input type="button" value="Post" onclick="addComment()"/></div>
					</div>
					<div style="clear: both;"></div>
					<?php } ?>
					<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
					<div class="site_box" style="width: 542px; border-top: solid 1px #7e7e7e;">
						
					<?php
						$resultComments = $database->db_query("SELECT uc.comment, uc.dateSubmitted, u.name FROM Users as u JOIN Users_Comments as uc ON uc.commenterID = u.userID WHERE uc.userID = ".$data->userID." ORDER BY uc.dateSubmitted DESC LIMIT 0, 8");
					?>
						<div class="site_box_holder" style="background-color: #fff;">			
							<div class="user_badges_small" style="background-color: #eee; border-bottom: solid 1px #828282; ">
								<div class="user_badges_left">Displaying <b><?php echo COMMENTS_PER_PAGE; ?></b> comments out of <b>
								<?php
									$resultTotal = $database->db_query("SELECT COUNT(commentID) as 'count' FROM Users_Comments WHERE userID = ".$data->userID);
									$rowTotal = mysqli_fetch_object($resultTotal);
									echo $rowTotal->count;
								?></b> total
								</div>
								<div class="user_badges_right">
								</div>
								<div style="clear: both;"></div>
							</div>
							<div class="site_box_content_inner" id="commentSection" style="width: 533px;">
								<?php while($rowComments = mysqli_fetch_object($resultComments)) { ?>
								<div class="user_comment_left"><div class="user_comment_icon"></div></div>
								<div class="user_comment_right">
									<div class="user_comment_top"><a class="blue" href="/user/<?php echo $rowComments->name; ?>"><?php echo $rowComments->name; ?></a> said<br/>at <?php echo $prettyprint->prettydate($rowComments->dateSubmitted, "[x][cz] on [m] [d], [Y]"); ?></div>
									<div class="user_comment_bot">
										<?php echo $rowComments->comment; ?>
									</div>
								</div>
								<div style="clear: both;"></div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
					<div style="float: right; font-size: 8pt;">Goto Page
						<select id="pageSelect" onchange="changeCommentPage();">
						<?php for($i=1; $i<=ceil($rowTotal->count/COMMENTS_PER_PAGE); $i++){ ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
						</select>
					</div>
			</div>
			
			
			
			
		</div>
	</div>
	<div style="width: 235px; height: 8px;"></div>
	<?php
		$result = $database->db_query("SELECT message, dateAdded, timeAdded FROM Users_Recent_Activity WHERE userID = ".$data->userID." LIMIT 0, 10");
		$numRecent = mysqli_num_rows($result);
	?>
	
</div>

<div style="clear: both;"></div>
