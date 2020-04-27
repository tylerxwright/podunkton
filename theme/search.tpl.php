<?php
	
	$purifier = new HTMLPurifier();
	
	$isSearch = false;
	$pageNumber = 1;
	$forumusers = 0;
	
	if(isset($core->args[2])) {
		$searchStr = $core->args[2];
		if($searchStr == ""){
			$isSearch = false;
		} else {
			if(is_numeric($core->args[1])) {
				$pageNumber = $core->args[1];
			} else {
				$pageNumber = 1;
			}
			$isSearch = true;
		}
		if($core->args[2] == "allusers") {
			$forumusers = 1;
		} else {
			$searchStr = $purifier->purify($searchStr);
		}
	}
	
?>

<script type="text/javascript">
	
	var ajax = new Ajax();
	var previousFriendTag;
	var currentID;
	
	function addFriend(uid, id) {
		currentID = id;
		var text = document.getElementById("addAsFriendBtn"+id);
		previousFriendTag = text.innerHTML;
		text.innerHTML = "<div style='float: right; padding-top: 4px; margin-top: 8px; margin-right: 8px;'><div style='float: left; color: green; font-size: 8pt;'>ADDING</div><div style='float: left; margin-left: 5px;'><img src='/theme/images/ajax-loader.gif' border='0' /></div><div style='clear: both;'></div></div>";
		ajax.doGet("/process/addFriend/"+uid, showResults);
	}
	
	function showResults(str) {
		if(str == "1"){
			var friendRow = document.getElementById("addAsFriend"+currentID);
			friendRow.style.display = "none";
			showMsg("A confirmation message has been sent to <?php echo $data->name; ?>");
		} else {
			var text = document.getElementById("addAsFriendBtn"+currentID);
			text.innerHTML = previousFriendTag;
			showError("There was an error in adding <?php echo $data->name; ?> as a friend...sorry");
		}
		
	}
	
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
	
</script>

<link rel="stylesheet" type="text/css" href="/theme/scripts/user_search.css" />

<div id="top_head">
	<div id="top_head_left">
		<div id="top_head_icon"><img src="/theme/images/friends_blue_icon.png" /></div>
		<div class="h7">USER SEARCH</div>
		<div class="darkerGrey" style="margin-left: 10px; ">You can search by name, interests, or anything you want! Just type it in!</div>
	</div>
	
	<div id="top_head_right">
		<div id="search_bar">
			<div class="darkerGrey" style="font-size: 12px; font-weight: bold; margin-top: 2px; margin-left: 5px;">
				<table>
					<tr>
					<td>SEARCH USERS :</td>
					<td align="center"><input style="width: 145px; margin: 0px; padding: 0px;" type="text" id="searchStr2" onkeydown="checkEnterSearch(event);" value="<?php echo $searchStr; ?>"/></td>
					<td><img style="cursor: pointer;" src="/theme/images/login_button.png" onclick="advancedSearch2();" /></td>
					</tr>
				</table>
			</div>
		</div>
			
	</div>	
</div>

<?php
	if($isSearch == true) {
		
		if($forumusers == 1) {
			$result = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online");
			$rowNum = mysqli_fetch_object($result);
		} else {
			$result = $database->db_query("SELECT COUNT(u.userID) as 'count' FROM Users as u WHERE u.name LIKE '%$searchStr%' OR u.aim LIKE '%$searchStr%' OR u.msn LIKE '%$searchStr%' OR u.icq LIKE '%$searchStr%' OR u.realName LIKE '%$searchStr%' OR u.sign LIKE '%$searchStr%' OR u.website LIKE '%$searchStr%' OR (SELECT t.name FROM Tags as t JOIN Users_has_Tags as uht ON uht.tagID = t.tagID WHERE uht.userID = u.userID AND t.name LIKE '%$searchStr%') LIKE '%$searchStr%' ");
			$rowNum = mysqli_fetch_object($result);
		}
?>
<div class="site_box" style="width: 790px; margin-top: 8px; clear: both;" >
	<div class="site_box_head" style="text-align: left;">
		<img src="/theme/images/site_box/head_search_results.png" style="padding-left: 4px;" />
	</div>
	
	<div class="friends_site_box_content" style="background-color: #fff;">
	
		<div id="greyBar">
			<div style="float:left;">
				<?php if($rowNum->count > 0) { ?>
				<div class="darkerGreyBold" style="float:left;">
					Displaying <?php echo ($pageNumber-1)*ADVANCED_RESULTS_PER_PAGE+1 ?> - 
					<?php 
						if(($pageNumber-1)*ADVANCED_RESULTS_PER_PAGE+$rowNum->count < ($pageNumber)*ADVANCED_RESULTS_PER_PAGE){
							echo ($pageNumber-1)*ADVANCED_RESULTS_PER_PAGE+$rowNum->count;
						} else {
							echo ($pageNumber)*ADVANCED_RESULTS_PER_PAGE;
						}
						
					?> of 
				<?php 
					echo $rowNum->count; 
					if($rowNum > 1){
				?>
					results
				<?php } else { ?>
					result
				<?php } ?>
				 for: </div>
				<div class="blackBold" style="float:left;"> &nbsp; <?php echo $searchStr; ?></div>
				<?php } ?>
			</div>
			
			<div style="float:right;">
				<?php if($rowNum->count > 0) { ?>
				<div class="prettyBlue" style="float:right; margin-right:5px;">
					<?php if($pageNumber > 1){ ?>
						<a class="blue" href="/search/<?php echo $pageNumber-1; ?>/<?php echo $searchStr; ?>">PREV</a>
					<?php } ?>
					<?php if(($pageNumber-1)*ADVANCED_RESULTS_PER_PAGE+$rowNum->count >= ($pageNumber)*ADVANCED_RESULTS_PER_PAGE) { ?>
						<a class="blue" href="/search/<?php echo $pageNumber+1; ?>/<?php echo $searchStr; ?>">NEXT</a>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			
		</div>
	
	<div class="site_box_content_inner">
		
	
	<?php 
		if($rowNum->count > 0) { 
			$idC = 0;
			$limit = ($pageNumber-1)*ADVANCED_RESULTS_PER_PAGE . ", " . ADVANCED_RESULTS_PER_PAGE;
			
			if($forumusers == 1) {
				$result = $database->db_query("SELECT DISTINCT u.name, u.sex, u.sign, u.signup, u.userID, u.aim FROM Users as u JOIN Users_online as uo ON u.userID = uo.userid LIMIT $limit");
			} else {
				$result = $database->db_query("SELECT DISTINCT u.name, u.sex, u.sign, u.signup, u.userID, u.aim FROM Users as u WHERE u.name LIKE '%$searchStr%' OR u.aim LIKE '%$searchStr%' OR u.msn LIKE '%$searchStr%' OR u.icq LIKE '%$searchStr%' OR u.realName LIKE '%$searchStr%' OR u.sign LIKE '%$searchStr%' OR u.website LIKE '%$searchStr%' OR (SELECT t.name FROM Tags as t JOIN Users_has_Tags as uht ON uht.tagID = t.tagID WHERE uht.userID = u.userID AND t.name LIKE '%$searchStr%') LIKE '%$searchStr%' LIMIT $limit");
			}
				
			while($row = mysqli_fetch_object($result)) {
				if($row->sex == "m") {
					$sex = "MALE";
				} else {
					$sex = "FEMALE";
				}
	?>
	<!--THIS IS ONE FRIEND BOX. COOL HUH?-->
		<div class="friend_box">
			<div class="friend_box_container">
				
				<div style="float:left; padding: 5px;">
					<div class="user_friend_icon">
						<?php echo $podunkton->imageAvatar($row->userID, $row->sex, 35, $idC, "searchAvatar"); ?>
					</div>
					
					<div class="friend_box_container_left">
						<table border="0" cellpadding="0" cellspacing="0" width="198">
							<tr>
								<td><div class="darkerGreyBold">NAME :</div></td>
								<td align="left"><a href="/user/<?php echo  $row->name; ?>" class="prettyBlue"><?php echo strtoupper($row->name); ?></a></td>
							</tr>
							<tr>
								<td><div class="darkerGreyBold">SEX :</div></td>
								<td align="left"><div class="prettyBlue"><?php echo $sex; ?></div></td>
							</tr>
							<tr>
								<td><div class="darkerGreyBold">SIGN :</div></td>
								<td align="left" ><a href="/search/1/<?php echo  $row->sign; ?>" class="prettyBlue"><?php echo strtoupper($row->sign); ?></a></td>
							</tr>
							<tr>
								<td><div class="darkerGreyBold">SIGN-UP DATE:</div></td>
								<td align="left" ><div class="prettyBlue"><?php echo $prettyprint->prettydate($row->signup, "[m] [d], [Y]"); ?></div></td>
							</tr>
							<tr>
								<?php
									$resultOnline = $database->db_query("SELECT COUNT(userID) as 'count' FROM Users_online WHERE userID = ".$row->userID);
									$rowOnline = mysqli_fetch_object($resultOnline);
									if($rowOnline->count == 1) {
								?>
								<td style="padding-top: 2px;"><img src="/theme/images/icons/status_online2.png" /></td>
								<?php } else { ?>
								<td style="padding-top: 2px;"><img src="/theme/images/icons/status_offline2.png" /></td>
								<?php } ?>
								<?php /*<td>
									<div class="uglyRed2">IGNORED 
									<img style="" src="/theme/images/icons/led_red.png" />
									</div>
								</td> */ ?>
							</tr>
							
						</table>
					
					</div>
				</div>
				
				<div style="float: right;">
					
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td align="right"><div class="actions_tab" <?php if(!$session->user) { echo "style='display: none;'"; } ?>>
								<form name="startTrade<?php echo $idC; ?>" action="/process/startTrade" method="POST" style="margin: 0px; padding: 0px;">
									<a href="/mail/compose/<?php echo $row->userID; ?>"><img src="/theme/images/icons/message_friend.png" title="Private Message" /></a>
									<img style="cursor: pointer;" src="/theme/images/icons/trade_friend.png" title="Start Trade" onclick="document.startTrade<?php echo $idC; ?>.submit();" />
									<?php if($row->aim != "") { ?>
										<a title="Instant Message" href="aim:goim?screenname=<?php echo $row->aim; ?>;message=Hail+from+Podunkton!"><img src="/theme/images/icons/aim_friend.png" /></a>
									<?php } ?>
									<input type="hidden" name="uname" value="<?php echo $row->name; ?>"/>
								</form>
							</div></td>
						</tr>
						<?php
							if($session->user AND $session->user != $row->userID) {
								$resultFriend = $database->db_query("SELECT COUNT(id) as 'count' FROM Users_has_Friends WHERE userID = ".$session->user." AND friendID=".$row->userID);
								$rowIsFriend = mysqli_fetch_object($resultFriend);
								if($rowIsFriend->count == 0) {
						?>
						<tr id="addAsFriend<?php echo $idC; ?>">
							<td id="addAsFriendBtn<?php echo $idC; ?>" align="right" ><div class="right_side_box" style="margin-top: 8px;"><img src="/theme/images/icons/add_friend.png" style="cursor: pointer;" onclick="addFriend(<?php echo $row->userID; ?>, <?php echo $idC; ?>);return false;" /></div></td>
						</tr>
						<?php } } ?>
						<tr>
							<td align="right"><div class="right_side_box"><img src="/theme/images/icons/view_friends.png" style="cursor: pointer;" onclick="location='/friends/1/<?php echo $row->userID; ?>';" /></div></td>
						</tr>
					</table>
				</div>
				
			</div>	
		</div>
		<!--thats the end of a friend box. WHEW-->
	<?php 
				$idC++;
			}
		} else { 
	?>
		We didn't find any users in your search of <?php echo $searchStr; ?>.
	<?php } ?>
	</div>
</div>
<?php
	}
?>
	
	
	<div id="friends_ad">
		<img src="/theme/images/forums_ad2.png" />
	</div>

</div>