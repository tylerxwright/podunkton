<?php
	global $database;
	global $session;
	global $core;
?>
<h3>Beta Error Reports</h3>
<table border="0" cellspacing="10">
	<tr><th width="100">USER</th><th width="300">SUBJECT</th><th width="200">DATE</th></tr>
<?php
	$result = $database->db_query("SELECT e.reportID, e.subject, e.postdate, u.name FROM Error_Reports as e JOIN Users as u ON e.userID = u.userID ORDER BY postdate DESC");
	while($row = mysqli_fetch_object($result)) {
?>
	<tr><td><a href="/user/<?php echo $row->name; ?>"><?php echo $row->name; ?></a></td><td><a style="color: #0000ff;" href="/admin/beta/errors/<?php echo $row->reportID; ?>"><?php echo substr($row->subject, 0, 30); ?></a></td><td><?php echo $row->postdate; ?></td></tr>
<?php } ?>
</table>
