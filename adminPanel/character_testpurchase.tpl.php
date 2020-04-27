<?php
	global $core;
	global $database;
	global $session;
?>

<b>Test a Purchase</b><br/>
Click on an item to place it in your bag<br/><br/>
<table border="0">
	<tr><th width="390px">Your Bag (click to remove)</th><th width="390px">All Items(click to add)</th></tr>
	<tr><td valign="top">
		<?php
			$user = $session->user;
			$result = $database->db_query("select ui.id, i.itemID, i.name, iswf.pngSmall FROM Users_has_Items as ui JOIN Items as i ON i.itemID = ui.itemID_FK JOIN ItemSWF as iswf ON ui.swfID = iswf.itemswfID WHERE ui.userID_FK = $user AND i.groups = 0");
			while($row = mysqli_fetch_object($result)){
		?>
			<a href="/process/removeFromBag/<?php echo $row->id; ?>/<?php echo $row->itemID; ?>">
				<div class="thisItem">
					<div class="itemPNG"><img src="/characterBuilder/images/<?php echo $row->pngSmall; ?>" /></div>
					<div class="itemName"><?php echo $row->name; ?></div>
					<div style="clear: both;"></div>
				</div>
			</a>
		<?php
			}
		?>
	</td><td valign="top">
		<?php
			$result = $database->db_query("SELECT DISTINCT i.itemID, i.name, i.png FROM Items as i JOIN Items_has_Slots as ihs ON ihs.itemID = i.itemID JOIN Slots as s ON ihs.slotID = s.slotID  WHERE i.groups = 0 ORDER BY i.itemID DESC");
			while($row = mysqli_fetch_object($result)){
		?>
			<a href="/process/addToBag/<?php echo $row->itemID; ?>">
				<div class="thisItem">
					<div class="itemPNG"><img src="/characterBuilder/images/<?php echo $row->png; ?>" /></div>
					<div class="itemName"><?php echo $row->name; ?></div>
					<div style="clear: both;"></div>
				</div>
			</a>
		<?php
			}
		?>
	</td></tr>
</table>
