<?php
	global $core;
	global $session;
	global $database;
?>

<h2>BETA Admin</h2>
<a href="/process/startBeta"><input type="button" value="Start Beta" /></a>
<input type="button" value="Destroy the Site" />
<table border="0" cellspacing="10">
<tr><th>ID</th><th>EMAIL</th><th>CODE</th><th>VALID</th></tr>
<?php
	$result = $database->db_query("SELECT * FROM Beta");
	while($row = mysqli_fetch_object($result)) {
?>
	<tr><td><?php echo $row->id; ?></td><td><?php echo $row->email; ?></td><td><?php echo $row->code; ?></td><td align="center"><?php echo $row->valid; ?></td></tr>
<?php } ?>
</table>