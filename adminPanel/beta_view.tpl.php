<?php
	global $database;
	global $session;
	global $core;
	
	$reportID = $core->args[3];
	
	$result = $database->db_query("SELECT u.name, e.subject, e.postdate, e.message FROM Error_Reports as e JOIN Users as u ON e.userID = u.userID WHERE e.reportID = $reportID");
	$row = mysqli_fetch_object($result);
?>
<table border="0">
	<tr><th width="100">Posted by:</th><td width="500"><a style="color: #0000ff;" href="/user/<?php echo $row->name; ?>"><?php echo $row->name; ?></a></td></tr>
	<tr><th>Post Date:</th><td><?php echo $row->postdate; ?></td></tr>
	<tr><th>Subject:</th><td><?php echo $row->subject; ?></td></tr>
</table>
<br/>
<div style="float: left; font-weight: bold; padding-right: 20px;">Message:</div>
<div style="float: left; width: 400px;">
	<?php echo stripslashes(str_replace("?>", "[/php]", str_replace("<?php", "[php]", str_replace("<br />", "", $row->message)))); ?>
</div>
<div style="clear: both;"></div>
