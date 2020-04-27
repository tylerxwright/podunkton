<?php
	global $core;
	global $database;
?>
<div id="page_content_left">
	<div id="audio_menu">
		<div id="audio_menu_left">
			Welcome to Podunkton - AUDIO SECTION
		</div>
		<div id="audio_menu_right">
			<a href="audio/list">VIEW ARTIST LISTINGS</a>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div class="site_box" style="width: 458px; float: left;">
		<div class="site_box_2_head">
			<div class="site_box_2_left"></div>
			<div class="site_box_2_padding"></div>
			<div class="site_box_2_title_audio"></div>
			<div class="site_box_2_stretch_audio"></div>
		</div>
		<div class="site_box_content" style="height: 335px; width: 456px; background-color: #fff;">
			<?php if($session->user){ ?>
			<a href="/store"><img src="/theme/images/audio01.png" /></a>
			<?php } else { ?>
			<img src="/theme/images/audioLoggedOut.png" />
			<?php } ?>
		</div>
	</div>
	<div class="site_box" style="width: 174px; float: left; margin-left: 11px;">
		<div class="site_box_head">
			<img src="/theme/images/site_box/top_audio_head.png" />
		</div>
		<div class="site_box_content" style="height: 335px; background-color: #fff;">
			<div class="site_box_content_top_toons">
				<?php
					$c = 1;
					$result = $database->db_query("SELECT b.safeName, s.songID, s.name as 'sname', s.plays, s.rating, s.numRaters, b.name as 'bname' FROM Songs as s JOIN Albums_has_Songs as ahs ON ahs.songID = s.songID JOIN Albums as a ON a.albumID = ahs.albumID JOIN Bands_has_Albums as bha ON bha.albumID = a.albumID JOIN Bands as b ON b.bandID = bha.bandID ORDER BY s.plays DESC LIMIT 0, 5");
					while($row = mysqli_fetch_object($result)) {
				?>
				<a href="/audio/<?php echo $row->safeName; ?>" onclick="location='/audio/<?php echo $row->safeName; ?>'">
					<div class="top_charts" onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer';">
						<div class="chart_top"><?php echo $c++; ?>. "<?php echo $prettyprint->smallString($row->sname, 18); ?>"</div>
						<div class="chart_left">
							<?php echo $row->bname; ?><br/>
							Plays: <?php echo $row->plays; ?><br/>
							<?php 
								
								if($row->numRaters != 0) {
									$rating = $row->rating/$row->numRaters;
								} else {
									$rating = 0;
								}
								echo $podunkton->stars($rating); 
							?>
						</div>
						<div class="chart_right">
							<img width="40" height="40" src="/theme/images/CDplat.png" />
						</div>
					</div>
				</a>
				<?php } ?>
				
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
	
		<div class="site_box" style="width: 643px; margin-top: 11px;">
			<div class="site_box_head" style="text-align: left;">
				<img src="/theme/images/site_box/head_desc.png" style="padding-left: 8px;" />
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner">
					<div id="top_content">
						<?php
							$result = $database->db_query("SELECT b.name, b.bandID, b.safeName FROM Bands as b ORDER BY RAND() LIMIT 0, 5");
							//$result = $database->db_query("SELECT b.safeName, b.name, b.bandID FROM Bands as b LIMIT 0, 5");
							while($row = mysqli_fetch_object($result)) {
								$result2 = $database->db_query("SELECT a.coverArt FROM Albums as a JOIN Bands_has_Albums as bha ON bha.albumID = a.albumID WHERE bha.bandID = ".$row->bandID." ORDER BY RAND() LIMIT 0, 1");
								$row2 = mysqli_fetch_object($result2);
								if(!$row2) continue;
						?>
						<a href="/audio/<?php echo $row->safeName; ?>" onclick="location='/audio/<?php echo $row->safeName; ?>'">
							<div class="top_artist" onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer';">
								<div class="top_artist_top" style="border: solid 1px #333;"><img src="/content/audio/albumArt/<?php echo $row2->coverArt; ?>" border="0" width="100" height="100" /></div>
								<div class="top_artist_bottom"><?php echo $row->name; ?></div>
							</div>
						</a>
						<?php } ?>
						<div style="clear: both;"></div>
					</div>
				</div>
			</div>
		</div>
</div>
<?php include_once("theme/sidebars/right_audio.tpl.php"); ?>
<div style="clear:both;"></div>