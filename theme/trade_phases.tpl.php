<?php
	global $core;
	global $database;
	
	$user = $session->user;
?>
<div id="trade_top">
	<div id="trade_top_left">
		<img src="/theme/images/trade_sign.png" />
	</div>
	<div id="trade_top_right">
		<a class="blue" href="/community">Back to Community Home</a>
	</div>
	<div style="clear: both;"></div>
</div>
 <div id="trade_content">
	<div id="trade_directions">
		Trades work in phases. As you progress through the process, the trade will enter a phase until completed. Start a trade below.
	</div>
	<div id="trade_start_box">
		<div id="trade_start_box_left">
			<form action="/process/startTrade" method="POST">
				<div id="trade_uname_submit"><input type="submit" name="submit" value="START A TRADE!" /></div>
				<div id="trade_uname_input"><input id="trade_input" type="text" name="uname" /></div>
				<div id="trade_username">Username:</div>
				<div style="clear: both;"></div>
			</form>
		</div>
		<div id="trade_start_box_right">
			<a class="blue" href="#">SEARCH FOR USERS TO TRADE WITH!</a>
		</div>
		<div style="clear: both;"></div>
	</div>
	<!--<div style="width: 752px; height: 8px; margin: 0px; padding: 0px;"></div>-->
	<div class="trade_phase_box" style="margin-top: 8px;">
		<img src="/theme/images/phase1.png" />
		<div class="trade_phase_top">Offers waiting on your action</div>
		<div class="trade_phase_box_inner">
			<div class="trade_phase_row">
				<table border="0">
					<?php 
						$x = 0;
						$result = $database->db_query("SELECT t.leftUser, t.rightUser, t.tradeID, uht.phase FROM User_has_Trades as uht JOIN Trades as t ON t.tradeID = uht.tradeID WHERE uht.userID = $user AND phase = 1");
						while($row = mysqli_fetch_object($result)) {
							if($row->leftUser = $user) {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->rightUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							} else {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->leftUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							}
					?>
						<tr><td width="43"><div class="trade_icon"><?php echo $podunkton->imageAvatar($rowU->userID, $rowU->sex, 43, $x, "phase1Avatar"); ?></div></td><td width="100" style="padding-left: 8px;"><a class="grey" href="/trade/<?php echo $row->tradeID; ?>"><?php echo $name; ?></a></td><td><a href="/process/cancelTrade/<?php echo $row->tradeID; ?>"><img src="/theme/images/phase_x.png" /></a></td></tr>
					<?php
							$x++; 
						} 
					?>
				</table>
			</div>
		</div>
	</div>
	<div class="trade_phase_box" style="margin-top: 8px;">
		<img src="/theme/images/phase2.png" />
		<div class="trade_phase_top">Offers waiting on their action</div>
		<div class="trade_phase_box_inner">
			<div class="trade_phase_row">
				<table border="0">
					<?php 
						$x = 0;
						$result = $database->db_query("SELECT t.leftUser, t.rightUser, t.tradeID, uht.phase FROM User_has_Trades as uht JOIN Trades as t ON t.tradeID = uht.tradeID WHERE uht.userID = $user AND phase = 2");
						while($row = mysqli_fetch_object($result)) {
							if($row->leftUser == $user) {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->rightUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							} else {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->leftUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							}
					?>
						<tr><td width="43"><div class="trade_icon"><?php echo $podunkton->imageAvatar($rowU->userID, $rowU->sex, 43, $x, "phase2Avatar"); ?></div></td><td width="100" style="padding-left: 8px;"><a class="grey" href="/trade/<?php echo $row->tradeID; ?>"><?php echo $name; ?></a></td><td><a href="/process/cancelTrade/<?php echo $row->tradeID; ?>"><img src="/theme/images/phase_x.png" /></a></td></tr>
					<?php
							$x++; 
						} 
					?>
				</table>
			</div>
		</div>
	</div>
	<div class="trade_phase_box" style="margin-top: 8px;">
		<img src="/theme/images/phase3.png" />
		<div class="trade_phase_top">Make changes or confirm trades</div>
		<div class="trade_phase_box_inner">
			<div class="trade_phase_row">
				<table border="0">
					<?php 
						$x = 0;
						$result = $database->db_query("SELECT t.leftUser, t.rightUser, t.tradeID, uht.phase FROM User_has_Trades as uht JOIN Trades as t ON t.tradeID = uht.tradeID WHERE uht.userID = $user AND phase = 3");
						while($row = mysqli_fetch_object($result)) {
							if($row->leftUser == $user) {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->rightUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							} else {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->leftUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							}
					?>
						<tr><td width="43"><div class="trade_icon"><?php echo $podunkton->imageAvatar($rowU->userID, $rowU->sex, 43, $x, "phase3Avatar"); ?></div></td><td width="100" style="padding-left: 8px;"><a class="grey" href="/trade/<?php echo $row->tradeID; ?>"><?php echo $name; ?></a></td><td><a href="/process/cancelTrade/<?php echo $row->tradeID; ?>"><img src="/theme/images/phase_x.png" /></a></td></tr>
					<?php
							$x++; 
						} 
					?>
				</table>
			</div>
		</div>
	</div>
	<div class="trade_phase_box" style="width: 187px; margin-top: 8px;">
		<img src="/theme/images/phase4.png" />
		<div class="trade_phase_top" style="border-right: solid 1px #B6C5EA; width: 185px;">Completed Trades</div>
		<div class="trade_phase_box_inner" style="border-right: solid 1px #B6C5EA;">
			<div class="trade_phase_row">
				<table border="0">
					<?php 
						$x = 0;
						$result = $database->db_query("SELECT t.leftUser, t.rightUser, t.tradeID, uht.phase, t.datecompleted FROM User_has_Trades as uht JOIN Trades as t ON t.tradeID = uht.tradeID WHERE uht.userID = $user AND phase = 4 ORDER BY datecompleted LIMIT 0, 8");
						while($row = mysqli_fetch_object($result)) {
							if($row->leftUser == $user) {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->rightUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							} else {
								$result2 = $database->db_query("SELECT name, userID, sex FROM Users WHERE userID = ".$row->leftUser);
								$rowU = mysqli_fetch_object($result2);
								$name = $rowU->name;
							}
					?>
						<tr><td width="43"><div class="trade_icon"><?php echo $podunkton->imageAvatar($rowU->userID, $rowU->sex, 43, $x, "phase4Avatar"); ?></div></td><td width="100" style="padding-left: 8px;"><a class="grey" href="/user/<?php echo $name; ?>"><?php echo $name; ?></a></td><td><span style="font-size: 7pt; color: #555;"><?php echo $row->datecompleted; ?></span></a></td></tr>
					<?php
							$x++; 
						} 
					?>
				</table>
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
<div style="width: 792px; height: 16px;"></div>
<div id="forums_ad2" style="margin-bottom: 16px;">
	<img src="/theme/images/forums_ad2.png" />
</div>
<!--<div style="width: 792px; height: 16px;"></div>-->