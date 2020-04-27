<?php
	global $core;
	global $database;
?>

	<div id="toons_menu">
		<div id="toons_menu_left">
			Welcome to Podunkton - GAME SECTION
		</div>
		<div id="toons_menu_right">
			<div class="toons_link">GAMES</div>
			<div class="toons_link">-</div>
			<?php 
				$result = $database->db_query("SELECT name, safeName FROM Games");
				while($row = mysqli_fetch_object($result)){
			?>
			<div class="toons_link"><a href="/games/<?php echo $row->safeName; ?>"><?php echo $row->name; ?></a></div>
			<?php } ?>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
	</div>

<div id="page_content_left">

	<div class="site_box" style="width: 458px; float: left;">
		<div class="site_box_2_head">
			<div class="site_box_2_left"></div>
			<div class="site_box_2_padding"></div>
			<div class="site_box_2_title_games"></div>
			<div class="site_box_2_stretch"></div>
		</div>
		<div class="site_box_content" style="height: 335px; width: 456px; background-color: #fff;">
			<img src="/theme/images/games01.png" />
		</div>
	</div>
	<div class="site_box" style="width: 174px; float: left; margin-left: 11px;">
		<div class="site_box_head">
			<img src="/theme/images/site_box/head_top_games.png" />
		</div>
		<div class="site_box_content" style="height: 335px; background-color: #fff;">
			<div class="site_box_content_top_toons">
				<?php 
					$resultGames = $database->db_query("SELECT name, rating, views, numRaters, icon, safeName FROM Games ORDER BY (rating/numRaters) DESC LIMIT 0, 4");
					while($rowGames = mysqli_fetch_object($resultGames)) {
				?>
				<a href="/games/<?php echo $rowGames->safeName; ?>" onclick="location='/games/<?php echo $rowGames->safeName; ?>'">
					<div class="top_toons" onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer';">
						<div id="featured_thumb">
							<img src="/content/games/images/<?php echo $rowGames->icon; ?>" width="77" height="56" border="0" />
						</div>
						<div id="featured_content" style="padding-right: 0px;">
							<b><?php echo $prettyprint->smallString($rowGames->name, 20); ?></b><br/>
							<span style="color: #707274;">views:</span> <?php echo $rowGames->views; ?><br/>
							<?php 
								if($rowGames->numRaters != 0) {
									$rating = $rowGames->rating/$rowGames->numRaters;
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
	
	<div id="seasons_list" style="width: 643px; margin-top: 8px;">
		<?php 
			$result = $database->db_query("SELECT name, description, icon, safeName, views, numRaters, releaseDate, rating FROM Games ORDER BY releaseDate DESC");
			while($row = mysqli_fetch_object($result)) {
		?>
		<div class="season" onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer';" style="width: 641px;">
			<a href="games/<?php echo $row->safeName; ?>" onclick="location='games/<?php echo $row->safeName; ?>'">
				<div class="season_left">
					<div class="season_thumb">
						<img src="/content/games/images/<?php echo $row->icon; ?>" width="111" height="81" border="0" />
					</div>
					<div class="season_info">
						<table class="season_table_info">
							<tr>
								<td class="season_td_left">Views</td>
								<td class="season_td_right"><?php echo $row->views; ?></td>
							</tr>
							<tr>
								<td class="season_td_left">Release</td>
								<td class="season_td_right"><?php echo $row->releaseDate; ?></td>
							</tr>
							<tr>
								<td class="season_td_rating" colspan="2" align="center">
									<?php 
										if($row->numRaters != 0) {
											$rating = $row->rating/$row->numRaters;
										} else {
											$rating = 0;
										}
										echo $podunkton->stars($rating); 
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="season_right" style="width: 510px;">
					<div class="season_right_top">
						<div class="season_title">
							"<?php echo $row->name; ?>"
						</div>
						<div class="season_content">
							<?php echo $prettyprint->smallString($row->description, 711); ?>
						</div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</a>
		</div>
		<?php } ?>
	</div>
	<div style="clear:both;"></div>
</div>
<?php include_once("theme/sidebars/right_toons.tpl.php"); ?>
<div style="clear:both;"></div>