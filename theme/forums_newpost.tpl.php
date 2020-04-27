<?php
	global $core;
	global $session;
	global $database;
	
	if($session->user){
		
		$canPost = 1;
		
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/forums.css" />


<script type="text/javascript">
	var area;
	var showDiv;
	var formattedStr = "";
	var startPosition = 0;
	var endPosition = 0;
	var pollOptionsNum = 1;
	
	<?php
		if(isset($_SESSION['post_timer'])) {
			if(time() >= $_SESSION['post_timer']+SECONDS_PER_POST) {
				//$_SESSION['post_timer'] = time();
				$canPost = 1;
			} else {
				$canPost = 0;
			}
		} else {
			//$_SESSION['post_timer'] = time();
			$canPost = 1;
		}
		echo "var canPost = $canPost";
	?>
	
	var timeLeft = <?php echo $_SESSION['post_timer']+SECONDS_PER_POST - time(); ?>
	
	window.onload = function()
	{
		area = document.getElementById("area");
		showDiv = document.getElementById("showDiv");
	};
	
	function insertTag(tag)
	{
		startTag = "["+tag+"]";
		endTag = "[/"+tag+"]";
		
		findPositions();
		
		var text = area.value;
		if (startPosition!=endPosition) {
			var sbStr = text.substring(startPosition,endPosition);
			sbStr = startTag+sbStr+endTag;
		} else {
			sbStr = startTag+endTag;
		}
		fillsFormattedString(text,sbStr);
	}
	
	function insertLink() {
		var url=window.prompt("Enter your URL:", "http://");
		
		if(url == null){
			return;
		}
		
		var title=window.prompt("Enter the webpage title:", "");
		
		if(title == null){
			return;
		}
		
		findPositions();
		
		var text = area.value;
		if(title == ""){
			sbStr = "[url="+url+"]"+url+"[/url]";
		} else {
			sbStr = "[url="+url+"]"+title+"[/url]";
		}
		fillsFormattedString(text,sbStr);
	}
	
	function insertImage() {
		findPositions();
		var boxInner = setOverlay(500, 280, "INSERT IMAGE");
		var str = "<div style='width: 95%; height: 20px; margin: 0px auto; font-size: 8pt; text-align: left;'><a href='http://photobucket.com/'><img src='/theme/images/photobucket.png' border='0' alt='Photobucket.com image hosting and photo sharing'></a><br/><br/><b>Image rules:</b> We are trying to keep this site void of porn. So we are using the Photobucket service for our image posting. Please refrain from inserting porn images. If porn is posted, Photobucket will take down the images and your post will be displayed with a red x.<br/><br/><b>Image URL: </b><span id='imageError' style='color: #cc0000;'></span><br/><input type='text' onkeypress='clearError(event);' id='imageHotlink' style='width: 100%;' value='http://' /><br/><br/><div style='width: 100%; text-align: center; margin-top: 30px;'><input type='submit' value='Insert Image' onclick='checkImage();'/></div></div>";
		boxInner.innerHTML = str;
	}
	
	function setOverlay(width, height, title) {
		overlayBox = document.getElementById("overlay");
		box = document.getElementById("overlay_message_box");
		box2 = document.getElementById("overlay_box");
		boxInner = document.getElementById("overlay_inner");
		header = document.getElementById("headerTitle");
		
		header.innerHTML = title;
		
		box.style.width = width+'px';
		box.style.height = height+'px';
		box.style.marginLeft = (-width/2)+'px';
		box.style.marginTop = (-height/2)+'px';
		
		box2.style.width = (width-2)+'px';
		boxInner.style.width = (width-10)+'px';
		boxInner.style.height = (height-37)+'px';
		
		overlayBox.style.display = "block";
		box.style.display = "block";
		document.body.style.overflow='hidden';
		
		return boxInner;
	}
	
	function clearError(event) {
		if(event && event.which == 13) {
			checkImage();
		} else {
			var imageError = document.getElementById("imageError");
			imageError.innerHTML = "";
		}
	}
	
	function checkImage() {
		var imageInsert = document.getElementById("imageHotlink");
		var imageError = document.getElementById("imageError");
		
		if(imageInsert.value == "") {
			imageError.innerHTML = "You must provide a link to a photobucket image";
			return;
		}
		
		if(imageInsert.value.search(/http:\/\//i) != -1){
			if(imageInsert.value.search(/photobucket.com/i) != -1){
				addImageToEditor();
			} else {
				imageError.innerHTML = "You can only use image posted on photobucket";
			}
		} else {
			imageError.innerHTML = "Your image link must begin with http://";
		}
		
	}
	
	function addImageToEditor() {
		var imageInsert = document.getElementById("imageHotlink").value;
		
		var text = area.value;
		sbStr = "[img="+imageInsert+"][/img]";
		fillsFormattedString(text,sbStr);
		
		cancelPopup();
	}
	
	function findPositions()
	{
		var text = area.value;
	
		if (document.selection) {
			// Internet Explorer
			var range = document.selection.createRange();
			var dpl = range.duplicate();
			if (range.text.length > 0) {
				dpl.moveToElementText(area);
				dpl.setEndPoint("EndToEnd", range);
				startPosition = dpl.text.length-range.text.length;
				endPosition = startPosition + range.text.length;
			}
		}
		else {
			// Mozilla Firefox
			startPosition = area.selectionStart;
			endPosition = area.selectionEnd;
		}
	}
	
	function fillsFormattedString(text, selectedText)
	{
		// split textarea value into three pieces: before startPosition,
			// startPosition until endPosition, and after endPosition
		var str1 = text.substring(0,startPosition);
		var str2 = text.substring(startPosition,endPosition);
		var str3 = text.substring(endPosition,text.length);
	
		// replace str2 with formatted substring (selectedText)
		str2 = selectedText;
		// form the new string
		formattedStr = str1+str2+str3;
		area.value = formattedStr;
	}
	
	function addPoll() {
		document.getElementById("pollBox").style.display = "block";
		document.getElementById("addPoll").innerHTML = "<input type='button' value='Remove' onclick='removePoll();'/>";
	}
	
	function removePoll() {
		document.getElementById("pollBox").style.display = "none";
		document.getElementById("addPoll").innerHTML = "<input type='button' value='Add' onclick='addPoll();'/>";
		
		pollOptionsNum = 1;
		str = "<tr><td>Option</td><td><input type='text' name='pollOption"+pollOptionsNum+"' style='width: 110px; margin-left: 10px;' /></td></tr>"
		document.getElementById("pollOptions").innerHTML = str;
	}
	
	function addOption() {
		pollOptionsNum++;
		if(pollOptionsNum <= 10){
			str = "<tr><td>Option</td><td><input type='text' name='pollOption"+pollOptionsNum+"' style='width: 110px; margin-left: 10px;' /></td></tr>"
			document.getElementById("pollOptions").innerHTML += str;
		}
	}
	
	function changeAction(object){
		
		var type = object.options[object.selectedIndex].value;
		var content = document.getElementById("actionContent");
		var visible = document.getElementById("actionVisible");
		
		if(type == 0) {
			visible.style.display = "none";
			content.innerHTML = "";
		} else if(type == 1) {
			visible.style.display = "block";
			var str = "<input type='hidden' name='diceExists' value='1' /><table border='0'><tr><td colspan='5'>Choose your dice</td></tr><tr><td><input type='radio' name='dice' value='4' checked='checked' /></td><td>4-sided</td><td></td><td><input type='radio' name='dice' value='6' /></td><td>6-sided</td></tr><tr><td><input type='radio' name='dice' value='8' /></td><td>8-sided</td><td></td><td><input type='radio' name='dice' value='10' /></td><td>10-sided</td></tr><tr><td><input type='radio' name='dice' value='12' /></td><td>12-sided</td><td></td><td><input type='radio' name='dice' value='20' /></td><td>20-sided</td></tr><tr><td><input type='radio' name='dice' value='100' /></td><td>100-sided</td><td colspan='3'></td></tr></table>";
			content.innerHTML = str;
		} else if(type == 2){
			visible.style.display = "block";
			var str = "<input type='hidden' name='randomExists' value='1' /><table border='0'><tr><td colspan='3'>Choose your range</td></tr><tr><td>From: <input type='text' size='2' name='minRand' /></td><td> </td><td>To: <input type='text' size='2' name='minRand' /></td></tr><tr><td colspan='3' style='font-size: 7pt; text-align: center;'>(Leave blank for a random range)</td></tr></table>";
			content.innerHTML = str;
		}
		
	}
	
	function checkPost(){
		if(canPost == 1){
			document.theform.submit();
		} else {
			showError("Please be patient, you have "+timeLeft+" seconds until you can post again.");
		}
	}
	
	window.setTimeout('canPost = 1;', <?php echo (($_SESSION['post_timer']+SECONDS_PER_POST) - time())*1000; ?>);
	window.setInterval('timeLeft--', 1000);
	
</script>

<?php
	$resultS = $database->db_query("SELECT * FROM Forum_Subcategory WHERE safeName='".$core->args[1]."'");
	$rowS = mysqli_fetch_object($resultS);
	
	$resultC = $database->db_query("SELECT * FROM Forum_Category WHERE categoryID=".$rowS->categoryID);
	$rowC = mysqli_fetch_object($resultC);
	
?>

<div id="forums_list_top_row">
	<div class="forums_icon_box_<?php echo $rowC->color; ?>"><img src="/content/forums/subcategoryIcons/<?php echo $rowS->icon; ?>" /></div>
	<div id="forums_minor_title_area">
		<div id="forums_minor_title">POST YOUR MESSAGE</div>
		<div id="forums_list_top_bread">
			<a class="blue" href="/forums"><?php echo $rowC->name; ?></a> - 
			<a class="blue" href="/forums/<?php echo $rowS->safeName; ?>"><?php echo $rowS->name; ?></a> - 
			<a class="blue" href="/forums">POPULAR LISTINGS</a>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
<div style="width: 235px; height: 20px;"></div>

<?php if($core->args[4] == "reply") { 

	$resultP = $database->db_query("SELECT * FROM Forum_Post WHERE postID=".$core->args[5]);
	$rowP = mysqli_fetch_object($resultP);
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/forums_topic.css" />
<div class="site_box" style="width: 790px;">
	<?php
		$userResult = $database->db_query("SELECT * FROM Users WHERE userID=".$rowP->author);
		$rowU = mysqli_fetch_object($userResult);
		
		$date = $prettyprint->prettyDate($rowU->signup, "[m] [d], [y]");
		
		if($data->sex == "m"){
			$usersex = "Male";
		} else {
			$usersex = "Female";
		}
	?>
	<div class="site_box_head" style="text-align: left;">
		<div class="forum_head">
			<div class="forum_head_icon">
				<img src="/theme/images/onlineicon.png" style="behavior: url(/iepngfix.htc);"/>
			</div>
			<div class="forum_head_center">
				<span class="whitebold10"><?php echo $rowU->name; ?></span>
				<span class="grey10">[offline]</span>
			</div>
			<div class="forum_head_right">
				<!--Thumbs?-->
			</div>
		</div>
	</div>
	<div class="forums_post_content">
		<div class="forums_post_left">
<script type="text/javascript">
	var flashvars = {
		uid: "<?php echo $rowU->userID; ?>",
		dummy: 	"<?php echo time(); ?>"
		<?php if($rowU->isCrew == 1) { ?>, crewSwf: <?php echo "'".$rowU->crewFull."'"; } ?>
	};
	
	var params = {
		menu: "false",
		quality: "high",
		wmode: "transparent",
		bgcolor: "#ffffff"
	};
	<?php if($rowU->isCrew == 1) { ?>
	swfobject.embedSWF("/characterBuilder/viewers/crewviewer.swf", "forumsLeftViewer", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);
	<?php } else { ?>
	swfobject.embedSWF("/characterBuilder/viewers/viewer_<?php echo $rowU->sex; ?>_1.swf", "forumsLeftViewer", "141", "181", "8", "/engine/swfobject/expressInstall.swf", flashvars, params);	
	<?php } ?>
</script>
			<a href="/user/<?php echo $rowU->name; ?>">
			<div class="forums_post_character">
				<div style="cursor: pointer;" onclick="location='/user/<?php echo $rowU->name; ?>';">
					<div id="forumsLeftViewer">
					
					</div>
				</div>
			</div>
			</a>
			<div class="forums_post_info">
				<table border="0" width="131">
					<tr><td>LEVEL</td><td class="td_righty"><?php echo $podunkton->calculateLevel($rowU->experience); ?></td></tr>
					<tr><td>Sign-up</td><td class="td_righty"><?php echo $date; ?></td></tr>
					<tr><td>Posts</td><td class="td_righty"><?php echo $rowU->posts; ?></td></tr>
				</table>
				<table border="0">
					<tr><td>EXP</td>
						<td colspan="2">
							<?php echo $podunkton->showExp($rowU->experience); ?>
						</td>
					</tr>
					<tr>
						<?php echo $podunkton->goodevil2($rowU->goodevil); ?>
					</tr>
				</table>
			</div>
		</div>
		<div class="forums_post_right">
			<?php
				if($rowP->actionID != 0){
					$resultAction = $database->db_query("SELECT message FROM Forum_Actions WHERE actionID = ".$rowP->actionID);
					$rowAction = mysqli_fetch_object($resultAction);
			?>
				<div class="actionsBox">
					<div class="actionsInner">
						<?php echo $rowAction->message; ?>
					</div>
				</div>
			<?php } ?>
			<div class="forums_post">
				<div class="forums_post_content_left">
					<div class="forums_bubble_left"></div>
				</div>
				<div class="forums_post_content_right">
					<div class="forums_post_bubble_top_row">
						<div class="forums_bubble_top_left"></div>
						<div class="forums_bubble_top"></div>
						<div class="forums_bubble_top_right"></div>
						<div style="clear: both;"></div>
					</div>
					<div class="forums_bubble_inner">
						<div class="forums_bubble_inner_top">
							<div style="float: left;"><a href="/user/<?php echo $rowU->name; ?>" class="blue"><?php echo $rowU->name; ?></a> said:</div>
							<div style="float: right;">Posted on <?php echo $prettyprint->prettyDate($rowP->dateAdded, "[M] [D], [Y] at [x] [CZ]"); ?></div>
						</div>
						<div  class="forums_bubble_inner_bot">
							<div class="forums_post_thepost">
								<?php echo stripslashes($rowP->post); ?>
							</div>
						</div>
					</div>
					<div class="forums_post_bubble_bot_row">
						<div class="forums_bubble_bot_left"></div>
						<div class="forums_bubble_bot"></div>
						<div class="forums_bubble_bot_right"></div>
						<div style="clear: both;"></div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div class="forums_post_tools">
				<div class="forums_post_tools_left">
					<?php if($user != $rowU->userID) { ?>
					<form name="startTrade<?php echo $idC; ?>" action="/process/startTrade" method="POST" style="margin: 0px; padding: 0px;">
						<a href="/mail/compose/<?php echo $rowU->userID; ?>"><img src="/theme/images/icon_pm2.png" /></a>
						<img style="cursor: pointer;" src="/theme/images/icon_trade2.png" onclick="document.startTrade<?php echo $idC; ?>.submit();"/></a>
						<?php if($rowU->aim != "") { ?>
							<a href="aim:goim?screenname=<?php echo $rowU->aim; ?>;message=Hail+from+Podunkton!"><img src="/theme/images/icon_aim2.png" /></a>
						<?php } ?>
						<input type="hidden" name="uname" value="<?php echo $rowU->name; ?>" />
					</form>
					<?php } ?>
				</div>
				<div class="forums_post_tools_right">
					<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $core->args[3]; ?>/reply/<?php echo $rowP->postID; ?>"><img src="/theme/images/button_reply_post.png" /></a>
					<a href="/forums/<?php echo $rowS->safeName; ?>/newpost/<?php echo $core->args[3]; ?>/quote/<?php echo $rowP->postID; ?>"><img src="/theme/images/button_quote.png" /></a>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div style="clear: both; overflow: hidden;"></div>
	</div>
</div>
<div style="width: 792px; height: 8px; overflow: hidden;"></div>
<?php } ?>

<?php
	if($canPost == 0){
		$timeLeft = $_SESSION['post_timer']+SECONDS_PER_POST - time();
		echo "You have $timeLeft seconds until you can post this.";
	}
?>

<form name="theform" action="/process/addNewPost" method="POST" style="margin: 0px; padding: 0px;">
	<div id="forums_left">
		<div class="site_box" style="width: 600px;">
			<div class="site_box_head">
				<div class="forums_title">MESSAGE</div>
			</div>
			<div class="site_box_content">
				<div class="site_box_content_inner" style="width: 588px; padding: 5px 0px 0px 0px;">
					<div class="forums_post_toolbar">
						<div class="toolBtn" title="Bold"><img border="0" src="/theme/images/toolIcons/bold.png" onclick="insertTag('b');" /></div>
						<div class="toolBtn" title="Italic"><img border="0" src="/theme/images/toolIcons/italic.png" onclick="insertTag('i');" /></div>
						<div class="toolBtn" title="Underline"><img border="0" src="/theme/images/toolIcons/underline.png" onclick="insertTag('u');" /></div>
						<div class="toolBtn" title="Strikeout"><img border="0" src="/theme/images/toolIcons/strike_through.png" onclick="insertTag('strike');" /></div>
						<div class="toolSep"></div>
						<div class="toolBtn" title="Left Align"><img border="0" src="/theme/images/toolIcons/align_left.png" onclick="insertTag('alignleft');" /></div>
						<div class="toolBtn" title="Center Align"><img border="0" src="/theme/images/toolIcons/align_center.png" onclick="insertTag('aligncenter');" /></div>
						<div class="toolBtn" title="Right Align"><img border="0" src="/theme/images/toolIcons/align_right.png" onclick="insertTag('alignright');" /></div>
						<div class="toolSep"></div>
						<div class="toolBtn" title="Small Font"><img border="0" src="/theme/images/toolIcons/fontSmall.png" onclick="insertTag('fontsmall');" /></div>
						<div class="toolBtn" title="Large Font"><img border="0" src="/theme/images/toolIcons/fontLarge.png" onclick="insertTag('fontlarge');" /></div>
						<div class="toolSep"></div>
						<div class="toolBtn" style="width: 16px;" title="Quote"><img border="0" src="/theme/images/toolIcons/blockquote.png" onclick="insertTag('quote');" /></div>
						<div class="toolBtn" style="width: 16px;" title="Link"><img border="0" src="/theme/images/toolIcons/insert_link.png" onclick="insertLink();" /></div>
						<div class="toolBtn" style="width: 16px;" title="Image"><a href="#"><img border="0" src="/theme/images/toolIcons/image.png" onclick="insertImage();" /></a></div>
						<div class="toolSep"></div>
						<div class="toolBtn" style="cursor: default; width: auto; font-size: 9pt; font-weight:bold;">Colors:</div>
						<div class="toolBtn" title="Radical Red" style="margin-left: 1px;"><div class="toolColor" style="background-color: #ff0000; overflow: hidden;" onclick="insertTag('red');"></div></div>
						<div class="toolBtn" title="Ornery Orange" style="margin-left: 1px;"><div class="toolColor" style="background-color: #FFA500; overflow: hidden;" onclick="insertTag('orange');"></div></div>
						<div class="toolBtn" title="Poop Brown" style="margin-left: 1px;"><div class="toolColor" style="background-color: #804C1F; overflow: hidden;" onclick="insertTag('brown');"></div></div>
						<div class="toolBtn" title="PeePee Yellow" style="margin-left: 1px;"><div class="toolColor" style="background-color: #FFFF00; overflow: hidden;" onclick="insertTag('yellow');"></div></div>
						<div class="toolBtn" title="Giant Green" style="margin-left: 1px;"><div class="toolColor" style="background-color: #008000; overflow: hidden;" onclick="insertTag('green1');"></div></div>
						<div class="toolBtn" title="Puke Green" style="margin-left: 1px;"><div class="toolColor" style="background-color: #808000; overflow: hidden;" onclick="insertTag('green2');"></div></div>
						<div class="toolBtn" title="Fairy Blue" style="margin-left: 1px;"><div class="toolColor" style="background-color: #00FFFF; overflow: hidden;" onclick="insertTag('blue1');"></div></div>
						<div class="toolBtn" title="Bobby Blue" style="margin-left: 1px;"><div class="toolColor" style="background-color: #0000FF; overflow: hidden;" onclick="insertTag('blue2');"></div></div>
						<div class="toolBtn" title="Deep Blue" style="margin-left: 1px;"><div class="toolColor" style="background-color: #00008B; overflow: hidden;" onclick="insertTag('blue3');"></div></div>
						<div class="toolBtn" title="Barney Purple" style="margin-left: 1px;"><div class="toolColor" style="background-color: #4B0082; overflow: hidden;" onclick="insertTag('purple');"></div></div>
						<div class="toolBtn" title="Pinky Pink" style="margin-left: 1px;"><div class="toolColor" style="background-color: #EE82EE; overflow: hidden;" onclick="insertTag('pink');"></div></div>
						<div class="toolBtn" title="Invisible Ink" style="margin-left: 1px;"><div class="toolColor" style="background-color: #fff; overflow: hidden;" onclick="insertTag('white');"></div></div>
					</div>
					<div class="forums_post_toolbar">
					
					</div>
					<textarea id="area" rows="15" style="width: 596px;" name="message"></textarea>
				</div>
				<div id="forums_post_bottom">
					<input type="button" name="save" value="Submit" onclick="checkPost();"/>
					<input type="reset" name="reset" value="Reset" />
				</div>
			</div>
		</div>
	</div>
	<div id="forums_right">
		<div class="site_box" style="width: 180px;">
			<div class="site_box_head">
				<div class="forums_title2">ACTIONS</div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 170px;">
					<select name="actions" style="width: 170px;"  onchange="changeAction(this);">
						<option value="0">None</option>
						<option value="1">Roll some dice</option>
						<option value="2">Random Number</option>
					</select>
				</div>
			</div>
			<div id="actionVisible" class="site_box_content" style="background-color: #fff; display: none;">
				<div id="actionContent" class="site_box_content_inner" style="width: 170px; min-height: 93px; font-size: 8pt; color: #595959;">
					
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="safeName" value="<?php echo $core->args[1]; ?>" />
	<input type="hidden" name="threadID" value="<?php echo $core->args[3]; ?>" />
	
	<?php if($core->args[4] == "reply") { ?>
		<input type="hidden" name="postID" value="<?php echo $core->args[5]; ?>" />
		<input type="hidden" name="page" value="<?php echo $core->args[6]; ?>" />
		<input type="hidden" name="type" value="reply" />
	<?php } elseif($core->args[4] == "quote") { ?>
		<input type="hidden" name="postID" value="<?php echo $core->args[5]; ?>" />
		<input type="hidden" name="page" value="<?php echo $core->args[6]; ?>" />
		<input type="hidden" name="type" value="quote" />
	<?php } else { ?>
		<input type="hidden" name="type" value="post" />
	<?php } ?>
</form>
<div style="clear: both;"></div>
<div style="width: 182px; height: 8px; overflow: hidden;"></div>
<div class="site_box" style="width: 788px;">
	<div class="site_box_head">
		<div class="forums_title">RECENT POSTS</div>
	</div>
	<div class="site_box_content" style="background-color: #fff; border-bottom: none; height: 200px; overflow-y: scroll;">
		<?php 
			$lastResult = $database->db_query("SELECT u.name, p.dateAdded, p.post FROM Forum_Post as p JOIN Users as u ON p.author = u.userID WHERE threadID=".$core->args[3]." ORDER BY dateAdded DESC LIMIT 20");
			$count = mysqli_num_rows($lastResult);
			$c = 1;
			while($lastRow = mysqli_fetch_object($lastResult)){
		?>
		<div class="forums_recent_row" <?php if($c==$count-1) echo "style='border-bottom: none;'"; ?> >
			<div class="forums_recent_name"><a class="blue" href="/user/<?php echo $lastRow->name; ?>"><?php echo $lastRow->name; ?></a></div>
			<div class="forums_recent_item">
				<div class="forums_recent_datetime">Posted: <?php echo $lastRow->dateAdded; ?></div>
				<div class="forums_recent_text"><?php echo substr(strip_tags($lastRow->post), 0, 40); ?></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<?php 
				$c++;
			} 
		?>
	</div>
	<div class="site_box_head" style="border-top: none; border-bottom: 1px;">
		<div class="forums_title2"></div>
	</div>
</div>
<?php } else { ?>
	You must be logged in to post
<?php } ?>
<div style="width: 235px; height: 8px; overflow: hidden;"></div>
<div id="forums_ad2">
	<img src="/theme/images/forums_ad2.png" />
</div>