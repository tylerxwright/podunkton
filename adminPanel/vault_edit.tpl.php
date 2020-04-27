<?php
	$vaultID = $core->args[3];
	$result = $database->db_query("SELECT * FROM Vault WHERE vaultID = $vaultID");
	$row = mysqli_fetch_object($result);
?>

<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Editting <?php echo $row->name; ?></div><br/>
<br/>
<form enctype="multipart/form-data" action="/process/editVaultItem" method="POST">
	<table border="0">
		<tr><td><b>Name</b></td><td></td><td><input type='text' name="vname" value="<?php echo $row->name; ?>" size="30"/></td></tr>
		<tr><td><b>Order</b></td><td></td><td><input type='text' name="order" value="<?php echo $row->sortOrder; ?>" size="30"/></td></tr>
		<tr><td><b>Munniez on view</b></td><td></td><td><input type='text' name="munniezOnView" value="<?php echo $row->munniezOnView; ?>" size="30"/></td></tr>
		<tr><td><b>Type</b></td><td></td><td>
			<select name="type" style="width: 206px;">
				<option value="flash" <?php if($row->type == 'flash') echo "SELECTED"; ?>>Flash</option>
				<option value="art" <?php if($row->type == 'art') echo "SELECTED"; ?>>Art</option>
				<option value="misc" <?php if($row->type == 'misc') echo "SELECTED"; ?>>Misc</option>
			</select>
		</td></tr>
		<tr><td><b>File</b></td><td></td><td><input type="file" name="file" size="30"/></td></tr>
		<tr><td></td><td></td><td valign="top"><span style="font-size: 8pt;">(leave blank to keep current file)</span></td></tr>
		<tr><td></td><td></td><td><br/><input type="submit" value="Submit" /></td></tr>
	</table>
	<input type="hidden" name="vaultID" value="<?php echo $vaultID; ?>" />
</form>