<?php
	global $core;
	global $session;
	global $database;
?>
<h3>Forum Category Panel</h3>

<h3>Current Categories</h3>
<?php
	$result = $database->db_query("SELECT * FROM Forum_Category ORDER BY sort");
	while($row = mysqli_fetch_object($result)){
?>		
		<div style="padding-bottom: 10px;">
			<div style="float: left;"><img src="/content/forums/categoryIcons/<?php echo $row->icon; ?>" /></div>
			<div style="float: left; padding-left: 10px;"><?php echo $row->name; ?><br/><?php echo $row->color; ?></div>
			<div style="clear: both;"></div>
		</div>
<?php
	}
?>