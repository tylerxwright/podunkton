<?php
	global $core;
	global $session;
	global $database;
	
	$resultCategory = $database->db_query("SELECT * FROM Forum_Category ORDER BY sort");
	$numRows = mysqli_num_rows($resultCategory);
?>
<script type="text/javascript">
	
	function checkEnter(event) {
		if(event && event.which == 13) {
			forumSearch();
		} else {
			return false;
		}
	}
	
	function forumSearch() {
		typesearch = document.getElementById('typesearch');
		searchstr = document.getElementById('searchstr');
		
		location='/forums/search/1/'+typesearch.options[typesearch.selectedIndex].value+'/'+searchstr.value;
	}
</script>
<link rel="stylesheet" type="text/css" href="/theme/scripts/forums.css" />
<div id="forums_left">
	<div class="site_box" style="width: 600px;">
		<div class="site_box_head">
			<div class="forums_title">FORUMS SEARCH</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="site_box_content_inner" style="width: 590px;">
				<div id="forums_search_row">
					<table border="0">
						<tr>
							<td id="forums_search_sep">SEARCH:</td>
							<td>
								<select name="type" id="typesearch">
									<option value="ttag">Topics by tag</option>
									<option value="tuser">Topics by user</option>
									<option value="tname">Topics by subject</option>
									<!--<option value="puser">Posts by user</option>-->
									<!--<option value="pname">Posts by content</option>-->
								</select>
							</td>
							<td><input type="text" name="searchstr" id="searchstr" size="30" onkeypress="checkEnter(event);"/></td>
							<td><input type="button" name="submit" value="SEARCH" onclick="forumSearch();"/></td>
						</tr>
					</table>
				</div>
				<?php if($session->user){ ?>
				<div id="forums_search_bottom">
					<!--<a class="blue" href="#">Find my Latest Posts</a> | <a class="blue" href="#">Find my Latest Topics</a>-->
				</div>
				<?php } ?>
			</div>
			<div class="site_box_head" style="border: none;">
				<div class="forums_title">FORUM CATEGORIES</div>
			</div>
			<div class="site_box_content_inner" style="width: 590px;">
				<?php 
					$cc = 0;
					while($rowC = mysqli_fetch_object($resultCategory)){ 
				?>
				<div class="forums_section_bar_<?php echo $rowC->color; ?>">
					<div class="forums_icon"><img src="/content/forums/categoryIcons/<?php echo $rowC->icon; ?>" /></div>
					<div class="forums_section_bar_text"><?php echo $rowC->name; ?></div>
					<div style="clear: both;"></div>
				</div>
				<?php if($cc == $numRows-1){ ?>
					<div class="forums_category_box" style="border-bottom: none;">
				<?php } else { ?>
					<div class="forums_category_box">
				<?php } ?>
					<?php
						$resultSub = $database->db_query("SELECT * FROM Forum_Subcategory WHERE categoryID=".$rowC->categoryID." ORDER BY sort");
						$c = 0;
						while($rowS = mysqli_fetch_object($resultSub)) {
							if($c == 0) {
					?>
					<div class="forums_category_box_row">
							<?php } ?>
						
						<div class="forums_category_box_item">
							<div class="forums_icon_box_<?php echo $rowC->color; ?>"><a href="/forums/<?php echo $rowS->safeName; ?>"><img src="/content/forums/subcategoryIcons/<?php echo $rowS->icon; ?>" /></a></div>
							<div class="forums_item_text">
								<a href="/forums/<?php echo $rowS->safeName; ?>">
									<span class="forums_category_title"><?php echo $rowS->name; ?></span><br/>
									<?php echo $rowS->description; ?>
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
				
				<?php 
						$cc++;
					} 
				?>
			</div>
		</div>
		<!--<div style="width: 235px; height: 8px;"></div>-->
				
		<div id="forums_bottom_tools" style="margin-top: 8px; overflow: hidden;">
			<div id="forums_bottom_left">
				<table border="0">
					<tr><td>Users in Forums</td><td>: 
					<?php 
						$resultForumUsers = $database->db_query("SELECT COUNT(userid) as 'count' FROM Users_online WHERE inForums = 1");
						$rowForumUsers = mysqli_fetch_object($resultForumUsers);
						echo $rowForumUsers->count;
					?>
					</td></tr>
					<tr><td>Most Users Ever in Forums</td><td>: 
					<?php
						$resultMost = $database->db_query("SELECT Most_Users_In_Forums as 'most' FROM Site_Variables");
						$rowMost = mysqli_fetch_object($resultMost);
						echo $rowMost->most;
					?>
					</td></tr>
					<tr>
						<td colspan="2">
							<a class="blue" href="/search/1/allusers">Who's Online?</a> - 
							<?php
								$c = 1;
								$resultUsers = $database->db_query("SELECT u.name FROM Users as u JOIN Users_online as uo ON u.userID = uo.userid ORDER BY RAND() LIMIT 0, 8");
								$numUsers = mysqli_num_rows($resultUsers);
								while($rowUsers = mysqli_fetch_object($resultUsers)) {
							?>
								<a class="blue" href="/user/<?php echo $rowUsers->name; ?>"><?php echo $rowUsers->name; ?></a>
							<?php 
									if($c != $numUsers) {
										echo ", ";
									}
									$c++;
								} 
							?>
						</td>
					</tr>
				</table>
			</div>
			<div id="forums_bottom_right">
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
		<!--<div style="width: 235px; height: 8px;"></div>-->
		<div id="forums_ad" style="margin-top: 7px;">
			<img src="/theme/images/artist_ad.png" />
		</div>
	</div>
</div>
<div id="forums_right">
<?php include_once("theme/sidebars/right_forums.tpl.php"); ?>
</div>
<div style="clear: both;"></div>