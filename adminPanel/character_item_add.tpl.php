<?php
	global $core;
	global $database;
	global $session;
	global $error;
	
	$slotHolder = array();
	
	$result = $database->db_query("select slotID, mc FROM Slots");
	while($row = mysqli_fetch_object($result)){
		array_push($slotHolder, $row);
	}
?>
<style type="text/css">
th {
	font-weight: bold;
	border: none;
	font-size: 10pt;
}
</style>
<b>Add a New Item</b>
<form enctype="multipart/form-data" action="/process/addItem" method="POST">
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
		<tr><td>Cost:</td><td><input type="text" name="cost" /></td></tr>
		<tr><td>Credits:</td><td><input type="text" name="credits" /></td></tr>
		<tr><td>Grouped:</td><td><input type="checkbox" name="grouped" /></td></tr>
		<tr><td>Store:</td><td>
			<select name="store">
				<?php 
					$result = $database->db_query("SELECT storeID, name FROM Store WHERE name != 'Barber Shop'");
					while($row = mysqli_fetch_object($result)) {
				?>
					<option value="<?php echo $row->storeID; ?>"><?php echo $row->name; ?></option>
				<?php } ?>
			</select>
		</td></tr>
		<tr><td>Default:</td><td><input type="checkbox" name="isdefault" /></td></tr>
		<tr><td valign="top">Sex:</td><td><input type="radio" name="sex" value="1">Male<br/>
							<input type="radio" name="sex" value="2">Female<br/>
							</td></tr>
		<tr><td colspan="2">
			<table border="0" class="powerTable">
				<tr><th>Small Png's</th><th colspan="2"></th></tr>
				<tr><td>Level 1</td><td colspan="2"><input type="file" name="spl1" /></td></tr>
				<tr><td>Level 2</td><td colspan="2"><input type="file" name="spl2" /></td></tr>
				<tr><td>Level 3</td><td colspan="2"><input type="file" name="spl3" /></td></tr>
				<tr><td>Level 4</td><td colspan="2"><input type="file" name="spl4" /></td></tr>
				<tr><td>Level 5</td><td colspan="2"><input type="file" name="spl5" /></td></tr>
				<tr><td style="height: 20px;"></td><td colspan="2"></td></tr>
				<tr><th>Large Png's</th><th colspan="2"></th></tr>
				<tr><td>Level 1</td><td colspan="2"><input type="file" name="sll1" /></td></tr>
				<tr><td>Level 2</td><td colspan="2"><input type="file" name="sll2" /></td></tr>
				<tr><td>Level 3</td><td colspan="2"><input type="file" name="sll3" /></td></tr>
				<tr><td>Level 4</td><td colspan="2"><input type="file" name="sll4" /></td></tr>
				<tr><td>Level 5</td><td colspan="2"><input type="file" name="sll5" /></td></tr>
				<tr><td style="height: 20px;"></td><td colspan="2"></td></tr>
				<?php
					for($i=1; $i<=9; $i++){
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
				<tr><td></td><td>Level 1</td><td><input type="file" name="s<?php echo $i; ?>l1" /></td></tr>
				<tr><td></td><td>Level 2</td><td><input type="file" name="s<?php echo $i; ?>l2" /></td></tr>
				<tr><td></td><td>Level 3</td><td><input type="file" name="s<?php echo $i; ?>l3" /></td></tr>
				<tr><td></td><td>Level 4</td><td><input type="file" name="s<?php echo $i; ?>l4" /></td></tr>
				<tr><td></td><td>Level 5</td><td><input type="file" name="s<?php echo $i; ?>l5" /></td></tr>
				<tr><td style="height: 20px;"></td><td colspan="2"></td></tr>
				<?php } ?>
			</table>
		</td></tr>
		<tr><td colspan="2"><div style="height: 30px;"></div></td></tr>
		<input type="hidden" name="admin" value="1"/>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>
	