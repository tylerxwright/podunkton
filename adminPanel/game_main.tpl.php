<?php
	global $core;
	global $database;
	
	if(isset($core->args[2])) {
		$gameID = $core->args[2];
	} else {
		$gameID = 0;
	}
	
	$result = $database->db_query("SELECT * FROM Games ORDER BY releaseDate DESC");
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

<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Games</div>
<div style="float: left; margin-left: 8px; cursor: pointer;" onclick="location='/admin/game/add';" title="Add a new game"><img src="/theme/images/icons/add.png" /></div>
<div style="clear: both; margin-bottom: 8px;"></div>

<?php
	$c = 1;
	while($row = mysqli_fetch_object($result)) {
?>
<div class="genreBar">
	<div class="genreName"><a class="white" href="#"><?php echo $row->name; ?></a></div>
	<div class="genreRight">
		<div title="View Details" class="slideBtn" onclick="clicked(<?php echo $c; ?>);"></div>
		<div title="Edit" class="editBtn" onclick="location='/admin/game/edit/<?php echo $row->gameID; ?>';"></div>
		<div title="Delete" class="deleteBtn" onclick="location='/process/deleteGame/<?php echo $row->gameID; ?>';"></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box<?php echo $c; ?>" class="genreDesc" <?php if($toonID == 0) {if($c==1){ echo "style='display: block;'"; }} else {if($gameID == $row->gameID){echo "style='display: block;'";}} ?>>
	<div class="albumHolder">
		<div style="float: left; font-weight: bold;">
			Game Picture
		</div>
		<div style="float: left; margin-left: 5px;">
			<div title="Edit" class="editBtn" onclick="editHere('pictureEdit<?php echo $c; ?>');"></div>
		</div>
		<div style="height: 4px; width: 2px; clear: both;"></div>
		<div style="float: left; margin-right: 20px; margin-bottom: 8px;">
			<img style="border: solid 1px #333;" src="/content/games/images/<?php echo $row->icon; ?>" />
		</div>
		<div style="float: right; display: none; text-align: center; width: 320px;" id="pictureEdit<?php echo $c; ?>">
			<b>To change the picture, find a file and hit submit!</b><br/><br/>
			<form enctype="multipart/form-data" action="/process/editGameIcon" method="POST">
				<table border="0" width="100%"><tr><td align="right">
					<input type="file" name="icon" /><br/><br/><br/>
					<input type="hidden" name="gameID" value="<?php echo $row->gameID; ?>" />
					<input type="submit" value="submit" />
				</td></tr></table>
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="albumHolder">
		<b>General Information</b>
		<table border="0">
			<tr><td><b>Release Date: </b></td><td><?php echo $row->releaseDate; ?></td><tr>
			<tr><td><b>Newgrounds Link: </b></td><td><a href="<?php echo $row->ngLink; ?>"><?php echo $row->ngLink; ?></a></td><tr>
			<tr><td><b>File Size: </b></td><td><?php echo $row->fileSize; ?> MB</td><tr>
			<tr><td><b>View SWF: </b></td><td><a href="/content/games/swfs/<?php echo $row->swf; ?>"><?php echo $row->swf; ?></a></td><tr>
			<tr><td><b>Frame Size: </b></td><td><?php echo $row->frameSize; ?></td><tr>
			<tr><td><b>Munniez: </b></td><td><?php echo $row->munniez; ?></td><tr>
			<tr><td><b>Credits: </b></td><td><?php echo $row->credits; ?></td><tr>
			<tr><td><b>Munniez On View: </b></td><td><?php echo $row->munniezOnView; ?></td><tr>
		</table>
	</div>
	<div class="membersArea">
		<b>Cast Members</b><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/game/cast/add/<?php echo $row->gameID; ?>';" title="Add a new cast member" src="/theme/images/icons/add.png" width="15" height="15"/>
		<table border="0" width="100%">
<?php
	$resultMembers = $database->db_query("SELECT u.name, u.userID, thc.id FROM Users as u JOIN Games_has_Cast as thc ON u.userID = thc.userID WHERE thc.gameID = ".$row->gameID);
	while($rowMembers = mysqli_fetch_object($resultMembers)) {
?>
			<tr class="memberRow"><td width="20%"><a href="/user/<?php echo $rowMembers->name; ?>" class="blue"><?php echo $rowMembers->name; ?></a></td><td width="70%">
			</td><td width="10%">
				<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/game/cast/edit/<?php echo $row->gameID; ?>/<?php echo $rowMembers->id; ?>';"></div>
				<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteGameCastMember/<?php echo $row->gameID; ?>/<?php echo $rowMembers->id; ?>';"></div>
				<div style="clear: both;"></div>
			</td></tr>
<?php } ?>
		</table>
	</div>
	<div class="membersArea">
		<b>Trivia</b><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/game/trivia/add/<?php echo $row->gameID; ?>';" title="Add a new cast member" src="/theme/images/icons/add.png" width="15" height="15"/>
		<div style="height: 6px; width: 5px;"></div>
		<?php
			$resultTrivia = $database->db_query("SELECT * FROM Games_Trivia WHERE gameID = ".$row->gameID." ORDER BY triviaOrder ASC");
			while($rowTrivia = mysqli_fetch_object($resultTrivia)){
		?>
			<div class="triviaItem">
				<div class="triviaLeft"><?php echo $rowTrivia->trivia; ?></div>
				<div class="triviaRight">
					<div title="Edit" class="editBtn" style="float: left;" onclick="location='/admin/game/trivia/edit/<?php echo $row->gameID; ?>/<?php echo $rowTrivia->triviaID; ?>';"></div>
					<div title="Delete" class="deleteBtn" style="float: right;" onclick="location='/process/deleteGameTrivia/<?php echo $row->gameID; ?>/<?php echo $rowTrivia->triviaID; ?>';"></div>
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
			<form action="/process/editGameDescription" method="POST">
				<textarea name="description" style="width: 100%"><?php echo $row->description; ?></textarea>
				<div style="height: 4px; width: 2px; clear: both;"></div>
				<input type="hidden" name="gameID" value="<?php echo $row->gameID; ?>" />
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