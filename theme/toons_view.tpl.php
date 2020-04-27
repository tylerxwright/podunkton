<?php
	$safeName = $core->args[2];
	$resultPage = $database->db_query("SELECT * FROM Toons WHERE safeName = '$safeName'");
	$numRows = mysqli_num_rows($resultPage);
	if($numRows > 0){
		$row = mysqli_fetch_object($resultPage);
?>
<script type="text/javascript">
	
	var ajax = new Ajax();
	
	var flashvars = {
		dummy: <?php echo time(); ?>
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent"
	};
	
	function showToon(width, height) {
		
		// Increase Toon views
		ajax.doGet("/process/addToonView/<?php echo $row->toonID; ?>", updateViewNum);
		
		function updateViewNum(str) {
			var viewsLabel = document.getElementById("toonsNumViews");
			viewsLabel.innerHTML++;
		}
		
		boxInner = setOverlay(width, height);
		str = "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='550' height='400' id='logo' align='middle'>" +
			  "<param name='allowScriptAccess' value='sameDomain' />" +
			  "<param name='movie' value='/content/toons/swfs/<?php echo $row->swf; ?>?dummy=<?php echo time(); ?>' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' /><embed src='/content/toons/swfs/<?php echo $row->swf; ?>?dummy=<?php echo time(); ?>' quality='high' bgcolor='#ffffff' width='550' height='400' name='logo' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />" +
			  "</object>";
		boxInner.innerHTML = str;
		
		podunktonPresents = document.getElementById("podunktonPresents");
		podunktonPresents.innerHTML = "<img src='/theme/images/pop_up/podunk_presents.png' />";
		
		headerTitle = document.getElementById("headerTitle");
		headerTitle.innerHTML = "<?php echo $row->name; ?>";
		
		boxAd = document.getElementById("overlayAddBox");
		boxAd.innerHTML = "<div style='border: solid 1px #000; width: 468px; height: 60px;'></div>";
		
		//swfobject.embedSWF("/content/toons/swfs/<?php echo $row->swf; ?>", "boxInner", width, height, "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	}
	
	function setOverlay(width, height) {
		overlayBox = document.getElementById("overlay");
		box = document.getElementById("overlay_message_box");
		box2 = document.getElementById("overlay_box");
		boxInner = document.getElementById("overlay_inner");
		
		box.style.width = width+'px';
		box.style.height = height+'px';
		box.style.marginLeft = (-width/2)+'px';
		box.style.marginTop = (-height/2)+'px';
		
		box2.style.width = (width-2)+'px';
		boxInner.style.width = (width-10)+'px';
		boxInner.style.height = (height-37)+'px';
		
		var mainPage = document.getElementById("main_container");
		
		overlayBox.style.display = "block";
		box.style.display = "block";
		document.body.style.overflow='hidden';
		
		return boxInner;
	}
	
	function popUpWindow(width, height) {
		window.open("/popout_box/<?php echo $row->swf; ?>/<?php echo $row->toonID; ?>/dumb", "<?php echo $row->name; ?>", "status=0, toolbar=0, scrollbars=0, resizable=0, width=600, height=500");
	}
	
	function highlightStar(num) {
		for(i=num; i>0; i--){
			var star = document.getElementById("star"+i);
			star.style.backgroundImage = "url('/theme/images/star_fill.png')";
		}
	}
	
	function unhighlightStar(num) {
		for(i=num; i<=5; i++){
			var star = document.getElementById("star"+i);
			star.style.backgroundImage = "url('/theme/images/star_back.png')";
		}
	}
	
	function rateToon(num) {
		ajax.doGet("/process/rateToon/<?php echo $row->toonID; ?>/"+num, showRating);
	}
	
	function showRating(str) {
		var starDiv = document.getElementById("starDiv");
		var ratingText = document.getElementById("ratingText");
		starDiv.innerHTML = str;
		ratingText.innerHTML = "Rating";
	}
	
	function addComment() {
		var text = document.getElementById("commentText").value;
		ajax.doGet("/process/addToonComment/<?php echo $row->toonID; ?>/"+text, showComment);
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
		ajax.doGet("/process/getToonCommentPage/<?php echo $row->toonID; ?>/"+pageSelect.options[pageSelect.selectedIndex].value, showAllComments);
	}
	
	function showAllComments(str) {
		var commentSection = document.getElementById("commentSection");
		commentSection.innerHTML = str;
	}
	
</script>
<div id="toons_menu">
	<div id="toons_menu_left">
		Welcome to Podunkton - <a href="/toons">TOON SECTION</a>
	</div>
	<div id="toons_menu_right">
		<div class="toons_link">SEASONS</div>
		<div class="toons_link">-</div>
		<?php
			$i = 0;
			$resultSeasons = $database->db_query("SELECT name, safeName FROM Toon_Seasons ORDER BY seasonOrder ASC");
			while($rowSeasons = mysqli_fetch_object($resultSeasons)){
		?>
		<div class="toons_link"><a href="/toons/<?php echo $rowSeasons->safeName; ?>"><?php echo strtoupper($rowSeasons->name); ?></a></div>
		<?php
				$i++;
				if($i == 2){ break; } 
			} 
		?>
		<div class="toons_link"><?php echo strtoupper($row->name); ?></div>
		<div style="clear:both;"></div>
	</div>
	<div style="clear:both;"></div>
</div>

<div style="width: 780; padding-top: 10px; overflow: hidden;">

<div id="page_content_left" style="overflow: hidden; padding-top: 0px;">

	<div id="toon_left" style="overflow: none;">
		<div class="site_box" style="width: 245px;">
			<div class="site_box_head">
				<div class="toon_title"><?php echo strtoupper($row->name); ?></div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 235px;">
					<div id="toon_pic">
						<img src="/content/toons/images/<?php echo $row->icon; ?>" border="0" />
					</div>
					<div id="toon_info">
						<table class="toon_table_info">
							<tr>
								<td class="toon_td_left">Release Date</td>
								<td class="toon_td_right"><?php echo $prettyprint->prettydate($row->releaseDate, "[m] [d], [Y]"); ?></td>
							</tr>
							<tr>
								<td class="toon_td_left">File Size</td>
								<td class="toon_td_right"><?php echo $row->fileSize; ?> MB</td>
							</tr>
							<tr>
								<td class="toon_td_left">Views</td>
								<td class="toon_td_right" id="toonsNumViews"><?php echo $row->views; ?></td>
							</tr>
							<tr>
								<?php
									if($session->user) {
										$resultRaters = $database->db_query("SELECT COUNT(id) as 'count' FROM Toons_has_Users WHERE toonID=".$row->toonID." AND userID=".$session->user);
										$rowRaters = mysqli_fetch_object($resultRaters);
										if($rowRaters->count == 0) {
								?>
									<td class="toon_td_left" id="ratingText">Rate me</td>
								<?php 	} else { ?>
									<td class="toon_td_left" id="ratingText">Rating</td>
								<?php 
										}
									} else { ?>
									<td class="toon_td_left" id="ratingText">Rating</td>
								<?php } ?>
								
								<td class="toon_td_right">
									<div style="padding-left: 44px;">
										<div class='stars' style='width: 80px;' id="starDiv">
											<?php
												if($session->user) {
													if($rowRaters->count != 0) {
														if($row->numRaters != 0) {
															$rating = $row->rating/$row->numRaters;
														} else {
															$rating = 0;
														}
														echo $podunkton->stars($rating); 
													} else {
											?>
													<?php for($i=1; $i<=5; $i++){ ?>
													<div class='star_back' style="cursor: pointer;" id="star<?php echo $i; ?>" onmouseover="highlightStar(<?php echo $i; ?>);" onmouseout="unhighlightStar(<?php echo $i; ?>);" onclick="rateToon(<?php echo $i; ?>);"></div>
													<?php } ?>
													<div style='clear: both;'></div>
											<?php 
													}
												} else {
													if($row->numRaters != 0) {
														$rating = $row->rating/$row->numRaters;
													} else {
														$rating = 0;
													}
													echo $podunkton->stars($rating); 
												}
											?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="toon_td_left">Newgrounds</td>
								<td class="toon_td_right" id="gamesNumViews"><a class="blue" href="<?php echo $row->ngLink; ?>">Check it out</a></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php /* NOT READY YET
		<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
		<div class="site_box" style="width: 245px;">
			<div class="site_box_head">
				<img src="/theme/images/site_box/head_newgrounds.png" />
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 235px;">
					<div id="newgrounds_top">
						<dl>
							<dt>
								<div id="dt_left">NEWGROUNDS SCORE</div>
								<div id="dt_right">4.54/5.00</div>
								<div style="clear: both;"></div>
							</dt>
							<dd id="vote"><a href="#">GO TO NEWGROUNDS &amp; VOTE NOW!</a></dd>
							<dt>AWARDS:</dt>
							<dd>Review Crew Pick - 02/18/2004</dd>
							<dd>Review Crew Pick - 02/18/2004</dd>
							<dd>Review Crew Pick - 02/18/2004</dd>
						</dl>
					</div>
					<div id="toon_info">
						<table class="toon_table_info">
							<tr>
								<td class="toon_td_left">SCORE RANK</td>
								<td class="toon_td_right">#763,234</td>
							</tr>
							<tr>
								<td class="toon_td_left">POP. RANK</td>
								<td class="toon_td_right">#22</td>
							</tr>
							<tr>
								<td class="toon_td_left">VOTES</td>
								<td class="toon_td_right">9,999,999</td>
							</tr>
							<tr>
								<td class="toon_td_left">VIEWS</td>
								<td class="toon_td_right">873,434</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		*/ ?>
		<?php
			$resultCast = $database->db_query("SELECT u.name, u.userID, u.sex FROM Users as u JOIN Toons_has_Cast as thc ON u.userID = thc.userID WHERE thc.toonID = ".$row->toonID);
			if(mysqli_num_rows($resultCast) > 0) {
		?>
		<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
		<div class="site_box" style="width: 245px;">
			<div class="site_box_head">
				<img src="/theme/images/site_box/head_cast.png" />
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 235px; padding: 10px 0px 10px 10px;">
					<?php
						$c = 0;
						while($rowCast = mysqli_fetch_object($resultCast)) {
					?>
					<div class="cast_box">
						<div class="cast_avatar">
							<?php echo $podunkton->imageAvatar($rowCast->userID, $rowCast->sex, 33, $c, "castAvatar"); ?>
						</div>
						<div class="cast_name">
							<a class="cast_name" href="/user/<?php echo $rowCast->name; ?>"><?php echo $rowCast->name; ?></a>
						</div>
					</div>
					<?php 
							$c++;
							if($c%2==0) {
					?>
						<div style="clear: both; height: 5px; line-height: 1px;"></div>
					<?php
							}
						} 
					?>
					<div style="clear: both;"></div>
					<div id="cast_more">
						<a class="cast_name" href="#">MORE...</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php
			$resultTrivia = $database->db_query("SELECT trivia FROM Toons_Trivia WHERE toonID = ".$row->toonID." ORDER BY triviaOrder ASC LIMIT 0, 3");
			if(mysqli_num_rows($resultTrivia) > 0) {
		?>
		<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
		<div class="site_box" style="width: 245px;">
			<div class="site_box_head">
				<img src="/theme/images/site_box/head_trivia.png" />
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 235px; padding: 10px 0px 10px 10px;">
					<ul id="trivia">
						<?php
							$c = 1;
							while($rowTrivia = mysqli_fetch_object($resultTrivia)) {
						?>
						<li class="trivia"><?php echo $c; ?>. <?php echo $prettyprint->smallString($rowTrivia->trivia, 117); ?></li>
						<?php 
								$c++;
							} 
						?>
					</ul>
					<div id="cast_more">
						<a class="cast_name" href="/toons/view/<?php echo $safeName; ?>/trivia">MORE...</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div id="toon_right" style="overflow: hidden;">
		<div id="watch_block">
			<div id="watch_left">
				<?php
					$resultMPAA = $database->db_query("SELECT * FROM MPAA_Ratings WHERE mpaaID = ".$row->mpaaRating);
					$rowMPAA = mysqli_fetch_object($resultMPAA);
				?>
				<div id="watch_icon">
					<img src="/content/mpaa/<?php echo $rowMPAA->icon; ?>" />
				</div>
				<div id="watch_rating_text">
					<ul id="watch_rating_text">
						<li><?php echo $rowMPAA->name; ?></li>
						<li><?php echo $rowMPAA->line1; ?></li>
						<li><?php echo $rowMPAA->line2; ?></li>
					</ul>
				</div>
			</div>
			<div id="watch_right">
				<a id="watch_toon" href="#" onclick="showToon(600, 450);return false;">WATCH THIS TOON!</a><br/>
				<a class="watch_toon2" href="#" onclick="popUpWindow(600, 450);return false;">Pop-Up</a>
				<!--<a class="watch_toon2" href="#">Add to Favorites</a>-->
			</div>
			<div style="clear: both;"></div>
		</div>
		<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
		<div class="site_box" style="width: 385px;">
			<div class="site_box_head" style="text-align: left;">
				<img src="/theme/images/site_box/head_desc.png" style="padding-left: 8px;" />
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div id="desc_content">
					<?php echo $row->description; ?>
				</div>
			</div>
		</div>
		<?php if($session->user) { ?>
		<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
		<div style="width: 385px;">
			<span style="font-size: 8pt;">Add a comment</span>
			<textarea id="commentText" style="width: 383px; height: 70px;"></textarea>
			<div style="width: 100%; text-align: right;"><input type="button" value="Post" onclick="addComment()"/></div>
		</div>
		<?php } ?>
		<div style="width: 182px; height: 8px; line-height: 1px; font-size: 1px;"></div>
		<div class="site_box" style="width: 385px;">
		<div class="site_box_head">
			<div class="user_title">COMMENTS</div>
		</div>
		<?php
			$resultComments = $database->db_query("SELECT tc.comment, tc.dateSubmitted, u.name, u.userID, u.sex FROM Users as u JOIN Toons_Comments as tc ON tc.userID = u.userID WHERE tc.toonID = ".$row->toonID." ORDER BY tc.dateSubmitted DESC LIMIT 0, 8");
		?>
		<div class="site_box_content" style="background-color: #fff;">			
			<div class="user_badges_small" style="background-color: #eee; border-bottom: solid 1px #828282; ">
				<div class="user_badges_left">Displaying <b><?php echo COMMENTS_PER_PAGE; ?></b> comments out of <b>
				<?php
					$resultTotal = $database->db_query("SELECT COUNT(commentID) as 'count' FROM Toons_Comments WHERE toonID = ".$row->toonID);
					$rowTotal = mysqli_fetch_object($resultTotal);
					echo $rowTotal->count;
				?></b> total
				</div>
				<div class="user_badges_right">
				</div>
				<div style="clear: both;"></div>
			</div>
			<div class="site_box_content_inner" id="commentSection" style="width: 375px;">
				<?php
					$i = 0; 
					while($rowComments = mysqli_fetch_object($resultComments)) { 
				?>
				<div class="user_comment_left">
					<div class="user_comment_icon">
						<?php echo $podunkton->imageAvatar($rowComments->userID, $rowComments->sex, 35, $i, "toonCommentAvatar"); ?>
					</div>
				</div>
				<div class="user_comment_right">
					<div class="user_comment_top"><a class="blue" href="/user/<?php echo $rowComments->name; ?>"><?php echo $rowComments->name; ?></a> said<br/>at <?php echo $prettyprint->prettydate($rowComments->dateSubmitted, "[x][cz] on [m] [d], [Y]"); ?></div>
					<div class="user_comment_bot">
						<?php echo $rowComments->comment; ?>
					</div>
				</div>
				<div style="clear: both;"></div>
				<?php
						$i++; 
					} 
				?>
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
		<div style="clear: both;"></div>
	</div>
	</div>
	<div style="clear: both;"></div>
</div>
<?php include_once("theme/sidebars/right.tpl.php"); ?>
<div style="clear:both;"></div>

</div>
<?php 
	} else {
		include_once("theme/errordocs/404.tpl.php");
	}
?>