<?php
	global $core;
	global $database;
?>

	<div id="toons_menu">
		<div id="toons_menu_left">
			Welcome to Podunkton - TOON SECTION
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
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
	</div>


<div id="page_content_left">

	<div class="site_box" style="width: 458px; float: left;">
		<div class="site_box_2_head">
			<div class="site_box_2_left"></div>
			<div class="site_box_2_padding"></div>
			<div class="site_box_2_title_toons"></div>
			<div class="site_box_2_stretch"></div>
		</div>
		<div class="site_box_content" style="height: 335px; width: 456px; background-color: #fff;">
		<img src="/theme/images/toons01.png" />
		</div>
	</div>
	<div class="site_box" style="width: 174px; float: left; margin-left: 11px;">
		<div class="site_box_head">
			<img src="/theme/images/site_box/head_top.png" />
		</div>
		<div class="site_box_content" style="height: 335px; background-color: #fff;">
			<div class="site_box_content_top_toons">
				<?php 
					$resultToons = $database->db_query("SELECT name, rating, views, numRaters, icon, safeName FROM Toons ORDER BY (rating/numRaters) DESC LIMIT 0, 4");
					while($rowToons = mysqli_fetch_object($resultToons)) {
				?>
				<a href="/toons/view/<?php echo $rowToons->safeName; ?>" onclick="location='/toons/view/<?php echo $rowToons->safeName; ?>'">
					<div class="top_toons" onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer';" style="overflow: hidden;">
						<div id="featured_thumb">
							<img src="/content/toons/images/<?php echo $rowToons->icon; ?>" width="77" height="56" border="0" />
						</div>
						<div id="featured_content" style="padding-right: 0px;">
							<b><?php echo $prettyprint->smallString($rowToons->name, 20); ?></b><br/>
							<span style="color: #707274;">views:</span> <?php echo $rowToons->views; ?><br/>
							<?php 
								if($rowToons->numRaters != 0) {
									$rating = $rowToons->rating/$rowToons->numRaters;
								} else {
									$rating = 0;
								}
								echo $podunkton->stars($rating); 
							?>
						</div>
						<div style="clear: both;"></div>
					</div>
				</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
	<div id="seasons_bar">
		<div class="site_box_content_inner" style="padding-left: 0px; padding-right: 0px;">
			<?php
				$resultSeasons = $database->db_query("SELECT picture, hoverPicture, safeName FROM Toon_Seasons ORDER BY seasonOrder ASC");
				while($rowSeasons = mysqli_fetch_object($resultSeasons)) {
			?>
			<a href="/toons/<?php echo $rowSeasons->safeName; ?>" onclick="location='/toons/<?php echo $rowSeasons->safeName; ?>'" onMouseOver="document.<?php echo $rowSeasons->safeName; ?>.src='/content/toons/seasons/<?php echo $rowSeasons->hoverPicture; ?>'; this.style.cursor = 'pointer';" onMouseOut="document.<?php echo $rowSeasons->safeName; ?>.src='/content/toons/seasons/<?php echo $rowSeasons->picture; ?>'; this.style.cursor = 'pointer';">
				<div class="season_bar_button" style="padding-left: 4px;">
					<div class="season_bottom_button"><img src="/content/toons/seasons/<?php echo $rowSeasons->picture; ?>" name="<?php echo $rowSeasons->safeName; ?>"/></div>
				</div>
			</a>
			<?php } ?>
		</div>
		
	</div>
</div>
<?php include_once("theme/sidebars/right_toons.tpl.php"); ?>
<div style="clear:both;"></div>