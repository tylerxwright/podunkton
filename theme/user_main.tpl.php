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
	$date2 = $prettyprint->prettyDate($data->signup, "[M] [D], [Y]");
	
	if($data->sex == "m"){
		$usersex = "Male";
	} else {
		$usersex = "Female";
	}
?>

<link rel="stylesheet" type="text/css" href="/theme/scripts/friends.css" />
<script type="text/javascript" src="/engine/jquery.js"></script>
<script type="text/javascript">
	
	var ajax = new Ajax();
	var previousFriendTag;
	var currentSelection = 1;
	var numTabs = 6;
	var detailsBoxUp = 0;
	
	$(document).ready(function() {
		tabSelected(document.getElementById("tab"+currentSelection));
	});
	
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
		if(text != ""){
			ajax.doGet("/process/addUserComment/<?php echo $data->userID; ?>/"+text, showComment);
		}
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
		
		//$('div#postArea').hide("normal");
		//var postArea = document.getElementById("postArea");
		/*postArea.innerHTML = "Don't spam your friends wall!";*/
		//postArea.innerHTML = "";
		
	}
	
	function changeCommentPage() {
		var pageSelect = document.getElementById('pageSelect');
		ajax.doGet("/process/getUserCommentPage/<?php echo $data->userID; ?>/"+pageSelect.options[pageSelect.selectedIndex].value, showAllComments);
	}
	
	function showAllComments(str) {
		var commentSection = document.getElementById("commentSection");
		commentSection.innerHTML = str;
	}
	
	function changeTab(type){
		if(type != currentSelection){
			currentSelection = type;
			
			for(i=1; i!=numTabs+1; i++){ 
				var content = document.getElementById("content"+i);
				
				if(i == type){
					$('div#content'+i).fadeIn("normal");
					tabSelected(document.getElementById("tab"+currentSelection));
				} else {
					content.style.display = "none";
					tabOut(document.getElementById("tab"+i));
				}
			}
			
		}
	}
	
	function tabHover(obj){
		
		var id = obj.id;
		if(id.substr(3, 1) != currentSelection){
			var styleFull;
			
			if(obj.currentStyle){ // IE Opera
				styleFull = obj.currentStyle.backgroundImage;
				styleFull = styleFull.substr(0, styleFull.length-9);
			} else { // Firefox
				styleFull = getComputedStyle(obj, '').getPropertyValue('background-image');
				styleFull = styleFull.substr(0, styleFull.length-8);
			}
			
			obj.style.backgroundImage = styleFull+"Hov.png)";
		}
		
	}
	
	function tabSelected(obj){
		
		var styleFull;
		
		if(obj.currentStyle){ // IE Opera
			styleFull = obj.currentStyle.backgroundImage;
			styleFull = styleFull.substr(0, styleFull.length-9);
		} else { // Firefox
			styleFull = getComputedStyle(obj, '').getPropertyValue('background-image');
			styleFull = styleFull.substr(0, styleFull.length-8);
		}
		
		obj.style.backgroundImage = styleFull+"Act.png)";
		
	}
	
	function tabOut(obj){
		
		var id = obj.id;
		if(id.substr(3, 1) != currentSelection){
			var styleFull;
			
			if(obj.currentStyle){ // IE Opera
				styleFull = obj.currentStyle.backgroundImage;
				styleFull = styleFull.substr(0, styleFull.length-9);
			} else { // Firefox
				styleFull = getComputedStyle(obj, '').getPropertyValue('background-image');
				styleFull = styleFull.substr(0, styleFull.length-8);
			}
			
			obj.style.backgroundImage = styleFull+"Off.png)";
		}
		
	}
	
	function removeDefaultComment(obj){
		if(obj.innerHTML == "Add a Comment..."){
			obj.innerHTML = "";
			obj.style.color = "#000";
		}
	}
	
	function defaultComment(obj){
		if(obj.innerHTML != "Add a Comment..." || obj.innerHTML == ""){
			obj.innerHTML = "Add a Comment...";
			obj.style.color = "#999";
		}
	}
	
	function getDetails(type, id){
		var detailsBox = document.getElementById("detailsBox");
		
		detailsBoxUp = 1;
		
		if(type == 1){
			ajax.doGet("/process/getBadgesDetails/"+id, showDetails);
		}
		
		detailsBox.innerHTML = "<div style='width: 100%; text-align: center; padding-top: 20px;'><b>LOADING</b><br/><img src='/theme/images/ajax-loader.gif' /></div>";
		detailsBox.style.display = "block";
		detailsBox.style.top = mouseY+"px";
		detailsBox.style.left = mouseX+20+"px";
		
	}
	
	function showDetails(str){
		var detailsBox = document.getElementById("detailsBox");
		detailsBox.innerHTML = str;
	}
	
	function closeDetails(){
		var detailsBox = document.getElementById("detailsBox");
		detailsBoxUp = 0;
		detailsBox.innerHTML = "";
		detailsBox.style.display = "none";
	}
	
	function getMousePos(e){
		if (!e)
			var e = window.event||window.Event;
		
		if('undefined'!=typeof e.pageX){
			mouseX = e.pageX;
			mouseY = e.pageY;
		} else {
			mouseX = e.clientX + document.body.scrollLeft;
			mouseY = e.clientY + document.body.scrollTop;
		}
	
		if(detailsBoxUp == 1){
			var detailsBox = document.getElementById("detailsBox");
			
			var pageWidth = document.documentElement.clientWidth;
			
			if(mouseX+40+300 >= pageWidth){
				mouseX = mouseX - 300 - 40;
			}
			
			detailsBox.style.top = mouseY+"px";
			detailsBox.style.left = mouseX+20+"px";
		}
	
	}
	
	// You need to tell Mozilla to start listening:
	
	if(window.Event && document.captureEvents)
	document.captureEvents(Event.MOUSEMOVE);
	
	// Then assign the mouse handler
	
	document.onmousemove = getMousePos;
	
</script>

<div id="detailsBox"></div>

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
		dummy:	"<?php echo time(); ?>"
		<?php if($data->isCrew == 1) { ?>, crewSwf: <?php echo "'".$data->crewFull."'"; } ?>
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#ffffff"
	};
	
	<?php if($data->isCrew == 1) { ?>
	swfobject.embedSWF("/characterBuilder/viewers/crewviewer.swf", "userViewer", "225", "298", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $data->sex; ?>_1.swf", "userViewer", "225", "298", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);	
	<?php } ?>
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
			<div class="user_title" style="padding:0px;"><img src="/theme/images/site_box/contacts_head.png" /></div>
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
				<div id="addFriendRow" class="user_contact_row"><div class="default_icon" style="background-color:#fff"><img src="/theme/images/icons/add_friend_icon.png" /></div><div id="addFriendText" class="user_contact_link"><a href="#" onclick="addFriend(<?php echo $data->userID; ?>);return false;">ADD AS A FRIEND</a></div><div style="clear: both;"></div></div>
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
	
	
	<?php if($data->userID == $session->user) { ?>
	<div id="user_toolbox">
		<div class="user_toolbox_title">My Notifications</div>
		<?php
			$notifiyCount = 0;
			$result = $database->db_query("SELECT COUNT(id) AS 'count' FROM Inbox WHERE isread = 0 AND reciever=".$session->user);
			$row = mysqli_fetch_object($result);
			if($row->count > 0){
		?>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/mail/inbox">INBOX (<?php echo $row->count; ?> new)</a></div>
			<div style="clear: both;"></div>
		</div>
		<?php
				$notifyCount++;
			}
		?>
		
		<?php
			$result = $database->db_query("SELECT tradeID FROM User_has_Trades WHERE viewed = 0 AND userID = ".$data->userID);
			while($rowT = mysqli_fetch_object($result)) {
		?>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/trade/<?php echo $rowT->tradeID; ?>">Trade Request</a></div>
			<div style="clear: both;"></div>
		</div>
		<?php 
				$notifyCount++;
			} 
		?>
		
		<?php if($notifyCount == 0) { ?>
			<div class="user_toolbox_row">
				<div style="padding-left: 8px; padding-bottom: 8px;">No notifications</div>
			</div>
		<?php } else { ?>
		<div style="height: 15px;"></div>
		<?php } ?>
		
		<div class="user_toolbox_title">My Quicklinks</div>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/user/<?php echo $data->name; ?>/edit">Edit Profile</a></div>
			<div style="clear: both;"></div>
		</div>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/build">Edit Character</a></div>
			<div style="clear: both;"></div>
		</div>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/mail">My Inbox</a></div>
			<div style="clear: both;"></div>
		</div>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/mail">My Sentbox</a></div>
			<div style="clear: both;"></div>
		</div>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/inventory">My Inventory</a></div>
			<div style="clear: both;"></div>
		</div>
		<div class="user_toolbox_row">
			<div class="user_toolbox_row_left"><div class="user_letter_icon"></div></div>
			<div class="user_toolbox_row_right"><a class="blue" href="/friends/1/manage">Manage Friends</a></div>
			<div style="clear: both;"></div>
		</div>
		<div style="height: 15px;"></div>
	</div>
	<?php } ?>
	
</div>

<div id="userTabs">
	<div class="tab" style="margin: 0px; padding-left: 2px;"><div id="tab1" onclick="changeTab(1);" onmouseover="tabHover(this);" onmouseout="tabOut(this);"></div></div>
	<div class="tab"><div id="tab2" onclick="changeTab(2);" onmouseover="tabHover(this);" onmouseout="tabOut(this);"></div></div>
	<div class="tab"><div id="tab3" onclick="changeTab(3);" onmouseover="tabHover(this);" onmouseout="tabOut(this);"></div></div>
	<div class="tab"><div id="tab4" onclick="changeTab(4);" onmouseover="tabHover(this);" onmouseout="tabOut(this);"></div></div>
	<div class="tab"><div id="tab5" onclick="changeTab(5);" onmouseover="tabHover(this);" onmouseout="tabOut(this);"></div></div>
	<div class="tab"><div id="tab6" onclick="changeTab(6);" onmouseover="tabHover(this);" onmouseout="tabOut(this);"></div></div>
	<div style="clear: both; line-height: 0px; font-size: 0pt;"></div>
</div>
<div class="user_middle">
	<div class="site_box" style="width: 542px;">
		
		<div class="site_box_user" style="background-color: #fff;">	


			<div id="content1">
				<div class="user_general_top">
					"<?php echo stripslashes($data->catchphrase); ?>"
				</div>
				<div class="site_box_content_inner" style="width: 532px;">
					<table border="0" width="100%">
						<tr class="user">
							<th class="user" colspan="2">
								<div style="float: left;">BASIC INFO</div>
								<div style="float: right;"><?php if($data->userID == $session->user) { ?><a class="edit" href="/user/<?php echo $data->name; ?>/edit">[edit]</a><?php } ?></div>
								<div style="clear: both;"></div>
							</th>
						</tr>
						<tr class="user"><td  class="user"width="30%">Name</td><td class="user" width="73%"><?php echo $data->name; ?></td></tr>
						<tr class="user"><td class="user">Real Name</td><td class="user"><?php echo stripslashes($data->realName); ?></td></tr>
						<tr class="user"><td class="user">Sex</td><td class="user"><?php echo $usersex; ?></td></tr>
						<tr class="user"><td class="user">Sign</td><td class="user"><?php echo stripslashes($data->sign); ?></td></tr>
						<tr class="user"><th class="user" colspan="2"><div style="height: 10px;"></div></th></tr>
						<tr class="user"><th class="user" colspan="2">CONTACT INFO</th></tr>
						<tr class="user"><td class="user" valign="top">Email</td><td class="user"><?php echo stripslashes($data->email); ?></td></tr>
						<tr class="user"><td class="user" valign="top">AIM</td><td class="user"><?php echo stripslashes($data->aim); ?></td></tr>
						<tr class="user"><td class="user" valign="top">Website</td><td class="user"><a class="blue" href="http://<?php echo $data->website; ?>"><?php echo $data->website; ?></a></td></tr>
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
			
			
			
			<div style="display: none;" id="content2">
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
			
			
			
			<div style="display: none;" id="content3">
					
				<?php if($session->user) { ?>
					<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
					<div style="width: 100%; float: left;">
						<div id="postArea" style="height: 40px;">
							<div style="float: left; margin-left: 20px;"><textarea id="commentText" style="width: 440px; height: 40px; margin: 0px; padding: 0px; color: #999;" onfocus="removeDefaultComment(this);" onblur="defaultComment(this);">Add a Comment...</textarea></div>
							<div style="float: left; margin-top: 20px; margin-left: 6px;"><input type="button" value="Post" onclick="addComment()"/></div>
						</div>
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
			
			<div style="display: none;" id="content4">
				<div style="width: 99%; float: left; padding: 5px 5px 5px 8px; overflow: hidden;" >
					<div class="badge_headers">Achievement Badges</div>
					<div id="badge_achievement_holder">
						<?php
							$resultBadges = $database->db_query("SELECT b.badgeID, b.icon FROM Badges as b JOIN Users_has_Badges as uhb ON b.badgeID = uhb.badgeID WHERE uhb.userID = ".$data->userID);
							while($rowBadges = mysqli_fetch_object($resultBadges)){
						?>
						<div class="badge_box">
							<img border="0" src="/content/badges/<?php echo $rowBadges->icon; ?>"   onmouseover="getDetails(1, <?php echo $rowBadges->badgeID; ?>);" onmouseout="closeDetails();"/>
						</div>
						<?php } ?>
					</div>
				</div>
			<div style="clear:both; line-height: 0px; font-size: 0pt;"></div>
			
			
			</div>
			
			<!--Stats-->
			<div style="display: none;" id="content5">
				<div id="statsContent">
					<table border="0">
						<tr><td class="statsTableLeft">Signup Date: </td><td class="statsTableRight"><?php echo $date2; ?></td><tr>
						<tr><td class="statsTableLeft">Total Posts: </td><td class="statsTableRight"><?php echo $data->posts; ?></td><tr>
					</table><br/>
					<span class="statsText">Level: </span>
					<span class="statsExpText">
						<?php echo $podunkton->calculateLevel($data->experience); ?>
					</span><br/>
					<span class="statsText">Experience: </span>
					<span class="statsExpText">
						<?php $boundsArr = $podunkton->getExpBounds($podunkton->calculateLevel($data->experience)); ?>
						<?php echo $data->experience; ?>/<?php echo $boundsArr[1]; ?>
					</span>
					<div id="bigExpBar">
						<div id="bigExpBarTop">
							<div id="bigExpBase"></div>
							<div id="bigExpTop" style="width: <?php echo $data->experience*100/$boundsArr[1]; ?>%;"></div>
						</div>
						<div id="bigExpBarBot">
							<div id="bigExpBaseReflection"></div>
							<div id="bigExpBotReflection" style="width: <?php echo $data->experience*100/$boundsArr[1]; ?>%;"></div>
						</div>
					</div>
					<span class="statsText">Good/Evil: </span>
					<span class="statsExpText">
						<?php echo $podunkton->showAuraBig($data->goodevil); ?>
					</span>
					<div id="bigExpBar">
						<div id="bigExpBarTop">
							<div id="bigExpBase"></div>
							<?php if($data->goodevil <= 0){ // Good ?>
							<div id="bigGoodTop" style="width: <?php echo abs($data->goodevil)*100/36; ?>%;"></div>
							<?php } else { // Evil ?>
							<div id="bigEvilTop" style="width: <?php echo abs($data->goodevil)*100/36; ?>%;"></div>
							<?php } ?>
						</div>
						<div id="bigExpBarBot">
							<div id="bigExpBaseReflection"></div>
							<?php if($data->goodevil <= 0){ // Good ?>
							<div id="bigGoodBotReflection" style="width: <?php echo abs($data->goodevil)*100/36; ?>%;"></div>
							<?php } else { // Evil?>
							<div id="bigEvilBotReflection" style="width: <?php echo abs($data->goodevil)*100/36; ?>%;"></div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			
			<!--Friends-->
			<div style="display: none;" id="content6">
				<div style="padding-left: 11px; padding-top: 11px;">
				<?php
					if($session->user){
						$loggedIn = 1;
					} else {
						$loggedIn = 0;
					}
					
					$result = $database->db_query("SELECT u.name, u.aim, u.userID, u.sex, uhf.friendID, uhf.friendSince FROM Users_has_Friends as uhf JOIN Users as u ON uhf.friendID = u.userID WHERE uhf.userID = ".$data->userID." AND confirmed = 1 ");
					$numFriends = mysqli_num_rows($result);
					$idC = 0;
					
					if($numFriends == 0){
				?>
					You have no friends
				<?php
					}
					
					while($row = mysqli_fetch_object($result)) {
				?>
				<!--THIS IS ONE FRIEND BOX. COOL HUH?-->
					<div class="friend_box" id="friendBox<?php echo $idC; ?>" style="height: 67px;">
						
						<div class="friend_box_container">
							<div class="user_friend_icon">
								<?php echo $podunkton->imageAvatar($row->userID, $row->sex, 35, $idC, "friendAvatar"); ?>
							</div>
							
							<div class="friend_box_container_left">
								<table border="0" cellpadding="0" cellspacing="0" width="170">
									<tr>
										<td><div class="darkerGreyBold">NAME :</div></td>
										<td align="right"><a class="blue" style="font-size: 8pt; font-weight: bold;" href="/user/<?php echo $row->name; ?>"><?php echo $row->name; ?></a></td>
									</tr>
									<tr>
										<td><div class="darkerGreyBold">FRIEND SINCE :</div></td>
										<td align="right"><div class="prettyBlue"><?php echo $row->friendSince; ?></div></td>
									</tr>
									<tr>
										<td><div class="darkerGreyBold">ACTIONS :</div></td>
										<td align="right" >
											<?php if($loggedIn) { ?>
											<form name="startTrade<?php echo $idC; ?>" action="/process/startTrade" method="POST" style="margin: 0px; padding: 0px;">
												<a href="/mail/compose/<?php echo $row->friendID; ?>"><img src="/theme/images/icons/message_friend.png" title="Private Message" /></a>
												<img style="cursor: pointer;" src="/theme/images/icons/trade_friend.png" title="Start Trade" onclick="document.startTrade<?php echo $idC; ?>.submit();" />
												<?php if($row->aim != "") { ?>
													<a title="Instant Message" href="aim:goim?screenname=<?php echo $row->aim; ?>;message=Hail+from+Podunkton!"><img src="/theme/images/icons/aim_friend.png" /></a>
												<?php } ?>
												<input type="hidden" name="uname" value="<?php echo $row->name; ?>"/>
											</form>
											<?php } ?>
										</td>
									</tr>
									
								</table>
							
							</div>
							<div style="clear: both;"></div>
						</div>
						
						<div class="friend_box_container_bot">
							<?php 
								$resultOnline = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online WHERE userid = ".$row->friendID);
								$rowOnline = mysqli_fetch_object($resultOnline);
							?>
							<div class="status_icon" <?php if($rowOnline->count == 0) { echo "style='background-image: url(/theme/images/icons/status_offline.png);'"; } ?>></div>
							
							<?php /* if($manage) { ?>
							<div style="">
								<div style="float: left; margin-top: 4px;">
									<div class="uglyRed2">IGNORED 
									<img style="" src="/theme/images/icons/led_red.png" />
									</div>
								</div>
								
								<div style="float: right; margin-top: 4px; cursor: pointer;" id="cancelFriendshipRow<?php echo $idC; ?>" onclick="cancelFriendship(<?php echo $idC; ?>, <?php echo $row->friendID; ?>);return false;">
									<div class="uglyRed">CANCEL FRIENDSHIP
									<img style="margin-top: 2px;" src="/theme/images/icons/delete3.png" />
									</div>
								</div>
							</div>
							<div style="clear: both;"></div>
							<?php } */ ?>
							<div style="clear: both;"></div>
							
						</div>
						
					</div>
					<!--thats the end of a friend box. WHEW-->
					<?php 
							$idC++;
						} 
					?>
					
				</div>
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
