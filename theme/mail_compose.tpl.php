<?php
	global $session;
	global $database;
	global $core;
	
	$user = $session->user;
	$to = $core->args[2];
	$mid = $core->args[3];
	
	if($mid) {
		$resultM = $database->db_query("SELECT subject FROM Messages WHERE mid = $mid");
		$rowM = mysqli_fetch_object($resultM);
		$subject = "RE: ".$rowM->subject;
	}
	
	if($to != ""){
		$result = $database->db_query("SELECT name FROM Users WHERE userID = $to");
		$rowU = mysqli_fetch_object($result);
	}
?>

<script type="text/javascript">
	var area;
	var showDiv;
	var formattedStr = "";
	startPosition = 0;
	var endPosition = 0;
	var pollOptionsNum = 1;
	
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
	
</script>

<div id="mail_head" style="border: none;">
	<img src="/theme/images/mail_sign.png" />
</div>
<div id="compose_top">
	<div class="compose_top_a"><a class="blue" href="/mail">Back to Inbox</a></div>
	<div id="compose_seperator"></div>
	<div class="compose_top_a"><a class="blue" href="/mail/sent">Go to Sentbox</a></div>
	<div style="clear: both;"></div>
</div>
<form name="messageForm" action="/process/sendMessage<?php if($mid) { echo "/".$mid; } ?>" method="POST">
	<div class="compose_message_bar">
		<img style="float: left; cursor: pointer;" onclick="document.messageForm.submit();" src="/theme/images/send_message.png" />
		<a style="float: left;" href="/mail"><img style="margin-left: 8px;" src="/theme/images/cancel_message.png" /></a>
		<div style="clear: both;"></div>
	</div>
	<div id="forums_left">
		<div class="site_box" style="width: 600px;">
			<div class="site_box_head">
				<div class="forums_title">NEW MESSAGE</div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 590px;">
					<table border="0">
						<tr><td class="smallGrey">TO: </td><td><input class="subjectInput" name="to" value="<?php echo $rowU->name; ?>"/></td></tr>
						<tr><td class="smallGrey">SUBJECT: </td><td><input class="subjectInput" name="subject" value="<?php echo $subject; ?>"/></td></tr>
					</table>
				</div>
			</div>
		</div>
		<div style="width: 235px; height: 8px;"></div>
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
					<textarea id="area" name="message" rows="15" style="width: 596px;"></textarea>
				</div>
				<div id="forums_post_bottom">
				</div>
			</div>
		</div>
		<div class="compose_message_bar" style="padding-top: 5px;">
			<img style="float: left; cursor: pointer;" onclick="document.messageForm.submit();" src="/theme/images/send_message.png" />
			<a style="float: left;" href="/mail"><img style="margin-left: 8px;" src="/theme/images/cancel_message.png" /></a>
			<div style="clear: both;"></div>
		</div>
	</div>
	<div id="forums_right">
		<div id="forums_tower_ad">
			<div><img src="/theme/images/skyscraper.gif"/></div>
		</div>
	</div>
	<div style="clear: both;"></div>
</form>