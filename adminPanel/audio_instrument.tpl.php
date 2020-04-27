<?php
	global $database;
	
	$result = $database->db_query("SELECT instrumentID, name FROM Instruments ORDER BY name ASC");
	$num = mysqli_num_rows($result);
?>
<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Instruments</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/audio/instrument/add';" title="Add a new instrument"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>
<?php
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="#"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="Edit" class="editBtn" onclick="location='/admin/audio/instrument/edit/<?php echo $row->instrumentID; ?>';"></div>
		<div title="delete" class="deleteBtn" onclick="location='/process/deleteInstrument/<?php echo $row->instrumentID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<?php 
	} 
?>