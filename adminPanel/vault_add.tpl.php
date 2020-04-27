<?php
	$type = $core->args[3];
?>

<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Add a new Vault item</div><br/>
<br/>
<form enctype="multipart/form-data" action="/process/addVaultItem" method="POST">
	<table border="0">
		<tr><td><b>Name</b></td><td></td><td><input type='text' name="vname" size="30"/></td></tr>
		<tr><td><b>Order</b></td><td></td><td><input type='text' name="order" size="30"/></td></tr>
		<tr><td><b>Munniez on view</b></td><td></td><td><input type='text' name="munniezOnView" size="30"/></td></tr>
		<tr><td><b>Type</b></td><td></td><td>
			<select name="type" style="width: 206px;">
				<option value="flash" <?php if($type == 'flash') echo "SELECTED"; ?>>Flash</option>
				<option value="art" <?php if($type == 'art') echo "SELECTED"; ?>>Art</option>
				<option value="misc" <?php if($type == 'misc') echo "SELECTED"; ?>>Misc</option>
			</select>
		</td></tr>
		<tr><td><b>File</b></td><td></td><td><input type="file" name="file" size="30"/></td></tr>
		<tr><td></td><td></td><td><br/><input type="submit" value="Submit" /></td></tr>
	</table>
</form>