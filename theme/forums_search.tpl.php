<?php
	global $core;
	global $session;
	global $database;
	
	$type = $core->args[3];
	$searchstr = $core->args[4];
	
	if(substr($type, 0, 1) == "t") {
		$msgtype = "topic";
	} elseif(substr($type, 0, 1) == "p") {
		$msgtype = "post";
	} else {
		// Error
	}
	
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
<div id="forums_left_list">
	<div class="site_box" style="width: 635px; margin-top: 8px;">
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
					<a class="blue" href="#">Find my Latest Posts</a> | <a class="blue" href="#">Find my Latest Topics</a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div id="forums_list_top">
		<div id="forums_list_tool_row">
			<div id="forums_list_tool_left">
				<div id="forums_minor_title">Search results for "<?php echo $searchstr; ?>"</div>
				<div id="forums_list_top_bread">
					<a class="blue" href="/forums">Go back to the forums</a>
				</div>
			</div>
			<div id="forums_list_tool_right">
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
		<div class="forums_list_bread">
			<?php 
			switch($type) {
				case "ttag":
					$resultPC = $database->db_query("SELECT DISTINCT COUNT(ft.threadID) as 'count' FROM Forum_Thread as ft JOIN Thread_has_Tags as tht ON ft.threadID = tht.threadID JOIN Tags as t ON tht.tagID = t.tagID WHERE t.name LIKE '%$searchstr%'");
					break;
				case "tuser":
					$resultPC = $database->db_query("SELECT DISTINCT COUNT(ft.threadID) as 'count' FROM Forum_Thread as ft JOIN Users as u ON ft.author = u.userID WHERE u.name LIKE '%$searchstr%'");
					break;
				case "tname":
					$resultPC = $database->db_query("SELECT DISTINCT COUNT(ft.threadID) as 'count' FROM Forum_Thread as ft WHERE ft.subject LIKE '%$searchstr%'");
					break;
				case "puser":
					$resultPC = $database->db_query("SELECT DISTINCT COUNT(ft.threadID) as 'count' FROM Forum_Post as fp JOIN Forum_Thread as ft ON fp.threadID = ft.threadID JOIN Users as u ON fp.author = u.userID WHERE u.name LIKE '%$searchstr%'");
					break;
				case "pname":
					$resultPC = $database->db_query("SELECT DISTINCT COUNT(ft.threadID) as 'count' FROM Forum_Post as fp JOIN Forum_Thread as ft ON fp.threadID = ft.threadID WHERE fp.post LIKE '%$searchstr%'");
					break;
			}
 
			$rowPCount = mysqli_fetch_object($resultPC);
			
		if($rowPCount->count > 0) {
			
			$numTPages = ceil($rowPCount->count/RESULTS_PER_SUBCATEGORY_LIST);
			
			if($core->args[2] == ""){
				$page = 1;
			} else {
				$page = $core->args[2];
			}
			
			if(($page)*RESULTS_PER_SUBCATEGORY_LIST > $rowPCount->count) {
				$endPage = $rowPCount->count;
			} else {
				$endPage = ($page)*RESULTS_PER_SUBCATEGORY_LIST;
			}
			?>
			Topics <?php echo ($page-1)*RESULTS_PER_SUBCATEGORY_LIST+1; ?> - <?php echo $endPage; ?> of <?php echo $rowPCount->count; ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/1/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo "first"; ?> </a>
			<?php if($page > 1) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $page-1; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo "<"; ?> </a>
			<?php } ?>
			<?php
				if($numTPages > 5){
					if($page > 3){
						for($i=$page-2; $i<=$page; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
						for($i=$page+1; $i<=$page+3; $i++){
							if($i > $numPages) {
								break;
							}
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
					} else {
					
						for($i=1; $i<=3; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
						echo "...";
						for($i=$numTPages-1; $i<=$numTPages; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
					}
				} else {
					for($i=1; $i<=$numTPages; $i++){
						if($i == $page){
			?>
								<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
								<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
						}
					}
				}
			?>
			<?php if($page < $numTPages) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $page+1; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo ">"; ?> </a>
			<?php } ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $numTPages; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo "last"; ?> </a>
		
		</div>
		<div class="site_box" style="width: 634px;">
			<div class="site_box_head">
				<div class="forums_title">THREADS</div>
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
					$limit = (($page-1)*RESULTS_PER_SUBCATEGORY_LIST+1)-1 . ", " . RESULTS_PER_SUBCATEGORY_LIST;
					//$resultPopular = $database->db_query("SELECT fs.safeName, u.name, ft.threadID, ft.subject, ft.author, ft.dateAdded FROM Forum_Thread as ft JOIN Users as u ON u.userID = ft.author JOIN Thread_has_Tags as tht ON ft.threadID = tht.threadID JOIN Tags as t ON tht.tagID = t.tagID JOIN Forum_Subcategory as fs ON ft.subcategoryID = fs.subcategoryID WHERE t.name='$tag' ORDER BY tolerance DESC LIMIT ".$limit);
					
					switch($type){
						case "ttag":
							$resultPopular = $database->db_query("SELECT DISTINCT fs.safeName, u.name, ft.threadID, ft.subject, ft.author, ft.dateAdded FROM Forum_Thread as ft JOIN Users as u ON u.userID = ft.author JOIN Thread_has_Tags as tht ON ft.threadID = tht.threadID JOIN Tags as t ON tht.tagID = t.tagID JOIN Forum_Subcategory as fs ON ft.subcategoryID = fs.subcategoryID WHERE t.name LIKE '%$searchstr%' ORDER BY tolerance DESC LIMIT ".$limit);
							break;
						case "tuser":
							$resultPopular = $database->db_query("SELECT DISTINCT fs.safeName, u.name, ft.threadID, ft.subject, ft.author, ft.dateAdded FROM Forum_Thread as ft JOIN Users as u ON u.userID = ft.author JOIN Forum_Subcategory as fs ON ft.subcategoryID = fs.subcategoryID WHERE u.name LIKE '%$searchstr%' ORDER BY tolerance DESC LIMIT ".$limit);
							break;
						case "tname":
							$resultPopular = $database->db_query("SELECT DISTINCT fs.safeName, u.name, ft.threadID, ft.subject, ft.author, ft.dateAdded FROM Forum_Thread as ft JOIN Users as u ON u.userID = ft.author JOIN Forum_Subcategory as fs ON ft.subcategoryID = fs.subcategoryID WHERE ft.subject LIKE '%$searchstr%' ORDER BY tolerance DESC LIMIT ".$limit);
							break;
						case "puser":
							$resultPopular = $database->db_query("SELECT DISTINCT fs.safeName, u.name, ft.threadID, ft.subject, ft.author, ft.dateAdded FROM Forum_Thread as ft JOIN Users as u ON u.userID = ft.author JOIN Forum_Subcategory as fs ON ft.subcategoryID = fs.subcategoryID JOIN Forum_Post as fp ON fp.threadID = ft.threadID WHERE u.name LIKE '%$searchstr%' ORDER BY ft.tolerance DESC LIMIT ".$limit);
							break;
						case "pname":
							$resultPopular = $database->db_query("SELECT DISTINCT fs.safeName, u.name, ft.threadID, ft.subject, ft.author, ft.dateAdded FROM Forum_Thread as ft JOIN Users as u ON u.userID = ft.author JOIN Forum_Subcategory as fs ON ft.subcategoryID = fs.subcategoryID JOIN Forum_Post as fp ON fp.threadID = ft.threadID WHERE fp.post LIKE '%$searchstr%' ORDER BY ft.tolerance DESC LIMIT ".$limit);
							break;
					}
					
					while($rowPopular = mysqli_fetch_object($resultPopular)){
						$resultCount = $database->db_query("SELECT count(author) as 'count' FROM Forum_Post WHERE threadID=".$rowPopular->threadID);
						$postCount = mysqli_fetch_object($resultCount);
				?>
				
				<div class="forums_list_main_row">
					<div class="forums_list_mleft1">
						<div class="forums_icon2"></div>
						<div class="forums_list_main_item">
							<a href="/forums/<?php echo $rowPopular->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>"><?php echo substr($rowPopular->subject, 0, 30); ?></a><br/>
							[
							<?php 
								$numPages = ceil($postCount->count/RESULTS_PER_PAGE);
								if($numPages > 5) {
									for($i=1; $i<=3; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowPopular->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	}
									echo "...";
									for($i=$numPages-1; $i<=$numPages; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowPopular->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
							<?php 	}
								} else {
									for($i=1; $i<=$numPages; $i++){
							?>
									<a class="blue" href="/forums/<?php echo $rowPopular->safeName; ?>/oldest/<?php echo $rowPopular->threadID; ?>/<?php echo $i; ?>"><?php echo $i; ?></a><?php if($i!=$numPages) { echo ","; } ?>
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
			Topics <?php echo ($page-1)*RESULTS_PER_SUBCATEGORY_LIST+1; ?> - <?php echo $endPage; ?> of <?php echo $rowPCount->count; ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/1/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo "first"; ?> </a>
			<?php if($page > 1) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $page-1; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo "<"; ?> </a>
			<?php } ?>
			<?php
				if($numTPages > 5){
					if($page > 3){
						for($i=$page-2; $i<=$page; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
						for($i=$page+1; $i<=$page+3; $i++){
							if($i > $numPages) {
								break;
							}
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
					} else {
					
						for($i=1; $i<=3; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
						echo "...";
						for($i=$numTPages-1; $i<=$numTPages; $i++){
							if($i == $page){
			?>
									<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
									<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
							}
						}
					}
				} else {
					for($i=1; $i<=$numTPages; $i++){
						if($i == $page){
			?>
								<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php 		 } else {	?>
								<a class="blue" href="/forums/search/<?php echo $i; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo $i; ?></a>
			<?php
						}
					}
				}
			?>
			<?php if($page < $numTPages) { ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $page+1; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo ">"; ?> </a>
			<?php } ?>
			<a class="blue" style="font-weight: bold;" href="/forums/search/<?php echo $numTPages; ?>/<?php echo $type; ?>/<?php echo $searchstr; ?>"><?php echo "last"; ?> </a>
		
		</div>
		<?php } else { ?>
			</div>
			<div>
				No Results were found
			</div>
		<?php } ?>
	</div>
</div>
<div id="forums_right_list">
	<div id="forums_tower_ad">
		<div><img src="/theme/images/skyscraper.gif" /></div>
	</div>
</div>
<div style="clear: both;"></div>
<div style="width: 792px; height: 8px; font-size: 1px; line-height: 1px;"></div>
<div id="forums_list_bottom">
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
			<form action="" method="POST">
				<select class="forums_select_forum" style="margin: 0px;" name="selectForum">
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