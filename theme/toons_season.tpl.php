<?php
	$safeName = $core->args[1];
	$resultPage = $database->db_query("SELECT seasonID FROM Toon_Seasons WHERE safeName = '$safeName'");
	$rowPage = mysqli_fetch_object($resultPage);
	$seasonID = $rowPage->seasonID;
?>
<div id="season_toons_menu">
	<div id="toons_menu_left" style="padding: 0px;">
		<img src="/theme/images/preseason_banner.png" />
	</div>
	
	<div id="toons_menu_right" style="padding-top: 48px;">
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
				if($i == 2){ break;}
			} 
		?>
	</div>
	
	<div style="clear:both;"></div>
	
</div>
<div style="width: 780; height: 8px; line-height: 0px; padding: 0px; margin: 0px;"></div>
	
<div style="float: left; width: 790px;">
<div id="page_content" style="width: 660px;">

	<div id="seasons_list">
		<?php
			$result = $database->db_query("SELECT t.name, t.safeName, t.description, t.icon, t.views, t.releaseDate, t.rating, t.numRaters FROM Toons as t JOIN Seasons_has_Toons as sht ON sht.toonID = t.toonID WHERE sht.seasonID = $seasonID ORDER BY t.episode ASC");
			while($row = mysqli_fetch_object($result)) {
		?>
		<div class="season" onclick="location='/toons/view/<?php echo $row->safeName; ?>'" onmouseover="highlight(this); this.style.cursor = 'pointer';" onmouseout="regular(this); this.style.cursor = 'pointer';">
			<a href="/toons/view/<?php echo $row->safeName; ?>">
				<div class="season_left">
					<div class="season_thumb">
						<img src="/content/toons/images/<?php echo $row->icon; ?>" width="111" height="81" border="0" />
					</div>
					<div class="season_info">
						<table class="season_table_info">
							<tr>
								<td class="season_td_left">Views</td>
								<td class="season_td_right"><?php echo $row->views; ?></td>
							</tr>
							<tr>
								<td class="season_td_left">NG Score</td>
								<td class="season_td_right">4.99/5.00</td>
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
				<div class="season_right">
					<div class="season_right_top">
						<div class="season_title">
							"<?php echo $row->name; ?>"
						</div>
						<div class="season_content">
							<?php echo $row->description; ?>
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


<?php include_once("theme/sidebars/right.tpl.php"); ?>



</div>
<div style="clear:both;"></div>