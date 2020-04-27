<?php
	global $session;
	global $database;
	global $core;
	
	$user = $session->user;
	
	$result = $database->db_query("SELECT COUNT(id) as 'count' FROM Inbox WHERE reciever = $user");
	$rowInbox = mysqli_fetch_object($result);
	$inboxNum = $rowInbox->count;
	
	$result = $database->db_query("SELECT * FROM Sent as i JOIN Messages as m ON i.mid = m.mid WHERE sender = $user ORDER BY postdate DESC");
	$numRows = mysqli_num_rows($result);
?>
<div id="mail_head">
	<img src="/theme/images/mail_sign.png" />
</div>

<form action="/process/deleteMessages/sent" method="POST" name="deleteSelected">
<div id="mail_top">
	<div id="mail_left">
		<div class="top" style="padding: 0px;"><a class="blue" href="/mail/compose"><img src="/theme/images/mail_compose_btn.png" /></a></div>
		<div class="top"><a class="blue" href="/mail">INBOX (<?php echo $inboxNum; ?>)</a></div>
		<div class="top"><a class="blue" href="/mail/sent">SENTBOX (<?php echo $numRows; ?>)</a></div>
		<div style="clear: both;"></div>
	</div>
	<div id="mail_right">
		<div class="top2"><a class="blue" href="#" onclick="document.deleteSelected.submit();">DELETE SELECTED</a></div>
	</div>
	<div style="clear: both;"></div>
</div>
<div class="site_box" style="width: 792px;">
	<div class="site_box_head">
		<table border="0">
			<tr>
				<td class="mail_title" width="445" style="padding-left: 15px;">SUBJECT</td>
				<td class="mail_title" width="270">TO</td>
				<td class="mail_title" width="350">DATE</td>
			</tr>
		</table>
	</div>
	<div class="site_box_content" style="background-color: #fff;">
		<div class="site_box_content_inner" style="width: 792px; padding: 0px 0px 5px 0px; /*background-color: #8092BF;/* min-height: 400px;">
			<?php
				if($numRows > 0) {
					$count = 1;
					while($row = mysqli_fetch_object($result)) {
						$resultR = $database->db_query("SELECT name FROM Users WHERE userID = ".$row->reciever);
						$rowU = mysqli_fetch_object($resultR);
			?>
			<?php if($row->replied == 1) { ?>
				<div class="mail_row" style="background-color: #ffffff;" <?php if($count == $numRows) { echo "style='border-bottom: none;'"; } ?>>
					<div style="width: 23px; padding-left: 10px; float: left;">
						<img src="/theme/images/mail_replied.png" title="replied" />
					</div>
			<?php } elseif($row->isread == 1) { ?>
				<div class="mail_row" style="background-color: #ffffff;" <?php if($count == $numRows) { echo "style='border-bottom: none;'"; } ?>>
					<div style="width: 23px; padding-left: 10px; float: left;">
						<img src="/theme/images/mail_read.png" title="read" />
					</div>
			<?php } else { ?>
				<div class="mail_row" style="background-color: #CDDAF9; font-weight: bold;" <?php if($count == $numRows) { echo "style='border-bottom: none;'"; } ?>>
					<div style="width: 23px; padding-left: 10px; float: left;">
						<img src="/theme/images/mail_unread.png" title="Unread" />
					</div>
			<?php } ?>
				<div style="width: 300px; padding-left: 4px; float: left;"><a class="blue" href="/mail/sent/<?php echo $row->mid; ?>"><?php echo $prettyprint->smallString($row->subject, 40); ?></a></div>
				<div style="width: 200px; padding-left: 5px; float: left;"><a class="blue" href="/user/<?php echo $rowU->name; ?>"><?php echo $rowU->name; ?></a></div>
				<div style="width: 215px; float: left; color: #777;"><?php echo $prettyprint->prettyDate($row->postdate, "[m] [d], [y] at [x] [cz]"); ?></div>
				<div style="width: 20px; float: left;"><input type="checkbox" name="c<?php echo $count; ?>" /><input type="hidden" name="mid<?php echo $count; ?>" value="<?php echo $row->mid; ?>"/></div>
				<div style="clear: both;"></div>
			</div>
			<?php 
						$count++;
					} 
				} else {
			?>
				<div style="text-align: center; width: 780px;">You have no messages</div>
			<?php } ?>
		</div>
	</div>
</div>
</form>
<div style="width: 792px; height: 8px;  margin: 0px; padding: 0px;"></div>