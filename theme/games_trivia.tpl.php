<?php
	$c = 1;
	$safeName = $core->args[1];
	$result = $database->db_query("SELECT tt.trivia FROM Games_Trivia as tt WHERE tt.gameID = (SELECT t.gameID FROM Games as t WHERE t.safeName = '$safeName')");
?>
<span style="font-size: 8pt;">
<h2>Trivia</h2>
<a class="blue" href="/games/<?php echo $safeName; ?>">Back to the game</a>
<table border="0">
<?php while($row = mysqli_fetch_object($result)) { ?>
	<tr><td valign="top"><?php echo $c; ?>.</td><td><?php echo $row->trivia; ?></td></tr>
	<tr><td colspan="2"><div style="height: 8px; width: 100%; line-height: 1px; font-size: 1px;"></div></td></tr>
<?php 
		$c++;
	} 
?>
</table>
</span>