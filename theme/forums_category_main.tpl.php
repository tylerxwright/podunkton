<?php
	global $core;
	global $session;
	global $database;
	
	$resultS = $database->db_query("SELECT * FROM Forum_Subcategory WHERE safeName='".$core->args[1]."'");
	$rowS = mysqli_fetch_object($resultS);
	
	$resultC = $database->db_query("SELECT * FROM Forum_Category WHERE categoryID=".$rowS->categoryID);
	$rowC = mysqli_fetch_object($resultC);
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/forums.css" />
<div>
	<div id="forums_main_top">
		<div id="forums_main_top_row" style="overflow: hidden;">
			<div class="forums_icon_box_<?php echo $rowC->color; ?>"><img src="/content/forums/subcategoryIcons/<?php echo $rowS->icon; ?>" /></div>
			<div id="forums_minor_title_area">
				<div id="forums_minor_title"><?php echo $rowS->name; ?></div>
				<div id="forums_list_top_bread">
					<a class="blue" href="/forums"><?php echo $rowC->name; ?></a> - 
					<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>"><?php echo $rowS->name; ?></a> - 
					<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/list/popular/1">POPULAR LISTINGS</a>
				</div>
			</div>
			<div style="float: right; padding-top: 15px;">
				<form action="" method="POST">
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
			<div style="clear: both;"></div>
		</div>
	</div>
</div>
<!--<div style="height: 8px; width: 792px;"></div>-->
<div id="forums_left_list" style="margin-top: 4px;">

	<div class="site_box" style="width: 634px;">
		<div class="site_box_head">
			<div class="forums_title">CIVIC CENTER THREADS</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="site_box_content_inner" style="width: 624px; overflow: hidden;">
				<div class="forums_section_bar_<?php echo $rowC->color; ?>">
					<div class="forums_icon"><img src="/content/forums/categoryIcons/<?php echo $rowC->icon; ?>" /></div>
					<div class="forums_section_bar_text"><?php echo $rowC->name; ?></div>
					<div style="clear: both;"></div>
				</div>
				<div class="forums_category_box" style="border-bottom: none;">
					<?php
						$resultSub = $database->db_query("SELECT * FROM Forum_Subcategory WHERE categoryID=".$rowC->categoryID." ORDER BY sort");
						$c = 0;
						while($rowS2 = mysqli_fetch_object($resultSub)) {
							if($c == 0) {
					?>
					<div class="forums_category_box_row">
					<?php } ?>
						<div class="forums_category_box_item">
							<div class="forums_icon_box_<?php echo $rowC->color; ?>"><a href="/forums/<?php echo $rowS2->safeName; ?>"><img src="/content/forums/subcategoryIcons/<?php echo $rowS2->icon; ?>" /></a></div>
							<div class="forums_item_text">
								<a href="/forums/<?php echo $rowS2->safeName; ?>">
									<span class="forums_category_title"><?php echo $rowS2->name; ?></span><br/>
									<?php echo $rowS2->description; ?>
								</a>
							</div>
							<div style="clear: both;"></div>
						</div>
					<?php 
						if($c == 1) {
							$c = 0;
							echo "</div>";
						} else {
							$c++;
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<!--<div style="height: 4px; width: 634px;"></div>-->
	<?php 
		if($rowS->adminOnly == 1) {
			if($session->admin == 1){ 
	?>
		<div style="height: 43px; margin-top: 4px;"><a href="/forums/<?php echo $rowS->safeName; ?>/newtopic"><img src="/theme/images/button_newTopic.png" style="behavior: url(/iepngfix.htc);" /></a></div>
	<?php } else { ?>
		<div style="width: 100%; height: 8px; line-height: 8px; font-size: 1px;"></div>			
	<?php
			}
		 } else { 
		 if($session->user){
	?>
		<div style="height: 43px; margin-top: 4px;"><a href="/forums/<?php echo $rowS->safeName; ?>/newtopic"><img src="/theme/images/button_newTopic.png" style="behavior: url(/iepngfix.htc);" /></a></div>
	<?php } else { ?>
		<div style="width: 100%; height: 8px; line-height: 8px; font-size: 1px;"></div>	
	<?php }} ?>
	<div class="site_box" style="width: 634px;">
		<div class="site_box_head">
			<div class="forums_title">POPULAR THREADS</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="forums_list_main_top">
				<div class="forums_list_mleft1">TOPIC</div>
				<div class="forums_list_mleft2">REPLIES</div>
				<div class="forums_list_mleft3">AUTHOR</div>
				<div class="forums_list_mleft4" style="text-align: center;">LAST ADDED</div>
				<div style="clear: both;"></div>
			</div>
			<div class="site_box_content_inner" style="width: 624px; padding: 8px 0px 0px 5px;">
				
				<?php
					$resultPopular = $database->db_query("SELECT name, threadID, subject, author, dateAdded FROM Forum_Thread JOIN Users ON userID = author WHERE subcategoryID=".$rowS->subcategoryID." ORDER BY tolerance DESC LIMIT ".RESULTS_PER_SUBCATEGORY);
					while($rowPopular = mysqli_fetch_object($resultPopular)){
						$resultCount = $database->db_query("SELECT count(author) as 'count' FROM Forum_Post WHERE threadID=".$rowPopular->threadID);
						$postCount = mysqli_fetch_object($resultCount);
				?>
				
				<div class="forums_list_main_row">
					<div class="forums_list_mleft1">
						<div class="forums_icon2"></div>
						<div class="forums_list_main_item">
							<a href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>"><?php echo substr($rowPopular->subject, 0, 35); ?></a><br/>
							[
							<?php 
								$numPages = ceil($postCount->count/RESULTS_PER_PAGE);
								if($numPages > 5) {
									for($i=1; $i<=3; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	}
									echo "...";
									for($i=$numPages-1; $i<=$numPages; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	}
								} else {
									for($i=1; $i<=$numPages; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	
									}
								}
							?>
							]
						</div>
					</div>
					<div class="forums_list_mleft2"><?php echo $postCount->count; ?></div>
					<div class="forums_list_mleft3"><?php echo $rowPopular->name; ?></div>
					<div class="forums_list_mleft4" style="text-align: right;">
					<?php 
						$lastResult = $database->db_query("SELECT u.name, p.dateAdded FROM Forum_Post as p JOIN Users as u ON p.author = u.userID WHERE threadID=".$rowPopular->threadID." ORDER BY dateAdded DESC");
						$lastRow = mysqli_fetch_object($lastResult);
					?>
						<?php echo $lastRow->dateAdded; ?><br/>
						<div style="width: 100%; text-align: center;"><a class="blue" href="/user/<?php echo $lastRow->name; ?>"><?php echo $lastRow->name; ?></a></div>
					</div>
					<div style="clear: both;"></div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="forums_list_bread">
		<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/list/popular/1">see more</a>
	</div>
	<!--<div style="height: 8px; width: 634px;"></div>-->
	<div class="site_box" style="width: 634px; margin-top: 8px;">
		<div class="site_box_head">
			<div class="forums_title">RECENT THREADS</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="forums_list_main_top">
				<div class="forums_list_mleft1">TOPIC</div>
				<div class="forums_list_mleft2">REPLIES</div>
				<div class="forums_list_mleft3">AUTHOR</div>
				<div class="forums_list_mleft4" style="text-align: center;">TOPIC</div>
				<div style="clear: both;"></div>
			</div>
			<div class="site_box_content_inner" style="width: 624px; padding: 8px 0px 0px 5px;">
				
				<?php
					$resultPopular = $database->db_query("SELECT name, threadID, subject, author, dateAdded FROM Forum_Thread JOIN Users ON userID = author WHERE subcategoryID=".$rowS->subcategoryID." ORDER BY dateAdded DESC LIMIT ".RESULTS_PER_SUBCATEGORY);
					while($rowPopular = mysqli_fetch_object($resultPopular)){
						$resultCount = $database->db_query("SELECT count(author) as 'count' FROM Forum_Post WHERE threadID=".$rowPopular->threadID);
						$postCount = mysqli_fetch_object($resultCount);
				?>
				
				<div class="forums_list_main_row">
					<div class="forums_list_mleft1">
						<div class="forums_icon2"></div>
						<div class="forums_list_main_item">
							<a href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>"><?php echo substr($rowPopular->subject, 0, 35); ?></a><br/>
							[
							<?php 
								$numPages = ceil($postCount->count/RESULTS_PER_PAGE);
								if($numPages > 5) {
									for($i=1; $i<=3; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	}
									echo "...";
									for($i=$numPages-1; $i<=$numPages; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	}
								} else {
									for($i=1; $i<=$numPages; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	
									}
								}
							?>
							]
						</div>
					</div>
					<div class="forums_list_mleft2"><?php echo $postCount->count; ?></div>
					<div class="forums_list_mleft3"><?php echo $rowPopular->name; ?></div>
					<div class="forums_list_mleft4" style="text-align: right;">
						<?php 
							$lastResult = $database->db_query("SELECT u.name, p.dateAdded FROM Forum_Post as p JOIN Users as u ON p.author = u.userID WHERE threadID=".$rowPopular->threadID." ORDER BY dateAdded DESC LIMIT 1");
							$lastRow = mysqli_fetch_object($lastResult);
						?>
						<?php echo $lastRow->dateAdded; ?><br/>
						<div style="width: 100%; text-align: center;"><a class="blue" href="/user/<?php echo $lastRow->name; ?>"><?php echo $lastRow->name; ?></a></div>
					</div>
					<div style="clear: both;"></div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="forums_list_bread">
		<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>/list/new/1">see more</a>
	</div>
</div>	
<div id="forums_right_list">
	<div id="forums_tower_ad" style="margin-top: 4px;">
		<div><img src="/theme/images/skyscraper.gif" /></div>
	</div>
</div>
<div style="clear: both;"></div>
<!--<div style="height: 8px; width: 792px;"></div>-->
<div id="forums_list_bottom" style="margin-top: 8px;">
	<div id="forums_list_bottom_left">
		<div class="forums_thinger">
			<div class="forums_icon2"></div>
			<div class="forums_b_text">New Posts</div>
			<div style="clear: both;"></div>
		</div>
		<div class="forums_thinger">
			<div class="forums_icon2"></div>
			<div class="forums_b_text">New Posts</div>
			<div style="clear: both;"></div>
		</div>
		<div class="forums_thinger">
			<div class="forums_icon2"></div>
			<div class="forums_b_text">New Posts</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	<div id="forums_list_bottom_mid">
		<div class="forums_thinger">
			<div class="forums_icon2"></div>
			<div class="forums_b_text">New Posts</div>
			<div style="clear: both;"></div>
		</div>
		<div class="forums_thinger">
			<div class="forums_icon2"></div>
			<div class="forums_b_text">New Posts</div>
			<div style="clear: both;"></div>
		</div>
		<div class="forums_thinger">
			<div class="forums_icon2"></div>
			<div class="forums_b_text">New Posts</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	<div id="forums_list_bottom_right">
		<div id="forums_list_b_forum">
			<form action="" method="POST" style="margin:0px; padding: 0px;">
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
	<div style="line-height: 1px; margin: 0px; padding: 0px;"></div> 
</div>
<?php ?>