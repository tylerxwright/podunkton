<?php
	global $database;
	
	$result = $database->db_query("SELECT * FROM Toon_Seasons ORDER BY seasonOrder ASC");
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
<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Toon Seasons</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/toon/season/add';" title="Add a new season"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>
<?php
	$c = 0;
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="#"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="View Description" class="slideBtn" onclick="clicked('box<?php echo $c; ?>');"></div>
		<div title="Edit" class="editBtn" onclick="location='/admin/toon/season/edit/<?php echo $row->seasonID; ?>';"></div>
		<div title="delete" class="deleteBtn" onclick="location='/process/deleteToonSeason/<?php echo $row->seasonID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box<?php echo $c; ?>" class="genreDesc">
	<a onmouseout="document.<?php echo $row->safeName; ?>.src='/content/toons/seasons/<?php echo $row->picture; ?>'; this.style.cursor = 'pointer';" onmouseover="document.<?php echo $row->safeName; ?>.src='/content/toons/seasons/<?php echo $row->hoverPicture; ?>'; this.style.cursor = 'pointer';" href="#" onclick="return false;" style="cursor: pointer;">
		<img border="0" name="<?php echo $row->safeName; ?>" src="/content/toons/seasons/<?php echo $row->picture; ?>"/>
	</a>
</div>
<?php 
		$c++;
	} 
?>