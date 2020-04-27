<?php
	global $core;
	global $database;
	
	$id = $core->args[5];
	
	$result = $database->db_query("SELECT bhm.id, u.name, b.name as 'bname', b.bandID FROM Users as u JOIN Bands_has_Members as bhm ON bhm.userID = u.userID JOIN Bands as b ON bhm.bandID = b.bandID WHERE bhm.id = $id");
	$row = mysqli_fetch_object($result);
?>
<script type="text/javascript">
	
	var nameArr = new Array();
	var idArr = new Array();
	
	function addInstrument() {
		numInstruments++;
		var instrumentList = document.getElementById("instrumentList");
		var instrumentSelect = document.getElementById("instrumentSelect");
		var options = instrumentSelect.options[instrumentSelect.selectedIndex];
		if(numInstruments == 1) {
			instrumentList.innerHTML = "<a class='blue' href='#' onclick='removeInstrument("+(numInstruments)+");return false;'>"+ options.innerHTML+"</a><input type='hidden' name='instrument"+numInstruments+"' value='"+options.value+"' />";
		} else {
			instrumentList.innerHTML += ", <a class='blue' href='#' onclick='removeInstrument("+(numInstruments)+");return false;'>"+ options.innerHTML+"</a><input type='hidden' name='instrument"+numInstruments+"' value='"+options.value+"' />";
		}
		nameArr.push(options.innerHTML);
		idArr.push(options.value);
	}
	
	function removeInstrument(i) {
		var leftNameArr = new Array();
		var rightNameArr = new Array();
		var leftIdArr = new Array();
		var rightIdArr = new Array();
		
		for(var x=0; x<i-1; x++) {
			leftNameArr.push(nameArr[x]);
			leftIdArr.push(idArr[x]);
		}
		
		for(var x=i; x<nameArr.length; x++) {
			rightNameArr.push(nameArr[x]);
			rightIdArr.push(idArr[x]);
		}
		
		var instrumentList = document.getElementById("instrumentList");
		nameArr = leftNameArr.concat(rightNameArr);
		idArr = leftIdArr.concat(rightIdArr);
		
		if(numInstruments > 1) {
			for(var c=0; c<nameArr.length; c++) {
				if(c == 0) {
					instrumentList.innerHTML = "<a class='blue' href='#' onclick='removeInstrument("+(c+1)+");return false;'>"+nameArr[c]+"</a><input type='hidden' name='instrument"+(c+1)+"' value='"+idArr[c]+"' />";
				} else {
					instrumentList.innerHTML += ", <a class='blue' href='#' onclick='removeInstrument("+(c+1)+");return false;'>"+nameArr[c]+"</a><input type='hidden' name='instrument"+(c+1)+"' value='"+idArr[c]+"' />";
				}
			}
		} else {
			instrumentList.innerHTML = "";
		}
		
		numInstruments--;
	}
	
</script>
<h2>Editting <?php echo $row->name; ?> for the band <?php echo $row->bname; ?></h2>
<form action="/process/editMember" method="POST">
	<table border="0" width="100%">
		<tr><td width="20%"><b>General</b></td><td width="80%"></td></tr>
		<tr><td>Name: </td><td><input class="adminInput2" name="mname" value="<?php echo $row->name; ?>" /></td></tr>
		<tr><td><div style="height: 8px; width: 20px;"></td><td></td></tr>
		<tr><td><b>Instruments</b></td><td></td></tr>
		<tr><td>
			<select name="instruments" id="instrumentSelect">
		<?php
			$result2 = $database->db_query("SELECT instrumentID, name FROM Instruments ORDER BY name ASC");
			while($row2 = mysqli_fetch_object($result2)) {
		?>
			<option value="<?php echo $row2->instrumentID; ?>"><?php echo $row2->name; ?></option>
		<?php } ?>
			</select>
		</td><td><input type="button" onclick="addInstrument();return false;" value="Add"></td></tr>
		<tr><td valign="top">Current: </td><td id="instrumentList" style="border: solid 1px #333; font-size: 8pt; padding: 5px; height: 25px;">
		<?php
			$c = 1;
			$result3 = $database->db_query("SELECT i.instrumentID, i.name FROM Instruments as i JOIN Members_has_Instruments as mhi ON mhi.instrumentID = i.instrumentID WHERE mhi.memberID = $id");
			while($row3 = mysqli_fetch_object($result3)) {
		?>
				<script type="text/javascript">nameArr.push("<?php echo $row3->name; ?>");idArr.push(<?php echo $row3->instrumentID; ?>);</script>
		<?php	if($c == 1) {?>	
				<a class="blue" href="#" onclick="removeInstrument(<?php echo $c; ?>);return false;"><?php echo $row3->name; ?></a><input type='hidden' name='instrument<?php echo $c; ?>' value='<?php echo $row3->instrumentID; ?>' />
		<?php	} else { ?>
				, <a class="blue" href="#" onclick="removeInstrument(<?php echo $c; ?>);return false;"><?php echo $row3->name; ?></a><input type='hidden' name='instrument<?php echo $c; ?>' value='<?php echo $row3->instrumentID; ?>' />
		<?php 
				}
				$c++;
			}
		?>
		<script type="text/javascript">var numInstruments = <?php echo $c-1; ?>;</script>
		</td></tr>
		<tr><td><div style="height: 8px; width: 20px;"></td><td></td></tr>
		<tr><td></td><td align="right"><input type="submit" value="Update Member" /></td></tr>
	</table>
	<input type="hidden" name="bandID" value="<?php echo $row->bandID; ?>" />
	<input type="hidden" name="bhmID" value="<?php echo $row->id; ?>" />
</form>