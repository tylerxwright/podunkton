<?php
	global $core;
	global $database;
	global $session;
	global $error;
	
	$slotHolder = array();
	
	$itemID = $core->args[3];
	$sex = $core->args[4];
	$levels = $core->args[5];
	$slots = $core->args[6];
	
	$result = $database->db_query("select slotID, mc FROM Slots");
	while($row = mysqli_fetch_object($result)){
		array_push($slotHolder, $row);
	}
?>
<b>Add an Item to the group</b><br/>
<span id="warning">WARNING: LEAVING THIS PAGE WITHOUT SUBMITTING WILL CAUSE YOUR ITEM TO NOT BE GROUPED!</span>
<form enctype="multipart/form-data" action="/process/addGroupItem" method="POST">
	<table border="0">
		<tr><td>Name:</td><td><input type="text" name="name" /></td></tr>
		<tr><td valign="top">Description:</td><td><textarea name="description"></textarea></span></td></tr>
		<tr><td>Type:</td><td><select name="type">
				<option value="head">head</option>
				<option value="tops">tops</option>
				<option value="bottoms">bottoms</option>
				<option value="shoes">shoes</option>
				<option value="arms">arms</option>
				<option value="items">items</option>
			</select></tr>
		<tr><td colspan="2">
			<table border="0" class="powerTable">
				<tr><th>Small Png's</th><th colspan="2"></th></tr>
				<?php for($i=1; $i<=$levels; $i++){ ?>
					<tr><td>Level <?php echo $i; ?></td><td colspan="2"><input type="file" name="spl<?php echo $i; ?>" /></td></tr>
				<?php } ?>
				<tr><td style="height: 20px;"></td><td colspan="2"></td></tr>
				<tr><th>Large Png's</th><th colspan="2"></th></tr>
				<?php for($i=1; $i<=$levels; $i++){ ?>
					<tr><td>Level <?php echo $i; ?></td><td colspan="2"><input type="file" name="sll<?php echo $i; ?>" /></td></tr>
				<?php } ?>
				<tr><td style="height: 20px;"></td><td colspan="2"></td></tr>
				<?php
					for($i=1; $i<=$slots; $i++){
				?>
				<tr><th>Slot <?php echo $i; ?></th><td>Type</td><td><select style="width: 220px;" name='slot<?php echo $i; ?>'><option value="none"></option>
						<?php
							$result = $database->db_query("select slotID, mc FROM Slots");
							foreach($slotHolder as $slot){
						?>
							<option value='<?php echo $slot->slotID; ?>'><?php echo $slot->mc; ?></option>
						<?php
							}
						?>
					</select></td></tr>
				<?php for($j=1; $j<=$levels; $j++){ ?>
					<tr><td></td><td>Level <?php echo $j; ?></td><td><input type="file" name="s<?php echo $i; ?>l<?php echo $j; ?>" /></td></tr>
				<?php } ?>
				<tr><td style="height: 20px;"></td><td colspan="2"></td></tr>
				<?php } ?>
			</table>
		</td></tr>
		<tr><td colspan="2"><div style="height: 30px;"></div></td></tr>
		<input type="hidden" name="itemID" value="<?php echo $itemID; ?>"/>
		<input type="hidden" name="sex" value="<?php echo $sex; ?>"/>
		<input type="hidden" name="levels" value="<?php echo $levels; ?>"/>
		<input type="hidden" name="slots" value="<?php echo $slots; ?>"/>
		<input type="hidden" name="admin" value="1"/>
		<tr><td><input type="submit" name="save" value="Save Item" /></td><td><input type="submit" name="groupme" value="Save and Add Another Grouped Item" /></td></tr>
	</table>
</form>