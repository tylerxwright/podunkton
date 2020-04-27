<?php
	global $database;
	global $core;
	
	if(isset($core->args[3])) {
		$bandID = $core->args[3];
	} else {
		$bandID = 0;
	}
	
	$result = $database->db_query("SELECT * FROM Bands ORDER BY name ASC");
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

<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Bands</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/audio/band/add';" title="Add a new band"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>
<?php
	$c = 1;
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="/admin/audio/band/<?php echo $row->bandID; ?>"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="View Details" class="slideBtn" onclick="clicked(<?php echo $c; ?>);"></div>
		<div title="Edit" class="editBtn" onclick="location='/admin/audio/band/edit/<?php echo $row->bandID; ?>';"></div>
		<div title="Delete" class="deleteBtn" onclick="location='/process/deleteBand/<?php echo $row->bandID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box<?php echo $c; ?>" class="genreDesc" <?php if($bandID == 0) {if($c==1){ echo "style='display: block;'"; }} else {if($bandID == $row->bandID){echo "style='display: block;'";}} ?>>
	<div class="albumHolder">
		<div style="float: left; font-weight: bold;">
			Band Picture
		</div>
		<div style="float: left; margin-left: 5px;">
			<div title="Edit" class="editBtn" onclick="editHere('pictureEdit<?php echo $c; ?>');"></div>
		</div>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<div style="float: left; margin-right: 20px; margin-bottom: 8px;">
			<img style="border: solid 1px #333;" src="/content/audio/bandPicture/<?php echo $row->picture; ?>" />
		</div>
		<div style="float: right; display: none; text-align: center; width: 320px;" id="pictureEdit<?php echo $c; ?>">
			<b>To change the picture, find a file and hit submit!<br/><br/>
			<form enctype="multipart/form-data" action="/process/bandEditPicture" method="POST">
				<table border="0" width="100%"><tr><td align="right">
					<input type="file" name="pic" /><br/><br/><br/>
					<input type="hidden" name="bandID" value="<?php echo $row->bandID; ?>" />
					<input type="submit" value="submit" />
				</td></tr></table>
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="albumHolder">
		<b>Albums</b><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/audio/band/album/add/<?php echo $row->bandID ?>';" title="Add a new album" src="/theme/images/icons/add.png" width="15" height="15"/>
<?php
	$resultDetail = $database->db_query("SELECT a.* FROM Albums as a JOIN Bands_has_Albums as bha ON a.albumID = bha.albumID WHERE bandID = ".$row->bandID);
	while($rowDetail = mysqli_fetch_object($resultDetail)) {
?>
		<div class="album">
			<div class="albumArt">
				<a href="/admin/audio/band/album/<?php echo $rowDetail->albumID; ?>">
					<img width="60" height="60" src="/content/audio/albumArt/<?php echo $rowDetail->coverArt; ?>" border="0" />
				</a>
			</div>
			<div class="albumEdit">
				<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/audio/band/album/<?php echo $rowDetail->albumID; ?>';"></div>
				<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteAlbum/<?php echo $rowDetail->albumID; ?>/<?php echo $row->bandID; ?>';"></div>
				<div style="clear: both;"></div>
			</div>
			<span class="albumName">
				<a href="/admin/audio/band/album/<?php echo $rowDetail->albumID; ?>">
					<?php echo $rowDetail->name; ?>
				</a>
			</span>
		</div>
		
<?php } ?>
		<div style="clear: both;"></div>
	</div>
	<div class="membersArea">
		<b>Members</b><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/audio/band/member/add/<?php echo $row->bandID; ?>';" title="Add a new member" src="/theme/images/icons/add.png" width="15" height="15"/>
		<table border="0" width="100%">
<?php
	$resultMembers = $database->db_query("SELECT u.name, u.userID, bhm.id FROM Users as u JOIN Bands_has_Members as bhm ON u.userID = bhm.userID WHERE bhm.bandID = ".$row->bandID);
	while($rowMembers = mysqli_fetch_object($resultMembers)) {
?>
			<tr class="memberRow"><td width="20%"><a href="/user/<?php echo $rowMembers->name; ?>" class="blue"><?php echo $rowMembers->name; ?></a></td><td width="70%">
			<?php 
				$count = 0;
				$resultInstruments = $database->db_query("SELECT i.name FROM Instruments as i JOIN Members_has_Instruments as mhi ON i.instrumentID = mhi.instrumentID WHERE mhi.memberID = ".$rowMembers->id);
				while($rowInstruments = mysqli_fetch_object($resultInstruments)) {
					if($count == 0) {
						echo $rowInstruments->name;
					} else {
						echo ", ".$rowInstruments->name;
					}
					$count++;
				}
			?>
			</td><td width="10%">
				<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/audio/band/member/edit/<?php echo $rowMembers->id; ?>';"></div>
				<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteMember/<?php echo $rowMembers->id; ?>';"></div>
				<div style="clear: both;"></div>
			</td></tr>
<?php } ?>
		</table>
	</div>
	<div class="biography">
		<div style="float: left; font-weight: bold;">
			Biography
		</div>
		<div style="float: left; margin-left: 5px;">
			<div title="Edit" class="editBtn" onclick="editHere('bioEdit<?php echo $c; ?>');"></div>
		</div>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<span style="font-weight: normal;"><?php echo $row->biography; ?></span>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<div style="display: none; width: 100%; text-align: right;" id="bioEdit<?php echo $c; ?>">
			<b>Edit the bio then hit submit!</b>
			<div style="height: 4px; width: 2px; clear: both;"></div>
			<form action="/process/bandBioEdit" method="POST">
				<textarea name="bio" style="width: 100%"><?php echo $row->biography; ?></textarea>
				<div style="height: 4px; width: 2px; clear: both;"></div>
				<input type="hidden" name="bandID" value="<?php echo $row->bandID; ?>" />
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