<?php
	$c = 1;
	$safeName = $core->args[2];
	$result = $database->db_query("SELECT tt.trivia FROM Toons_Trivia as tt WHERE tt.toonID = (SELECT t.toonID FROM Toons as t WHERE t.safeName = '$safeName')");
?>
<span style="font-size: 8pt;">
<h2>Trivia</h2>
<a class="blue" href="/toons/view/<?php echo $safeName; ?>">Back to the toon</a>
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