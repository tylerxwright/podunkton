<?php
	global $msgObj;
	global $session;
	
	$user = $session->user;
?>

<link rel="stylesheet" type="text/css" href="/theme/scripts/forums_topic.css" />

<script type="text/javascript">
	
	var ajax = new Ajax();
	var currentID = 0;
	
	function vote(optionID) {
		ajax.doGet("/process/pollVote/"+optionID, showResults);
	}
	
	function showResults(str) {
		document.getElementById("pollResults").innerHTML = str;
		showMsg("You have just made <?php echo MUNNIEZ_PER_THUMB; ?> munniez for voting in this poll!");
		
		var myMunniez = document.getElementById("munniez");
		var currentMunniez = parseInt(myMunniez.innerHTML);
		var newMunniez = currentMunniez + <?php echo MUNNIEZ_PER_THUMB; ?>;
		myMunniez.innerHTML = newMunniez;
	}
	
	function thumbVote(vote, id, postID) {
		currentID = id;
		ajax.doGet("/process/thumb/"+vote+"/"+id+"/"+postID, showThumb);
	}
	
	function showThumb(str) {
		document.getElementById("thumb"+currentID).innerHTML = str;
		showMsg("You have just made <?php echo MUNNIEZ_PER_THUMB; ?> munniez for thumbing!");
		
		var myMunniez = document.getElementById("munniez");
		var currentMunniez = parseInt(myMunniez.innerHTML);
		var newMunniez = currentMunniez + <?php echo MUNNIEZ_PER_THUMB; ?>;
		myMunniez.innerHTML = newMunniez;
	}
	
	function showPost(str) {
		document.getElementById(str).style.display = "block";
	}
	
</script>

<?php
	$resultS = $database->db_query("SELECT * FROM Forum_Subcategory WHERE safeName='".$core->args[1]."'");
	$rowS = mysqli_fetch_object($resultS);
	
	$resultC = $database->db_query("SELECT * FROM Forum_Category WHERE categoryID=".$rowS->categoryID);
	$rowC = mysqli_fetch_object($resultC);
	
	/*$resultT = $database->db_query("SELECT * FROM Forum_Thread WHERE subcategoryID=".$rowS->subcategoryID);
	$rowT = mysqli_fetch_object($resultT);*/
	$tID = $core->args[3];
	$resultT = $database->db_query("SELECT * FROM Forum_Thread WHERE threadID=$tID AND subcategoryID=".$rowS->subcategoryID);
	$rowT = mysqli_fetch_object($resultT);
	
	$resultCount = $database->db_query("SELECT count(postID) as 'count' FROM Forum_Post WHERE threadID=".$rowT->threadID);
	$rowCount = mysqli_fetch_object($resultCount);
	
	$toleranceMin = -$rowT->toleranceMin;
	
	$numPages = ceil($rowCount->count/RESULTS_PER_PAGE);
	$postCount = 0;
	
	if($core->args[4] == "") {
		$page = 1;
	} else {
		$page = $core->args[4];
	}
	
	$sortBy = $core->args[2];
	if($sortBy != "oldest" and $sortBy != "newest"){
		$sortBy = "newest";
	}
	
	$postList = array();
	$kids = array();
	
	if($sortBy == "newest"){
		$postParentsResult = $database->db_query("SELECT postID FROM Forum_Post WHERE parent=0 AND threadID=".$rowT->threadID." ORDER BY dateAdded DESC");
		$postKidsResult = $database->db_query("SELECT postID, parent FROM Forum_Post WHERE parent>0 AND threadID=".$rowT->threadID." ORDER BY dateAdded ASC");
	} elseif($sortBy == "oldest") {
		$postParentsResult = $database->db_query("SELECT postID FROM Forum_Post WHERE parent=0 AND threadID=".$rowT->threadID." ORDER BY dateAdded ASC");
		$postKidsResult = $database->db_query("SELECT postID, parent FROM Forum_Post WHERE parent>0 AND threadID=".$rowT->threadID." ORDER BY dateAdded ASC");
	}
	
	while($postKids = mysqli_fetch_object($postKidsResult)){
		$tmp = array($postKids->postID, $postKids->parent);
		array_push($kids, $tmp);
	}
	
	while($postParents = mysqli_fetch_object($postParentsResult)){
		
		array_push($postList, $postParents->postID);
		
		foreach($kids as $kid){
			if($kid[1] == $postParents->postID){
				array_push($postList, $kid[0]);
			}
		}
		
	}
	
	$thisPage = array();
	
	if(($page)*RESULTS_PER_PAGE > $rowCount->count) {
		$endPage = $rowCount->count;
	} else {
		$endPage = ($page)*RESULTS_PER_PAGE;
	}
	
	for($i=($page-1)*RESULTS_PER_PAGE; $i<$endPage; $i++) {
		array_push($thisPage, $postList[$i]);
	}
	
?>

<div class="forums_topic_top" style="margin-top: 8px;">
	<div class="forums_topic_top_left">
		<div id="forums_minor_title"><?php echo $rowT->subject; ?></div>
		<?php
			$resultTags = $database->db_query("SELECT t.tagID, t.name FROM Thread_has_Tags as tht JOIN Tags as t ON tht.tagID = t.tagID WHERE tht.threadID=".$rowT->threadID);
			if(mysqli_num_rows($resultTags) > 0){
		?>
			<div class="forums_topic_tags">Tags: 
		<?php 
			while($rowTag = mysqli_fetch_object($resultTags)) {
				if(substr($rowTag->name, 0, 1) == " "){
					$rowTag->name = substr($rowTag->name, 1, strlen($rowTag->name));
				}
		?>
				<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/tag/<?php echo $rowTag->name; ?>"><?php echo $rowTag->name; ?></a>
		<?php 	} ?>
			</div>
		<?php } ?>
		<?php if($session->user){ ?>
		<div class="forums_topic_reply">
			<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $rowT->threadID; ?>"><img border="0" src="/theme/images/reply_to_topic.png" /></a>
		</div>
		<?php } ?>
	</div>
	<div class="forums_topic_top_right">
		<div class="forums_topic_top_bread">
			<a class="blue" href="/forums"><?php echo $rowC->name; ?></a> - 
			<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>"><?php echo $rowS->name; ?></a> - 
			<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowT->threadID; ?>"><?php echo $rowT->subject; ?></a>
		</div>
		<div class="forums_topic_bread">
			Topics <?php echo ($page-1)*RESULTS_PER_PAGE+1; ?> - <?php echo $endPage; ?> of <?php echo $rowCount->count; ?> 
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/1"><?php echo "first"; ?> </a>
			<?php if($page > 1) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $page-1; ?>"><?php echo "<"; ?> </a>
			<?php } ?>
			<?php
				if($numPages > 5){
					if($page > 3){
						for($i=$page-2; $i<=$page; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
						for($i=$page+1; $i<=$page+3; $i++){
							if($i > $numPages) {
								break;
							}
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
					} else {
					
						for($i=1; $i<=3; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
						echo "...";
						for($i=$numPages-1; $i<=$numPages; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
					}
				} else {
					for($i=1; $i<=$numPages; $i++){
						if($i == $page){
			?>
								<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
								<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
						}
					}
				}
			?>
			<?php if($page < $numPages) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $page+1; ?>"><?php echo ">"; ?> </a>
			<?php } ?>
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $numPages; ?>"><?php echo "last"; ?> </a>
		</div>
		<div class="forums_newToOld">
			<form action="" method="POST" style="margin: 0px; padding: 0px;">
				<select class="forums_select_order" name="selectForum" onchange="location='/forums/<?php echo $rowS->safeName; ?>/'+this.options[this.selectedIndex].value + '/<?php echo $rowT->threadID; ?>/<?php echo $page; ?>';">
					<option value="newest">Sort By</option>
					<option value="newest">Newest to Oldest</option>
					<option value="oldest">Oldest to Newest</option>
				</select>
			</form>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
<!--<div style="width: 785px; height: 8px; margin: 0px; padding: 0px;"></div>-->

<?php
	$resultPoll = $database->db_query("SELECT * FROM Forum_Poll WHERE threadID=".$rowT->threadID);
	if(mysqli_num_rows($resultPoll) != 0){
		$rowPoll = mysqli_fetch_object($resultPoll);
?>
<div id="forums_topics_poll" style="margin-top: 8px;">
	<div id="forums_topics_poll_inner">
		<div id="forums_topics_poll_header">
			<div id="forums_topics_poll_icon">
			
			</div>
			<div id="forums_topics_poll_title">PUBLIC POLL</div>
			<div style="clear: both;"></div>
		</div>
		<div id="forums_topics_poll_content">
			<?php echo $rowPoll->question; ?><br/>
			<div id="pollResults">
				<?php
					if($session->user) {
					$pollR2 = $database->db_query("SELECT COUNT(id) as 'count' FROM Forum_Poll_Users WHERE userID=".$session->user." AND pollID=".$rowPoll->pollID);
					$rowPR2 = mysqli_fetch_object($pollR2);
					if($rowPR2->count < 1) {
				?>
					<form action="" method="POST">
						<?php
							$resultOption = $database->db_query("SELECT * FROM Forum_Poll_Option WHERE pollID=".$rowPoll->pollID);
							while($rowOption = mysqli_fetch_object($resultOption)) {
						?>
							<input type="radio" name="poll" onclick="vote(<?php echo $rowOption->optionID; ?>);" /> <?php echo $rowOption->optionQ; ?><br/>
						<?php } ?>
					</form>
				<?php } else { 
					$optionArr = array();
					$total = 0;
					echo "<table border='0' style='width: 780px;'>";
					$resultPO = $database->db_query("SELECT fo.optionQ, fo.votes, fo.pollID FROM Forum_Poll_Option as fo WHERE fo.pollID = ".$rowPoll->pollID);
					while($rowPO = mysqli_fetch_object($resultPO)) {
						$tmp = array($rowPO->optionQ, $rowPO->votes);
						array_push($optionArr, $tmp);
						$total += $rowPO->votes;
					}
					
					foreach($optionArr as $option) {
						if($option[1] == 0){
							$percent = 0;
						} else {
							$percent = $option[1]*100/$total;
						}
						echo "<tr><td width='47%' align='right'>".$option[0].": </td><td width='53%' align='left' style='padding-top: 5px;'><div class='xpside'></div><div class='xpmain'><div class='xpfill' style='width: ".$percent."%;'></div></div><div class='xpside'></div><div style='float: left; font-size: 7pt; line-height: 8pt; padding-left: 5px;'>".round($percent)."%</div><div style='clear: both;'></div></td></tr>";
					}
					echo "</table>";
				?>
					
				<?php } 
					} else {
					$optionArr = array();
					$total = 0;
					echo "<table border='0' style='width: 780px;'>";
					$resultPO = $database->db_query("SELECT fo.optionQ, fo.votes, fo.pollID FROM Forum_Poll_Option as fo WHERE fo.pollID = ".$rowPoll->pollID);
					while($rowPO = mysqli_fetch_object($resultPO)) {
						$tmp = array($rowPO->optionQ, $rowPO->votes);
						array_push($optionArr, $tmp);
						$total += $rowPO->votes;
					}
					
					foreach($optionArr as $option) {
						if($option[1] == 0){
							$percent = 0;
						} else {
							$percent = $option[1]*100/$total;
						}
						echo "<tr><td width='47%' align='right'>".$option[0].": </td><td width='53%' align='left' style='padding-top: 5px;'><div class='xpside'></div><div class='xpmain'><div class='xpfill' style='width: ".$percent."%;'></div></div><div class='xpside'></div><div style='float: left; font-size: 7pt; line-height: 8pt; padding-left: 5px;'>".round($percent)."%</div><div style='clear: both;'></div></td></tr>";
					}
					echo "</table>";
					}
				?>
			</div>
		</div>
	</div>
</div>
<!--<div style="width: 792px; height: 8px;"></div>-->
<?php } ?>

<?php
	$idC = 0;
	$k = 0;
	foreach($thisPage as $postID) {
		$resultP = $database->db_query("SELECT * FROM Forum_Post WHERE postID=".$postID);
		$rowP = mysqli_fetch_object($resultP);
		$userResult = $database->db_query("SELECT * FROM Users WHERE userID=".$rowP->author);
		$rowU = mysqli_fetch_object($userResult);
		
		$date = $prettyprint->prettyDate($rowU->signup, "[m] [d], [y]");
		
		if($data->sex == "m"){
			$usersex = "Male";
		} else {
			$usersex = "Female";
		}
		
		if($rowP->parent == 0) {
		
?>
<div class="site_box" style="width: 790px; margin-top: 8px;">
	<?php if($rowP->tolerance >= $toleranceMin) { ?>
	<div class="site_box_head" style="text-align: left;">
	<?php } else {?>
	<div class="site_box_head" style="text-align: left; background-image: url('/theme/images/site_box/head_center_dull.png');">
	<?php } ?>
		<div class="forum_head">
			<div class="forum_head_icon">
				<img src="/theme/images/onlineicon.png" style="behavior: url(/iepngfix.htc);"/>
			</div>
			<div class="forum_head_center">
				<span class="whitebold10"><a class="white" href="/user/<?php echo $rowU->name; ?>"><?php echo $rowU->name; ?></a></span>
				<?php
					$userid = $rowU->userID;
					if(!$userid) {
						$userid = 0;
					}
					$onlineResult = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online WHERE userid = $userid");
					$onlinedata = mysqli_fetch_object($onlineResult);
					if($onlinedata->count > 0) {
				?>
						<span class="online">[online]</span>
				<?php } else { ?>
						<span class="offline">[offline]</span>
				<?php } ?>
				<?php if($rowP->tolerance < $toleranceMin) { ?>
					<a href="#" onclick="showPost('post<?php echo $rowP->postID; ?>');this.innerHTML = '';return false;"><span class="grey10" style="color: #333;" >Under viewing threshold, click to view</span></a>
				<?php } ?>
			</div>
			<?php
				if($user) {
					$thumbResult = $database->db_query("SELECT id FROM Forum_Thumb_Users WHERE userID = $user AND postID = ".$rowP->postID);
					$numThumb = mysqli_num_rows($thumbResult);
				} else {
					$numThumb = 1;
				}
				
				if($rowP->tolerance > 0) {
					$tol = "+".$rowP->tolerance;
				} elseif($rowP->tolerance < 0) {
					$tol = $rowP->tolerance;
				} else {
					$tol = $rowP->tolerance;
				}
			?>
			<div class="forums_head_right" id="thumb<?php echo $idC; ?>">
				<?php if($numThumb == 0) { ?>
				<div style="float: left; padding-top: 6px; padding-right: 10px;">
					<?php echo $tol; ?> Thumbs
				</div>
				<div style="padding-top: 4px; padding-right: 8px; float: left;">
					<img style="cursor: pointer;" src="/theme/images/thumbMinus.png" title="Hated it!" onclick="thumbVote(1, <?php echo $idC; ?>, <?php echo $rowP->postID; ?>);" style="behavior: url(/iepngfix.htc);"/>
					<img style="cursor: pointer;" src="/theme/images/thumbPlus.png" title="Loved it!" onclick="thumbVote(2, <?php echo $idC; ?>, <?php echo $rowP->postID; ?>);" style="behavior: url(/iepngfix.htc);"/>
				</div>
				<div style="clear: both;"></div>
				<?php } else { ?>
					<div class='forums_thumb_vote'><?php echo $tol; ?> Thumbs</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php if($rowP->tolerance < $toleranceMin) { ?>
		<div class="forums_post_content" id="post<?php echo $rowP->postID; ?>" style="display: none;">
	<?php } else { ?>
		<div class="forums_post_content">
	<?php } ?>
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
	swfobject.embedSWF("/characterBuilder/viewers/crewviewer.swf", "forumsLeftViewer<?php echo $k; ?>", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $rowU->sex; ?>_1.swf", "forumsLeftViewer<?php echo $k; ?>", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);	
	<?php } ?>
</script>

			<a href="/user/<?php echo $rowU->name; ?>">
			<div class="forums_post_character">
				<div style="cursor: pointer;" onclick="location='/user/<?php echo $rowU->name; ?>';">
					<div id="forumsLeftViewer<?php echo $k; ?>">
					
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
			<?php
				if($rowP->actionID != 0){
					$resultAction = $database->db_query("SELECT message FROM Forum_Actions WHERE actionID = ".$rowP->actionID);
					$rowAction = mysqli_fetch_object($resultAction);
			?>
				<div class="actionsBox">
					<div class="actionsInner">
						<?php echo $rowAction->message; ?>
					</div>
				</div>
			<?php } ?>
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
							<div style="float: right;">Posted on <?php echo $prettyprint->prettyDate($rowP->dateAdded, "[M] [D], [Y] at [x] [CZ]"); ?></div>
						</div>
						<div  class="forums_bubble_inner_bot">
							<div class="forums_post_thepost">
								<?php echo stripslashes($rowP->post); ?>
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
					<?php if($user != $rowU->userID AND $user) { ?>
					<form name="startTrade<?php echo $idC; ?>" action="/process/startTrade" method="POST" style="margin: 0px; padding: 0px;">
						<a href="/mail/compose/<?php echo $rowU->userID; ?>"><img src="/theme/images/icon_pm2.png" title="Private Message" /></a>
						<img style="cursor: pointer;" src="/theme/images/icon_trade2.png" title="Start Trade" onclick="document.startTrade<?php echo $idC; ?>.submit();" />
						<?php if($rowU->aim != "") { ?>
							<a title="Instant Message" href="aim:goim?screenname=<?php echo $rowU->aim; ?>;message=Hail+from+Podunkton!"><img src="/theme/images/icon_aim2.png" /></a>
						<?php } ?>
						<input type="hidden" name="uname" value="<?php echo $rowU->name; ?>"/>
					</form>
					<?php } ?>
				</div>
				<div class="forums_post_tools_right">
					<?php if($session->user){ ?>
					<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $rowT->threadID; ?>/reply/<?php echo $rowP->postID; ?>/<?php echo $page; ?>"><img src="/theme/images/button_reply_post.png" style="behavior: url(/iepngfix.htc);"/></a>
					<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $rowT->threadID; ?>/quote/<?php echo $rowP->postID; ?>/<?php echo $page; ?>"><img src="/theme/images/button_quote.png" style="behavior: url(/iepngfix.htc);"/></a>
					<?php } ?>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
	<!--<div style="width: 792px; height: 8px;"></div>-->
</div>
<?php
	} else {
?>
	<div style="float: left; width: 106px;">&nbsp
		<?php if($rowP->tolerance < $toleranceMin) { ?>
		<div class="forums_replied_left" id="postarrow<?php echo $rowP->postID; ?>" style="display: none;">
		<?php } else { ?>
		<div class="forums_replied_left">
		<?php } ?>
			<img src="/theme/images/replied_arrow.png" />
		</div>
	</div>
	<div class="forums_replied_right" style="margin-top: 8px;">
		<div class="site_box" style="width: 686px;">
			<?php if($rowP->tolerance >= $toleranceMin) { ?>
			<div class="site_box_head" style="text-align: left;">
			<?php } else {?>
			<div class="site_box_head" style="text-align: left; background-image: url('/theme/images/site_box/head_center_dull.png');">
			<?php } ?>
				<div class="forum_head">
					<div class="forum_head_icon">
						<img src="/theme/images/onlineicon.png" style="behavior: url(/iepngfix.htc);"/>
					</div>
					<div class="forum_head_center">
						<span class="whitebold10"><a class="white" href="/user/<?php echo $rowU->name; ?>"><?php echo $rowU->name; ?></a></span>
						<?php
							$userid = $rowU->userID;
							if(!$userid) {
								$userid = 0;
							}
							$onlineResult = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online WHERE userid = $userid");
							$onlinedata = mysqli_fetch_object($onlineResult);
							if($onlinedata->count > 0) {
						?>
								<span class="online">[online]</span>
						<?php } else { ?>
								<span class="offline">[offline]</span>
						<?php } ?>
						<?php if($rowP->tolerance < $toleranceMin) { ?>
							<a href="#" onclick="showPost('post<?php echo $rowP->postID; ?>');showPost('postarrow<?php echo $rowP->postID; ?>');this.innerHTML = '';return false;"><span class="grey10" style="color: #333;" >Under viewing threshold, click to view</span></a>
						<?php } ?>
						<span class="grey10"></span>
					</div>
					<?php
						if($user) {
							$thumbResult = $database->db_query("SELECT id FROM Forum_Thumb_Users WHERE userID = $user AND postID = ".$rowP->postID);
							$numThumb = mysqli_num_rows($thumbResult);
						} else {
							$numThumb = 1;
						}
						
						if($rowP->tolerance > 0) {
							$tol = "+".$rowP->tolerance;
						} elseif($rowP->tolerance < 0) {
							$tol = $rowP->tolerance;
						} else {
							$tol = $rowP->tolerance;
						}
					?>
					<div class="forums_head_right" id="thumb<?php echo $idC; ?>">
						<?php if($numThumb == 0) { ?>
						<div style="float: left; padding-top: 6px; padding-right: 10px;">
							<?php echo $tol; ?> Thumbs
						</div>
						<div style="padding-top: 4px; padding-right: 8px; float: left;">
							<img style="cursor: pointer;" src="/theme/images/thumbMinus.png" title="Hated it!" onclick="thumbVote(1, <?php echo $idC; ?>, <?php echo $rowP->postID; ?>);" style="behavior: url(/iepngfix.htc);" />
							<img style="cursor: pointer;" src="/theme/images/thumbPlus.png" title="Loved it!" onclick="thumbVote(2, <?php echo $idC; ?>, <?php echo $rowP->postID; ?>);" style="behavior: url(/iepngfix.htc);" />
						</div>
						<div style="clear: both;"></div>
						<?php } else { ?>
							<div class='forums_thumb_vote'><?php echo $tol; ?> Thumbs</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php if($rowP->tolerance < $toleranceMin) { ?>
				<div class="forums_post_content" id="post<?php echo $rowP->postID; ?>" style="display: none; width: 686px;">
			<?php } else { ?>
				<div class="forums_post_content" style="width: 686px;">
			<?php } ?>
			<!--<div class="forums_post_content" style="width: 686px;">-->
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
	swfobject.embedSWF("/characterBuilder/viewers/crewviewer.swf", "forumsRightViewer<?php echo $k; ?>", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $rowU->sex; ?>_1.swf", "forumsRightViewer<?php echo $k; ?>", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);	
	<?php } ?>
</script>
					<a href="/user/<?php echo $rowU->name; ?>">
					<div class="forums_post_character">
						<div style="cursor: pointer;" onclick="location='/user/<?php echo $rowU->name; ?>';">
							<div id="forumsRightViewer<?php echo $k; ?>">
							
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
				<div class="forums_post_right" style="width: 544px;">
					<?php
						if($rowP->actionID != 0){
							$resultAction = $database->db_query("SELECT message FROM Forum_Actions WHERE actionID = ".$rowP->actionID);
							$rowAction = mysqli_fetch_object($resultAction);
					?>
						<div class="actionsBox">
							<div class="actionsInner">
								<?php echo $rowAction->message; ?>
							</div>
						</div>
					<?php } ?>
					<div class="forums_post" style="width: 524px;">
						<div class="forums_post_content_left">
							<div class="forums_bubble_left"></div>
						</div>
						<div class="forums_post_content_right" style="width: 501px;">
							<div class="forums_post_bubble_top_row">
								<div class="forums_bubble_top_left"></div>
								<div class="forums_bubble_top" style="width: 489px;"></div>
								<div class="forums_bubble_top_right"></div>
								<div style="clear: both;"></div>
							</div>
							<div class="forums_bubble_inner" style="width: 489px;">
								<div class="forums_bubble_inner_top">
									<div style="float: left;"><a href="/user/<?php echo $rowU->name; ?>" class="blue"><?php echo $rowU->name; ?></a> said:</div>
							<div style="float: right;">Posted on <?php echo $prettyprint->prettyDate($rowP->dateAdded, "[M] [D], [Y] at [x] [CZ]"); ?></div>
								</div>
								<div  class="forums_bubble_inner_bot">
									<div class="forums_post_thepost">
										<?php echo stripslashes($rowP->post); ?>
									</div>
								</div>
							</div>
							<div class="forums_post_bubble_bot_row">
								<div class="forums_bubble_bot_left"></div>
								<div class="forums_bubble_bot" style="width: 489px;"></div>
								<div class="forums_bubble_bot_right"></div>
								<div style="clear: both;"></div>
							</div>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div class="forums_post_tools" style="width: 534px;">
						<div class="forums_post_tools_left">
							<?php if($user != $rowU->userID and $session->user) { ?>
							<form name="startTrade<?php echo $idC; ?>" action="/process/startTrade" method="POST" style="margin: 0px; padding: 0px;">
								<a title="Private Message" href="/mail/compose/<?php echo $rowU->userID; ?>"><img src="/theme/images/icon_pm2.png"/></a>
								<img style="cursor: pointer;" src="/theme/images/icon_trade2.png" title="Start Trade" onclick="document.startTrade<?php echo $idC; ?>.submit();" />
								<?php if($rowU->aim != "") { ?>
									<a title="Instant Message" href="aim:goim?screenname=<?php echo $rowU->aim; ?>;message=Hail+from+Podunkton!"><img src="/theme/images/icon_aim2.png" /></a>
								<?php } ?>
								<input type="hidden" name="uname" value="<?php echo $rowU->name; ?>" style="margin: 0px; padding: 0px;" />
							</form>
							<?php } ?>
						</div>
						<div class="forums_post_tools_right">
							<?php if($session->user) { ?>							
							<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $rowT->threadID; ?>/quote/<?php echo $rowP->postID; ?>/<?php echo $page; ?>"><img src="/theme/images/button_quote.png" /></a>
							<?php } ?>
						</div>
						<div style="clear: both;"></div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
	<!--<div style="width: 792px; height: 8px;"></div>-->
	<?php 
		}
		$idC++;
		$k++;
	} 
	?>

<div class="forums_topic_top" style="margin-top: 8px;">
	<div class="forums_topic_top_left">
		<div id="forums_minor_title"><?php echo $rowT->subject; ?></div>
		<?php
			$resultTags = $database->db_query("SELECT t.tagID, t.name FROM Thread_has_Tags as tht JOIN Tags as t ON tht.tagID = t.tagID WHERE tht.threadID=".$rowT->threadID);
			if(mysqli_num_rows($resultTags) > 0){
		?>
			<div class="forums_topic_tags">Tags: 
		<?php 
			while($rowTag = mysqli_fetch_object($resultTags)) {
		?>
				<a class="blue" href="#"><?php echo $rowTag->name; ?></a>
		<?php 	} ?>
			</div>
		<?php } ?>
		
		<?php if($session->user){ ?>
		<div class="forums_topic_reply">
			<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $rowT->threadID; ?>"><img border="0" src="/theme/images/reply_to_topic.png" /></a>
		</div>
		<?php } ?>
	</div>
	<div class="forums_topic_top_right">
		<div class="forums_topic_top_bread">
			<a class="blue" href="/forums"><?php echo $rowC->name; ?></a> - 
			<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>"><?php echo $rowS->name; ?></a> - 
			<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $rowT->threadID; ?>"><?php echo $rowT->subject; ?></a>
		</div>
		<div class="forums_topic_bread">
			Topics <?php echo ($page-1)*RESULTS_PER_PAGE+1; ?> - <?php echo $endPage; ?> of <?php echo $rowCount->count; ?> 
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/1"><?php echo "first"; ?> </a>
			<?php if($page > 1) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $page-1; ?>"><?php echo "<"; ?> </a>
			<?php } ?>
			<?php
				if($numPages > 5){
					if($page > 3){
						for($i=$page-2; $i<=$page; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
						for($i=$page+1; $i<=$page+3; $i++){
							if($i > $numPages) {
								break;
							}
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
					} else {
					
						for($i=1; $i<=3; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
						echo "...";
						for($i=$numPages-1; $i<=$numPages; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
							}
						}
					}
				} else {
					for($i=1; $i<=$numPages; $i++){
						if($i == $page){
			?>
								<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php 		 } else {	?>
								<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?> </a>
			<?php
						}
					}
				}
			?>
			<?php if($page < $numPages) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $page+1; ?>"><?php echo ">"; ?> </a>
			<?php } ?>
			<a class="blue" style="font-weight: bold;" href="/forums/<?php echo $rowS->safeName; ?>/<?php echo $sortBy; ?>/<?php echo $rowT->threadID; ?>/<?php echo $numPages; ?>"><?php echo "last"; ?> </a>
		</div>
		<div class="forums_newToOld" style="padding: 0px;">
			<form action="" method="POST" style="margin: 0px; padding: 0px;">
				<select id="selectForums" class="forums_select_forum_topic" name="selectForum" onchange="location='/forums/'+this.options[this.selectedIndex].value;">
					<option value="0">Select a Forum</option>
					<?php
							$resultSub = $database->db_query("SELECT name, safeName FROM Forum_Subcategory ORDER BY sort");
							while($row = mysqli_fetch_object($resultSub)){
						?>
							<option value="<?php echo $row->safeName; ?>"><?php echo $row->name; ?></option>
						<?php } ?>
				</select>
			</form>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
<!--<div style="width: 792px; height: 8px;"></div>-->
<div id="forums_ad2" style="margin-top: 8px;">
	<img src="/theme/images/forums_ad2.png" />
</div>
