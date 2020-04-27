<?php
	$result = $database->db_query("SELECT b.*, g.name as 'gname', rl.name as 'rname' FROM Bands as b JOIN Genres as g ON b.genre = g.genreID JOIN Record_Labels as rl ON b.label = rl.labelID WHERE safeName = '".$core->args[1]."'");
	$row = mysqli_fetch_object($result);
	
	if($session->user) {
		$user = $session->user;
	} else {
		$user = 0;
	}
	
	// Insert profile views
	$result = $database->db_query("UPDATE Bands SET profileViews = profileViews + 1 WHERE bandID = ".$row->bandID);
?>

<script type="text/javascript">
	var flashvars = {
		session: <?php echo $user; ?>,
		bandID:	"<?php echo $row->bandID; ?>"
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#CDDAF9"
	};
	
	swfobject.embedSWF("/content/audio/player/AudioPlayer.swf", "audioPlayer", "529", "420", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
</script>
<div id="page_content_full">
	<div id="artist_view_left">
		<div class="site_box" style="width: 235px;">
			<div class="site_box_head">
				<div class="audio_title"><?php echo $row->name; ?></div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">				
				<div class="box_inner" style="width: 235px;">
					<div class="box_inner_content" style="width: 217px;">
						<div id="genre"><?php echo $row->gname; ?></div>
						<div id="artist_pic"><img src="/content/audio/bandPicture/<?php echo $row->picture; ?>" border="0" /></div>
						<div id="artist_content">
							<div class="artist_line">
								<div class="artist_box_left">Profile Views:</div>
								<div class="artist_box_right"><?php echo $row->profileViews; ?></div>
								<div style="clear:both;"></div>
							</div>
							<div class="artist_line">
								<div class="artist_box_left" style="width: 50%;">Number of Fans:</div>
								<div class="artist_box_right" style="width: 50%;">
								<?php 
									$resultFans = $database->db_query("SELECT COUNT(id) as 'count' FROM Bands_has_Fans WHERE bandID = ".$row->bandID);
									$rowFans = mysqli_fetch_object($resultFans);
									echo $rowFans->count;
								?>
								</div>
								<div style="clear:both;"></div>
							</div>
							<div class="artist_line">
								<div class="artist_box_left" style="width: 137px;">RATING:</div>
								<div class="artist_box_right" style="width: auto">
									<?php
										$count = 0;
										$avgStars = 0;
										$resultStars = $database->db_query("SELECT s.rating, s.numRaters FROM Songs as s JOIN Albums_has_Songs as ahs ON s.songID = ahs.songID JOIN Albums as a ON a.albumID = ahs.albumID JOIN Bands_has_Albums as bha ON bha.albumID = a.albumID WHERE bha.bandID = ".$row->bandID);
										while($rowStars = mysqli_fetch_object($resultStars)) {
											if($rowStars->numRaters != 0) {
												$avgStars += $rowStars->rating/$rowStars->numRaters;
											} else {
												$avgStars += 0;
											}
											$count++;
										}
										
										if($count != 0) {
											$stars = $avgStars/$count;
										} else {
											$stars = 0;
										}
										
										echo $podunkton->stars($stars);
									?>
								</div>
								<div style="clear:both;"></div>
							</div>
							<?php/* if($session->user) { ?>
							<div class="artist_line">
								<div class="artist_box_left" style="width: 153px; padding-top: 3px; line-height: 20px;">
									Become a fan of ours!
								</div>
								<div class="artist_box_right" style="width: auto; padding-top: 3px;">
									<img src="/theme/images/button_fanme" />
								</div>
								<div style="clear:both;"></div>
							</div>
							<?php } */ ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--<div style="width: 182px; height: 8px;"></div>-->
		<div class="site_box" style="width: 235px; margin-top: 8px;">
			<div class="site_box_head">
				<div class="audio_title">GENERAL INFO</div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">				
				<div class="box_inner" style="width: 235px;">
					<div class="box_inner_content" style="width: 217px;">
						<span style="font-weight: bold; font-size: 7pt;">HOMEPAGE</span><br/>
						<a style="font-size: 7pt;" href="<?php echo $row->homepage; ?>"><?php echo $row->homepage; ?></a>
						<div id="artist_members">
							BAND MEMBERS<br/>
							<?php
								$x = 0;
								$resultMembers = $database->db_query("SELECT u.name, u.userID, u.sex, bhm.id FROM Users as u JOIN Bands_has_Members as bhm ON u.userID = bhm.userID WHERE bhm.bandID = ".$row->bandID." ORDER BY u.name");
								while($rowMembers = mysqli_fetch_object($resultMembers)) {
							?>
							<div class="artist_line" style="padding-top: 5px;">
								<div class="artist_box_left" style="width: 60%;">
									<div class="artist_avatar">
										<?php echo $podunkton->imageAvatar($rowMembers->userID, $rowMembers->sex, 33, $x, "memberAvatar"); ?>
									</div>
									<div class="artist_name">
										<a class="artist_name" href="/user/<?php echo $rowMembers->name; ?>"><?php echo $rowMembers->name; ?></a>
									</div>
									<div style="clear:both;"></div>
								</div>
								<div class="artist_box_right" style="width: 40%;">
								<?php
									$c = 0;
									$resultInstruments = $database->db_query("SELECT i.name FROM Instruments as i JOIN Members_has_Instruments as mhi ON i.instrumentID = mhi.instrumentID WHERE mhi.memberID = ".$rowMembers->id." ORDER BY i.name ASC");
									while($rowInstruments = mysqli_fetch_object($resultInstruments)){
										if($c > 0) {
											echo ", ".$rowInstruments->name;
										} else {
											echo $rowInstruments->name;
										}
										$c++;
									}
								?>
								</div>
								<div style="clear:both;"></div>
							</div>
							<?php
									$x++; 
								} 
							?>
							<div class="artist_line" style="padding-top: 8px;">
								<div class="artist_box_left">RECORD LABEL</div>
								<div class="artist_box_right"><?php echo $row->rname; ?></div>
								<div style="clear:both;"></div>
							</div>
						</div>
						<div id="forum_discussion">
							<!--<a href="/forums/music_discussion/oldest/<?php echo $row->thread; ?>"><img src="/theme/images/button_discussion.png" /></a>-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--This will kill IE6, use a margin--><div style="width: 182px; height: 8px;"></div>
	</div>
	<div id="artist_view_right">
		<div id="player">
			<div id="player_container">
				<div id="audioPlayer">
				
				</div>
			</div>
		</div>
		<!--<div style="width: 182px; height: 8px;"></div>-->
		<div class="site_box" style="width: 545px; margin-top: 8px;">
			<div class="site_box_head" style="text-align: left;">
				<img src="/theme/images/site_box/head_desc.png" style="padding-left: 8px;" />
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div id="bio_content">
					<?php echo $row->biography; ?>
				</div>
				
			</div>
		</div>
		<!--<div style="width: 182px; height: 8px;"></div>-->
		<div id="artist_ad" style="margin-top: 8px;">
			<img src="/theme/images/artist_ad.png" />
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>