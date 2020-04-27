<?php
	global $core;
	global $database;
	
	if(isset($core->args[2])) {
		$toonID = $core->args[2];
	} else {
		$toonID = 0;
	}
	
	$result = $database->db_query("SELECT t.*, s.name as 'sname' FROM Toons as t JOIN Seasons_has_Toons as sht ON sht.toonID = t.toonID JOIN Toon_Seasons as s ON sht.seasonID = s.seasonID ORDER BY t.episode ASC");
	$num = mysqli_num_rows($result);
?>
<script type="text/javascript" src="/engine/jquery.js"></script>
<script type="text/javascript">
	
	var num = <?php echo $num; ?>;
	
	$(document).ready(function() {
		
	});
	
	function clicked(id) {
		$('div#box'+id).slideToggle("slow");
		for(var i=1; i<=num; i++) {
			if(id != i) {
				$('div#box'+i).slideUp("slow");
			}
		}
	}
	
	function editHere(id) {
		var element = document.getElementById(id);
		element.style.display = "block";
	}
	
</script>

<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Toons</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/toon/add';" title="Add a new toon"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>

<?php
	$c = 1;
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="#"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="View Details" class="slideBtn" onclick="clicked(<?php echo $c; ?>);"></div>
		<div title="Edit" class="editBtn" onclick="location='/admin/toon/edit/<?php echo $row->toonID; ?>';"></div>
		<div title="Delete" class="deleteBtn" onclick="location='/process/deleteToon/<?php echo $row->toonID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box<?php echo $c; ?>" class="genreDesc" <?php if($toonID == 0) {if($c==1){ echo "style='display: block;'"; }} else {if($toonID == $row->toonID){echo "style='display: block;'";}} ?>>
	<div class="albumHolder">
		<div style="float: left; font-weight: bold;">
			Toon Picture
		</div>
		<div style="float: left; margin-left: 5px;">
			<div title="Edit" class="editBtn" onclick="editHere('pictureEdit<?php echo $c; ?>');"></div>
		</div>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<div style="float: left; margin-right: 20px; margin-bottom: 8px;">
			<img style="border: solid 1px #333;" src="/content/toons/images/<?php echo $row->icon; ?>" />
		</div>
		<div style="float: right; display: none; text-align: center; width: 320px;" id="pictureEdit<?php echo $c; ?>">
			<b>To change the picture, find a file and hit submit!</b><br/><br/>
			<form enctype="multipart/form-data" action="/process/editToonIcon" method="POST">
				<table border="0" width="100%"><tr><td align="right">
					<input type="file" name="icon" /><br/><br/><br/>
					<input type="hidden" name="toonID" value="<?php echo $row->toonID; ?>" />
					<input type="submit" value="submit" />
				</td></tr></table>
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="albumHolder">
		<b>General Information</b>
		<table border="0">
			<tr><td><b>Season: </b></td><td><?php echo $row->sname; ?></td><tr>
			<tr><td><b>Release Date: </b></td><td><?php echo $row->releaseDate; ?></td><tr>
			<tr><td><b>Newgrounds Link: </b></td><td><a href="<?php echo $row->ngLink; ?>"><?php echo $row->ngLink; ?></a></td><tr>
			<tr><td><b>Episode Number: </b></td><td><?php echo $row->episode; ?></td><tr>
			<tr><td><b>File Size: </b></td><td><?php echo $row->fileSize; ?> MB</td><tr>
			<tr><td><b>View SWF: </b></td><td><a href="/content/toons/swfs/<?php echo $row->swf; ?>"><?php echo $row->swf; ?></a></td><tr>
			<tr><td><b>Munniez: </b></td><td><?php echo $row->munniez; ?></td><tr>
			<tr><td><b>Credits: </b></td><td><?php echo $row->credits; ?></td><tr>
			<tr><td><b>Munniez On View: </b></td><td><?php echo $row->munniezOnView; ?></td><tr>
		</table>
	</div>
	<div class="membersArea">
		<b>Cast Members</b><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/toon/cast/add/<?php echo $row->toonID; ?>';" title="Add a new cast member" src="/theme/images/icons/add.png" width="15" height="15"/>
		<table border="0" width="100%">
<?php
	$resultMembers = $database->db_query("SELECT u.name, u.userID, thc.id FROM Users as u JOIN Toons_has_Cast as thc ON u.userID = thc.userID WHERE thc.toonID = ".$row->toonID);
	while($rowMembers = mysqli_fetch_object($resultMembers)) {
?>
			<tr class="memberRow"><td width="20%"><a href="/user/<?php echo $rowMembers->name; ?>" class="blue"><?php echo $rowMembers->name; ?></a></td><td width="70%">
			</td><td width="10%">
				<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/toon/cast/edit/<?php echo $row->toonID; ?>/<?php echo $rowMembers->id; ?>';"></div>
				<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteToonCastMember/<?php echo $row->toonID; ?>/<?php echo $rowMembers->id; ?>';"></div>
				<div style="clear: both;"></div>
			</td></tr>
<?php } ?>
		</table>
	</div>
	<div class="membersArea">
		<b>Trivia</b><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/toon/trivia/add/<?php echo $row->toonID; ?>';" title="Add a new cast member" src="/theme/images/icons/add.png" width="15" height="15"/>
		<div style="height: 6px; width: 5px;"></div>
		<?php
			$resultTrivia = $database->db_query("SELECT * FROM Toons_Trivia WHERE toonID = ".$row->toonID." ORDER BY triviaOrder ASC");
			while($rowTrivia = mysqli_fetch_object($resultTrivia)){
		?>
			<div class="triviaItem">
				<div class="triviaLeft"><?php echo $rowTrivia->trivia; ?></div>
				<div class="triviaRight">
					<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/toon/trivia/edit/<?php echo $row->toonID; ?>/<?php echo $rowTrivia->triviaID; ?>';"></div>
					<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteToonTrivia/<?php echo $row->toonID; ?>/<?php echo $rowTrivia->triviaID; ?>';"></div>
					<div style="clear: both;"></div>
				</div>
				<div style="clear: both;"></div>
			</div>
		<?php } ?>
	</div>
	<div class="biography">
		<div style="float: left; font-weight: bold;">
			Biography
		</div>
		<div style="float: left; margin-left: 5px;">
			<div title="Edit" class="editBtn" onclick="editHere('bioEdit<?php echo $c; ?>');"></div>
		</div>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<span style="font-weight: normal;"><?php echo $row->description; ?></span>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<div style="display: none; width: 100%; text-align: right;" id="bioEdit<?php echo $c; ?>">
			<b>Edit the description then hit submit!</b>
			<div style="height: 4px; width: 2px; clear: both;"></div>
			<form action="/process/editToonDescription" method="POST">
				<textarea name="description" style="width: 100%"><?php echo $row->description; ?></textarea>
				<div style="height: 4px; width: 2px; clear: both;"></div>
				<input type="hidden" name="toonID" value="<?php echo $row->toonID; ?>" />
				<input type="submit" value="submit" />
			</form>
		</div>
	</div>
</div>
<div style="width: 100%; border-top: solid 1px #333; $margin-bottom: 8px;"></div>
<?php 
		$c++;
	} 
?>