<?php
	global $core;
	global $session;
	global $database;
?>
<h3>Current Subcategories</h3>
<?php
	$result = $database->db_query("SELECT * FROM Forum_Subcategory ORDER BY sort");
	while($row = mysqli_fetch_object($result)){
?>		
		<div style="padding-bottom: 10px;">
			<div style="float: left;"><img src="/content/forums/subcategoryIcons/<?php echo $row->icon; ?>" /></div>
			<div style="float: left; padding-left: 10px;"><?php echo $row->name; ?><br/><?php echo $row->description; ?></div>
			<div style="clear: both;"></div>
		</div>
<?php
	}
?>