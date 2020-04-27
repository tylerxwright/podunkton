<?php
	global $database;
	
	$result = $database->db_query("SELECT genreID, name, description FROM Genres ORDER BY name ASC");
	$num = mysqli_num_rows($result);
?>
<script type="text/javascript" src="/engine/jquery.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		<?php for($i=0; $i<$num; $i++){ ?>
		$('div#box<?php echo $i; ?>').hide();
		<?php } ?>
	});
	
	function clicked(id) {
		$('div#'+id).slideToggle("slow");
	}
	
</script>
<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Genres</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/audio/genre/add';" title="Add a new genre"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>
<?php
	$c = 0;
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="#"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="View Description" class="slideBtn" onclick="clicked('box<?php echo $c; ?>');"></div>
		<div title="Edit" class="editBtn" onclick="location='/admin/audio/genre/edit/<?php echo $row->genreID; ?>';"></div>
		<div title="delete" class="deleteBtn" onclick="location='/process/deleteGenre/<?php echo $row->genreID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box<?php echo $c; ?>" class="genreDesc"><?php echo $row->description; ?></div>
<?php 
		$c++;
	} 
?>