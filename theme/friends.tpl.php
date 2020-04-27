<?php
	
	$manage = false;
	$loggedIn = false;
	
	if($core->args[1] == ""){
		include_once("theme/errordocs/404.tpl.php");
		die();
	}
	
	switch($core->args[1]) {
		case 1:
		case 2:
		case 3:
		case 4:
			break;
		default:
			include_once("theme/errordocs/404.tpl.php");
			die();
			break;
	}
	
	
	if($core->args[1] == ""){
		include_once("theme/errordocs/404.tpl.php");
		die();
	}
	
	if($core->args[2] != ""){
		if(!is_numeric($core->args[2])) {
			if($core->args[2] != "manage") {
				include_once("theme/errordocs/404.tpl.php");
				die();
			} else {
				$manage = true;
				if(!$session->user) {
					include_once("theme/errordocs/404.tpl.php");
					die();
				}
			}
		}
	} else {
		include_once("theme/errordocs/404.tpl.php");
		die();
	}
	
	if($session->user) {
		$loggedIn = true;
	}
	
	if($manage AND $loggedIn) {
		// Get total friends
		$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_has_Friends WHERE userID = ".$session->user." AND confirmed = 1");
		$rowTotal = mysqli_fetch_object($result);
		$totalFriends = $rowTotal->count;
		
		// Get friends online
		$result = $database->db_query("SELECT COUNT(uo.userID) as 'count' FROM Users_online as uo JOIN Users_has_Friends as uhf ON uo.userid = uhf.friendID WHERE uhf.userID = ".$session->user." AND uhf.confirmed = 1");
		$rowOnline = mysqli_fetch_object($result);
		$onlineFriends = $rowOnline->count;
		
		$offlineFriends = $totalFriends - $onlineFriends;
	}
	
	switch($core->args[1]) {
		case 1:
			$sort = "ORDER BY u.name ASC";
			break;
		case 2:
			$sort = "ORDER BY u.name DESC";
			break;
		case 3:
			$sort = "ORDER BY uhf.friendSince DESC";
			break;
		case 4:
			$sort = "ORDER BY uhf.friendSince ASC";
			break;
		default:
			include_once("theme/errordocs/404.tpl.php");
			die();
			break;
	}
	
?>

<script type="text/javascript">
	
	var ajax = new Ajax();
	var previousTag = "";
	var currentID = 0;

	function checkEnterSearch(event) {
		if(event && event.which == 13) {
			advancedSearch2();
		} else {
			return false;
		}
	}
	
	function advancedSearch2() {
		searchstr = document.getElementById('searchStr2');
		location='/search/1/'+searchstr.value;
	}
	
	function cancelFriendship(id, uid) {
		currentID = id;
		var text = document.getElementById("cancelFriendshipRow"+id);
		previousTag = text.innerHTML;
		text.innerHTML = "<div style='float: right; margin-right: 8px;'><div style='float: left; color: green; font-size: 8pt;'>CANCELING</div><div style='float: left; margin-left: 5px;'><img src='/theme/images/ajax-loader.gif' border='0' /></div><div style='clear: both;'></div></div>";
		ajax.doGet("/process/cancelFriend/"+uid, showResults);
	}
	
	function showResults(str) {
		if(str != "0"){
			var friendBox = document.getElementById("friendBox"+currentID);
			friendBox.style.display = "none";
			showMsg("You have canceled your friendship with "+str);
		} else {
			var text = document.getElementById("cancelFriendshipRow"+currentID);
			text.innerHTML = previousTag;
			showError("There was an error in canceling your friendship");
		}
		
	}
	
</script>

<link rel="stylesheet" type="text/css" href="/theme/scripts/friends.css" />

<div id="top_head">
	<div id="top_head_left">
		<?php if($manage AND $loggedIn) { ?>
		<div id="top_head_icon"><img src="/theme/images/friends_blue_icon.png" /></div>
		<div class="h7">FRIENDS LIST</div>
		<div class="darkerGrey" style="margin-top: 10px; "><?php echo $onlineFriends; ?> ONLINE | <?php echo $offlineFriends; ?> OFFLINE | <?php echo $totalFriends; ?> TOTAL</div>
		<?php } ?>
	</div>
	
	<div id="top_head_right">
<!--CHANGE THIS TO BE CORRECT :) KTHANKS-->
			<table border="0" style="padding: 0px; margin: 0px;">
				<tr>
					<td><div class="darkerGrey">SEARCH FOR USERS :</div></td>
					<td align="center"><input style="width: 145px; margin: 0px; padding: 0px;" type="text" id="searchStr2" onkeydown="checkEnterSearch(event);" value="<?php echo $searchStr; ?>"/></td>
					<td><img style="cursor: pointer;" src="/theme/images/login_button.png" onclick="advancedSearch2();" /></td>
				</tr>
			</table>				
			<table border="0" style="padding: 0px; margin: 0px;">
				<tr>
					<td><div class="darkerGrey">SORT FRIENDS LIST BY :</div></td>
					
					<td align="center">
						<select style="width: 130px; margin-bottom: 0px;" onchange="location='/friends/'+this.options[this.selectedIndex].value+'/<?php echo $core->args[2]; ?>';">
							<option value="-1">Sort By</option>
							<option value="1">Username A-Z</option>
							<option value="2">Username Z-A</option>
							<option value="3">Recent Friends</option>
							<option value="4">Old Friends</option>
						</select>
					</td>

				</tr>
			</table>
	</div>	
</div>



<div class="site_box" style="width: 790px; margin-top: 8px; clear: both;" >
	<div class="site_box_head" style="text-align: left;">
		<?php if($manage) { ?>
			<img src="/theme/images/site_box/manage_friends_header.png" style="padding-left: 4px;" />
		<?php } else { ?>
			<div class="user_title">VIEWING FRIENDS</div>
			<?php if($core->args[2] == $session->user) { ?>
				<div class="online"><a class="grey" href="/friends/1/manage">[manage]</a></div>
			<?php } ?>
		<?php } ?>
	</div>
	<div class="friends_site_box_content" style="background-color: #fff;">
		<div class="site_box_content_inner">
		
		<?php
			if(is_numeric($core->args[2])) {
				$result = $database->db_query("SELECT u.name, u.aim, u.userID, u.sex, uhf.friendID, uhf.friendSince FROM Users_has_Friends as uhf JOIN Users as u ON uhf.friendID = u.userID WHERE uhf.userID = ".$core->args[2]." AND confirmed = 1 ".$sort);
			} elseif($manage AND $loggedIn) {
				$result = $database->db_query("SELECT u.name, u.aim, u.userID, u.sex, u.aim, uhf.friendID, uhf.friendSince FROM Users_has_Friends as uhf JOIN Users as u ON uhf.friendID = u.userID WHERE uhf.userID = ".$session->user." AND confirmed = 1 ".$sort);
			}
			
			$idC = 0;
			
			while($row = mysqli_fetch_object($result)) {
		?>
		<!--THIS IS ONE FRIEND BOX. COOL HUH?-->
			<div class="friend_box" id="friendBox<?php echo $idC; ?>">
				<div class="friend_box_container">
					<div class="user_friend_icon">
						<?php echo $podunkton->imageAvatar($row->userID, $row->sex, 35, $idC, "friendAvatar"); ?>
					</div>
					
					<div class="friend_box_container_left">
						<table border="0" cellpadding="0" cellspacing="0" width="198">
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
					
					<?php if($manage) { ?>
					<div style="">
						<div style="float: left; margin-top: 4px;">
							<?php /* <div class="uglyRed2">IGNORED 
							<img style="" src="/theme/images/icons/led_red.png" />
							</div> */ ?>
						</div>
						
						<div style="float: right; margin-top: 4px; cursor: pointer;" id="cancelFriendshipRow<?php echo $idC; ?>" onclick="cancelFriendship(<?php echo $idC; ?>, <?php echo $row->friendID; ?>);return false;">
							<div class="uglyRed">CANCEL FRIENDSHIP
							<img style="margin-top: 2px;" src="/theme/images/icons/delete3.png" />
							</div>
						</div>
					</div>
					<div style="clear: both;"></div>
					<?php } ?>
				</div>
				
			</div>
			<!--thats the end of a friend box. WHEW-->
			<?php 
					$idC++;
				} 
			?>
			
		</div>
	</div>
	
	<div id="friends_ad">
		<img src="/theme/images/forums_ad2.png" />
	</div>

</div>