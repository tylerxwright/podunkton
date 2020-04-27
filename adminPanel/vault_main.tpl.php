
<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">The Vault</div><br/>
<table border="0" width="100%" style="border: solid 1px; #333;" cellspacing="0">
	<tr>
		<td class="colH">
			Flash<img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/vault/add/flash';" title="Add a new flash item" src="/theme/images/icons/add.png" width="15" height="15"/>
		</td>
		<td class="colH">
			Art<img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/vault/add/art';" title="Add a new art item" src="/theme/images/icons/add.png" width="15" height="15"/>
		</td>
		<td class="colH">
			Misc.<img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/vault/add/misc';" title="Add a new misc item" src="/theme/images/icons/add.png" width="15" height="15"/>
		</td>
	</tr>
	<tr valign="top">
		<td class="col">
			<?php
				$result = $database->db_query("SELECT vaultID, name, file FROM Vault WHERE type='flash' ORDER BY sortOrder ASC");
				while($row = mysqli_fetch_object($result)){
			?>
			<div class="itemRow">
				<div class="rowLeft"><a href="/content/vault/<?php echo $row->file; ?>"><?php echo $row->name; ?></a></div>
				<div class="rowRight">
					<div title="Edit" class="editBtn" onclick="location='/admin/vault/edit/<?php echo $row->vaultID; ?>';"></div>
					<div title="Delete" class="deleteBtn" onclick="location='/process/deleteVaultItem/<?php echo $row->vaultID; ?>';"></div>
					<div style="clear: both;"></div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<?php } ?>
		</td>
		<td class="col">
			<?php
				$result = $database->db_query("SELECT vaultID, name, file FROM Vault WHERE type='art' ORDER BY sortOrder ASC");
				while($row = mysqli_fetch_object($result)){
			?>
			<div class="itemRow">
				<div class="rowLeft"><a href="/content/vault/<?php echo $row->file; ?>"><?php echo $row->name; ?></a></div>
				<div class="rowRight">
					<div title="Edit" class="editBtn" onclick="location='/admin/vault/edit/<?php echo $row->vaultID; ?>';"></div>
					<div title="Delete" class="deleteBtn" onclick="location='/process/deleteVaultItem/<?php echo $row->vaultID; ?>';"></div>
					<div style="clear: both;"></div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<?php } ?>
		</td>
		<td class="col">
			<?php
				$result = $database->db_query("SELECT vaultID, name, file FROM Vault WHERE type='misc' ORDER BY sortOrder ASC");
				while($row = mysqli_fetch_object($result)){
			?>
			<div class="itemRow">
				<div class="rowLeft"><a href="/content/vault/<?php echo $row->file; ?>"><?php echo $row->name; ?></a></div>
				<div class="rowRight">
					<div title="Edit" class="editBtn" onclick="location='/admin/vault/edit/<?php echo $row->vaultID; ?>';"></div>
					<div title="Delete" class="deleteBtn" onclick="location='/process/deleteVaultItem/<?php echo $row->vaultID; ?>';"></div>
					<div style="clear: both;"></div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<?php } ?>
		</td>
	</tr>
</table>