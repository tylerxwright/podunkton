
<div id="page_content" style="width: 655px;">
	<div id="audio_menu" style="width: 648px">
		<div id="audio_menu_left">
			<div style="float: left;">ARTISTS</div>
			<div class="audio_link">-</div>
			<div class="audio_link">A-Z</div>
			<div style="clear:both;"></div>
		</div>
		<div id="audio_menu_right">
			PODUNKTON MUSIC
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="artist_list_content">
		<div class="artist_row_box">
		<?php 
			$result = $database->db_query("SELECT safeName, bandID, name, picture FROM Bands ORDER BY name ASC");
			while($row = mysqli_fetch_object($result)) {
		?>
		<a href="/audio/<?php echo $row->safeName; ?>" onclick="location='/audio/<?php echo $row->safeName; ?>'">
			<div class="artist_list_box"  onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer'; ">
				<div class="artist_box_top" >
					<div class="artist_baseline"><?php echo $row->name; ?></div>
				</div>
				<div class="artist_box_mid"><img src="/content/audio/bandPicture/<?php echo $row->picture; ?>" border="0" width="113" height="83" /></div>
				<div class="artist_box_bot">
					<div class="artist_line">
						<div class="artist_box_left">FANS:</div>
						<div class="artist_box_right">
						<?php 
							$resultFans = $database->db_query("SELECT COUNT(id) as 'count' FROM Bands_has_Fans WHERE bandID = ".$row->bandID);
							$rowFans = mysqli_fetch_object($resultFans);
							echo $rowFans->count;
						?>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div style="padding-left: 33px; padding-top: 3px;">
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
				</div>
			</div>
		</a>
		<?php } ?>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<?php include_once("theme/sidebars/right_audio.tpl.php"); ?>
<div style="clear:both;"></div>