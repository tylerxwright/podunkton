<?php
	global $session;
	global $database;
	global $core;
?>
<div id="beta_users_head">
	<img src="/theme/images/beta_users_head.png" />
</div>
<div style="height: 8px; width: 792px;"></div>
<div class="site_box" style="width: 787px;">
	<div class="site_box_head">
		<div class="front_title">CITIZEN SEARCH (BETA)</div>
	</div>
	<div class="site_box_content" style="background-color: #fff;">
		<div class="site_box_content_inner" style="width: 624px;">
			<table border="0" width="782">
			<?php
				$count = 0;
				$result = $database->db_query("SELECT name FROM Users WHERE password != ''");
				while($row = mysqli_fetch_object($result)) {
					if($count%4 == 0) { echo "<tr>"; }
			?>
					<td width="25%"><a class="blue" href="/user/<?php echo $row->name; ?>"><?php echo $row->name; ?></a></td>
			<?php
					if($count%4 == 3) { echo "</tr>"; }
					$count++;
				}
			?>
			</table>
		</div>
	</div>
</div>
<div style="height: 20px; width: 792px;"></div>