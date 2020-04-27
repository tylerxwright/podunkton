<?php
	global $database;
	
	$result = $database->db_query("SELECT * FROM MPAA_Ratings");
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
<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">MPAA Ratings</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/toon/mpaa/add';" title="Add a new MPAA Rating"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>
<?php
	$c = 0;
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="#"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="View Description" class="slideBtn" onclick="clicked('box<?php echo $c; ?>');"></div>
		<div title="Edit" class="editBtn" onclick="location='/admin/toon/mpaa/edit/<?php echo $row->mpaaID; ?>';"></div>
		<div title="delete" class="deleteBtn" onclick="location='/process/deleteMPAA/<?php echo $row->mpaaID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box<?php echo $c; ?>" class="genreDesc">
	<div id="watch_icon">
		<img src="/content/mpaa/<?php echo $row->icon; ?>" />
	</div>
	<div id="watch_rating_text">
		<ul id="watch_rating_text">
			<li><?php echo $row->name; ?></li>
			<li><?php echo $row->line1; ?></li>
			<li><?php echo $row->line2; ?></li>
		</ul>
	</div>
	<div style="clear: both;"></div>
</div>
<?php 
		$c++;
	} 
?>