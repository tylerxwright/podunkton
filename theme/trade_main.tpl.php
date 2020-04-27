<?php
	global $core;
	global $database;
	global $error;
	
	$user = $session->user;
	$tradeID = $core->args[1];
	
	$userSide = '';
	
if(!$user) {
	include_once("theme/errordocs/404.tpl.php");
} else {
	$result = $database->db_query("SELECT t.finalized, uht.id, uht.phase, uht.userID, uht.email, uht.credits, uht.munniez FROM Trades as t JOIN User_has_Trades as uht ON t.tradeID = uht.tradeID WHERE t.tradeID = $tradeID");
	$row1 = mysqli_fetch_object($result);
	$row2 = mysqli_fetch_object($result);
	
	if($row1->finalized == 1) {
		//echo "<div style='width: 792px; height: 500px; text-align: center;'>This trade has already been completed</div>";
		include_once("theme/errordocs/404.tpl.php");
	} else {
	
	if($user == $row1->userID) {
		$userSide = "left";
	} elseif($user == $row2->userID) {
		$userSide = "right";
	} else {
		$userSide = "fail";
	}
	
	$resultLeftUser = $database->db_query("SELECT name, sex, munniez, credits, isCrew, crewFull FROM Users WHERE userID = ".$row1->userID);
	$rowLU = mysqli_fetch_object($resultLeftUser);
	
	$resultRightUser = $database->db_query("SELECT name, sex, munniez, credits, isCrew, crewFull FROM Users WHERE userID = ".$row2->userID);
	$rowRU = mysqli_fetch_object($resultRightUser);
	
	if($userSide == "left") {
		$myID = $user;
		$mySex = $rowLU->sex;
		$myName = $rowLU->name;
		$myMunniez = $rowLU->munniez;
		$myCredits = $rowLU->credits;
		$myOfferedMunniez = $row1->munniez;
		$myOfferedCredits = $row1->credits;
		$myEmail = $row1->email;
		$myIsCrew = $rowLU->isCrew;
		$myCrewFull = $rowLU->crewFull;
		
		$theirID = $row2->userID;
		$theirSex = $rowRU->sex;
		$theirName = $rowRU->name;
		$theirOfferedMunniez = $row2->munniez;
		$theirOfferedCredits = $row2->credits;
		$theirIsCrew = $rowRU->isCrew;
		$theirCrewFull = $rowRU->crewFull;
	} else {
		$myID = $user;
		$mySex = $rowRU->sex;
		$myName = $rowRU->name;
		$myMunniez = $rowRU->munniez;
		$myCredits = $rowRU->credits;
		$myOfferedMunniez = $row2->munniez;
		$myOfferedCredits = $row2->credits;
		$myEmail = $row2->email;
		$myIsCrew = $rowRU->isCrew;
		$myCrewFull = $rowRU->crewFull;
		
		$theirID = $row1->userID;
		$theirSex = $rowLU->sex;
		$theirName = $rowLU->name;
		$theirOfferedMunniez = $row1->munniez;
		$theirOfferedCredits = $row1->credits;
		$theirIsCrew = $rowLU->isCrew;
		$theirCrewFull = $rowLU->crewFull;
	}
?>

<script type="text/javascript">
	
	var inventoryItems = new Array();
	var myTradeItems = new Array();
	var theirTradeItems = new Array();
	
	var myInventoryItemsCount = 0;
	var myTradeItemsCount = 0;
	var theirTradeItemsCount = 0;
	
	function addItem(index) {
		var tmp = new Array(inventoryItems[index][0], inventoryItems[index][1], inventoryItems[index][2], inventoryItems[index][3]);
		myTradeItems.push(tmp);
		
		mycontainer = document.getElementById("trade_items_container");
		mycontainer.innerHTML += "<img style='cursor: pointer;' src='/characterBuilder/images/"+inventoryItems[index][2]+"' title='"+inventoryItems[index][3]+"' onclick='removeItem("+(myTradeItems.length-1)+");' /><input type='hidden' name='leftID"+myTradeItemsCount+"' value='"+inventoryItems[index][0]+"' />";
		
		myTradeItemsCount++;
		myInventoryItemsCount--;
		
		var leftSide = new Array();
		var length = inventoryItems.length;
		for(i=0; i<length; i++){
			if(i != index) {
				leftSide[i] = inventoryItems.shift();
			} else {
				var trash = new Array();
				trash[0] = inventoryItems.shift();
				inventoryItems = leftSide.concat(inventoryItems);
				break;
			}
		}
		
		var str = '';
		//myInventory = document.getElementById("myInventory");
		
		for(i=0; i<inventoryItems.length; i++){
			str += "<img style='cursor: pointer;' src='/characterBuilder/images/"+inventoryItems[i][2]+"' title='"+inventoryItems[i][3]+"' onclick='addItem("+i+");' /><input type='hidden' name='myInventoryItem"+i+"' value='"+inventoryItems[i][0]+"' />";
		}
		
		document.getElementById("myInventory").innerHTML = str;
	}
	
	function removeItem(index) {
		var tmp = new Array(myTradeItems[index][0], myTradeItems[index][1], myTradeItems[index][2], myTradeItems[index][3]);
		inventoryItems.push(tmp);
						
		//myInventory = document.getElementById("myInventory");
		document.getElementById("myInventory").innerHTML += "<img style='cursor: pointer;' src='/characterBuilder/images/"+myTradeItems[index][2]+"' title='"+myTradeItems[index][3]+"' onclick='addItem("+(inventoryItems.length-1)+");' /><input type='hidden' name='myInventoryItem"+myInventoryItemsCount+"' value='"+myTradeItems[index][0]+"' />";
		
		myTradeItemsCount--;
		myInventoryItemsCount++;
		
		var leftSide = new Array();
		var length = myTradeItems.length;
		for(i=0; i<length; i++){
			if(i != index) {
				leftSide[i] = myTradeItems.shift();
			} else {
				var trash = new Array();
				trash[0] = myTradeItems.shift();
				myTradeItems = leftSide.concat(myTradeItems);
				break;
			}
		}
		
		var str = '';
		mycontainer = document.getElementById("trade_items_container");
		
		for(i=0; i<myTradeItems.length; i++){
			str += "<img style='cursor: pointer;' src='/characterBuilder/images/"+myTradeItems[i][2]+"' title='"+myTradeItems[i][3]+"' onclick='removeItem("+i+");' /><input type='hidden' name='leftID"+i+"' value='"+myTradeItems[i][0]+"' />";
		}
		
		mycontainer.innerHTML = str;
	}
	
</script>

<div id="trade_top">
	<div id="trade_top_left">
		<img src="/theme/images/trade_sign.png" />
	</div>
	<div id="trade_top_right">
		<a class="blue" href="/trade">Back to Trades</a><br/>
		<form name="cancel_trade" action="/process/cancelTrade/<?php echo $tradeID; ?>" method="POST" style="margin: 0px; padding: 0px;">
			<img id="trade_cancel" src="/theme/images/cancel_trade.png" onclick="document.cancel_trade.submit();" />
		</form>
	</div>
	<div style="clear: both;"></div>
</div>
<form name="tradeForm" action="/process/sendTrade/<?php echo $tradeID; ?>" method="POST" style="margin: 0px; padding: 0px;">
<div id="trade_message">
	<div style="float: left; padding-top: 4px; padding-right: 8px;">Title of Trade Message:</div>
	<div style="float: left; padding-right: 20px;"><input style="width: 400px;" type="text" name="message" /></div>
	<div style="float: left; padding-top: 2px;"><input type="checkbox" name="emailMe" <?php if($myEmail == 1) { echo "CHECKED"; } ?> /></div>
	<div style="float: left; font-size: 7pt; padding-top: 5px; padding-left: 4px;">Send a notification to my email</div>
	<div style="clear: both;"></div>
</div>

<div class="trade_box" style="padding-left: 8px;">
	<div class="trade_top_left"></div>
	<div class="trade_top_right"></div>
	<div style="clear: both;"></div>
	<div class="trade_left"></div>
	<div class="trade_box_inside">
		<div class="trade_character">
			<?php if($myIsCrew == 1){ ?>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="126" height="163" id="logo" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="/characterBuilder/viewers/crewviewer.swf?uid=<?php echo $myID; ?>&dummy=<?php echo time(); ?>&crewSwf=<?php echo $myCrewFull; ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/characterBuilder/viewers/crewviewer.swf?uid=<?php echo $myID; ?>&dummy=<?php echo time(); ?>&crewSwf=<?php echo $myCrewFull; ?>" quality="high" bgcolor="#ffffff" width="126" height="163" name="logo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
			<?php } else { ?>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="126" height="163" id="logo" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="/characterBuilder/viewers/viewer_<?php echo $mySex; ?>_1.swf?uid=<?php echo $myID; ?>&dummy=<?php echo time(); ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/characterBuilder/viewers/viewer_<?php echo $mySex; ?>_1.swf?uid=<?php echo $myID; ?>&dummy=<?php echo time(); ?>" quality="high" bgcolor="#ffffff" width="126" height="163" name="logo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
			<?php } ?>
		</div>
		<div class="trade_box_top_content">
			<div class="trade_top_mid"></div>
			<div class="trade_top_right2"></div>
			<div style="clear: both;"></div>
			<div class="trade_head_box"><?php echo $myName; ?></div>
			<div class="trade_head_desc">Offer munniez or credits!</div>
			<div class="trade_info">
				<div id="trade_your_account">
					<table border="0">
					<tr><td>YOUR MUNNIEZ:</td><td width="80" align="right"><?php echo $myMunniez; ?></td></tr>
					<tr><td>YOUR CREDITS:</td><td width="80" align="right"><?php echo $myCredits; ?></td></tr>
					</table>
					<div id="trade_info_inputs">
						<input class="trade_infoi" type="text" value="<?php echo $myOfferedMunniez; ?>"name="munniez" /><br/>
						<input class="trade_infoi" type="text" value="<?php echo $myOfferedCredits; ?>"name="credits" /><br/>
					</div>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div class="trade_mid_head">
			<div class="trade_mid_head_left"><img src="/theme/images/trade/items_to_be_traded.png" style="behavior: url(/iepngfix.htc);" /></div>
			<div class="trade_mid_head_right">(select from inventory below)</div>
			<div style="clear: both;"></div>
		</div>
		<div id="trade_items_container" class="trade_box_items">
			<?php
				$resultI = $database->db_query("SELECT uhi.id, i.itemID, i.name, i.png FROM User_has_Trades as uht JOIN Trades_has_Items as thi ON uht.id = thi.utID JOIN Users_has_Items as uhi ON thi.uiID = uhi.id JOIN Items as i ON uhi.itemID_FK = i.itemID WHERE uht.tradeID = $tradeID AND uhi.userID_FK = $user ORDER BY name ASC");
				$counter = 0;
				while($rowI = mysqli_fetch_object($resultI)) {
			?>
<script type="text/javascript">
	var tmp = new Array();
	tmp.push(<?php echo $rowI->id; ?>, <?php echo $rowI->itemID; ?>, '<?php echo $rowI->png; ?>', '<?php echo $rowI->name; ?>'); 
	myTradeItems.push(tmp);
	myTradeItemsCount++;
</script>
				<img style="cursor: pointer;" src="/characterBuilder/images/<?php echo $rowI->png; ?>" title="<?php echo $rowI->name; ?>" onclick="removeItem(<?php echo $counter; ?>);" /><input type='hidden' name='leftID<?php echo $counter; ?>' value='<?php echo $rowI->id; ?>' />
			<?php 
					$counter++;
				} 
			?>
		</div>
		<div class="trade_bot_head" style="padding-top: 1px;">
			<div class="trade_bot_head_left" style="padding-left: 33px; padding-right: 5px;"><img src="/theme/images/trade/confirm_password.png" style="behavior: url(/iepngfix.htc);" /></div>
			<div class="trade_bot_head_mid">
				<input id="trade_input_pword" type="password" name="pword" style="border: solid 0px white; margin: 0px;" />
			</div>
			<div class="trade_bot_head_right">
			</div>
		</div>
		<div class="trade_bot"></div>
	</div>
	<div class="trade_right"></div>
</div>
<div id="trade_between"></div>
<div class="trade_box">
	<div class="trade_top_left"></div>
	<div class="trade_top_right"><img src="/theme/images/icon_mail.png" style="behavior: url(/iepngfix.htc);"/> <a href="/mail/compose/<?php echo $theirID; ?>" class="blue">Send them a message!</a></div>
	<div style="clear: both;"></div>
	<div class="trade_left"></div>
	<div class="trade_box_inside">
		<div class="trade_character">
			<?php if($theirIsCrew == 1){ ?>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="126" height="163" id="logo" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="/characterBuilder/viewers/crewviewer.swf?uid=<?php echo $theirID; ?>&dummy=<?php echo time(); ?>&crewSwf=<?php echo $theirCrewFull; ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/characterBuilder/viewers/crewviewer.swf?uid=<?php echo $theirID; ?>&dummy=<?php echo time(); ?>&crewSwf=<?php echo $theirCrewFull; ?>" quality="high" bgcolor="#ffffff" width="126" height="163" name="logo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
			<?php } else { ?>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="126" height="163" id="logo" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="/characterBuilder/viewers/viewer_<?php echo $theirSex; ?>_1.swf?uid=<?php echo $theirID; ?>&dummy=<?php echo time(); ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/characterBuilder/viewers/viewer_<?php echo $theirSex; ?>_1.swf?uid=<?php echo $theirID; ?>&dummy=<?php echo time(); ?>" quality="high" bgcolor="#ffffff" width="126" height="163" name="logo" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
			<?php } ?>
		</div>
		<div class="trade_box_top_content">
			<div class="trade_top_mid"></div>
			<div class="trade_top_right2"></div>
			<div style="clear: both;"></div>
			<div class="trade_head_box"><?php echo $theirName; ?></div>
			<div class="trade_head_desc">Munniez and credits offered!</div>
			<div class="trade_info2">
				<div id="trade_their_account">
						<?php echo $theirOfferedMunniez; ?>
					<div style="height: 22px;"></div>
						<?php echo $theirOfferedCredits; ?>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div class="trade_mid_head">
			<div class="trade_mid_head_left"><img src="/theme/images/trade/items_to_be_traded.png" style="behavior: url(/iepngfix.htc);" /></div>
			<div class="trade_mid_head_right">(items below being offered)</div>
			<div style="clear: both;"></div>
		</div>
		<div class="trade_box_items">
			<?php
				$resultI = $database->db_query("SELECT uhi.id, i.itemID, i.name, i.png FROM User_has_Trades as uht JOIN Trades_has_Items as thi ON uht.id = thi.utID JOIN Users_has_Items as uhi ON thi.uiID = uhi.id JOIN Items as i ON uhi.itemID_FK = i.itemID WHERE uht.tradeID = $tradeID AND uhi.userID_FK = $theirID ORDER BY name ASC");
				$counter = 0;
				while($rowI = mysqli_fetch_object($resultI)) {
			?>
<script type="text/javascript">
	var tmp = new Array();
	tmp.push(<?php echo $rowI->id; ?>, <?php echo $rowI->itemID; ?>, '<?php echo $rowI->png; ?>', '<?php echo $rowI->name; ?>'); 
	theirTradeItems.push(tmp);
	theirTradeItemsCount++;
</script>
				<img src="/characterBuilder/images/<?php echo $rowI->png; ?>" title="<?php echo $rowI->name; ?>" />
			<?php 
					$counter++;
				} 
			?>
		</div>
		<div class="trade_bot_head" style="padding-top: 1px;">
			
		</div>
		<div class="trade_bot"></div>
	</div>
	<div class="trade_right"></div>
</div>
<div style="clear: both;"></div>
<!--<div style="width: 792px; height: 8px; margin: 0px; padding: 0px"></div>-->
<table border="0" style="width: 792px; margin-top: 8px; padding: 0px"><tr><td width="380" align="right"><input type="submit" name="offer" value="Offer Trade"></td><td width="20"></td><td><input type="submit" name="finalize" value="Finalize Trade" /></td></tr></table>
</form>
<!--<div style="width: 792px; height: 8px; margin: 0px; padding: 0px"></div>-->
<div id="shops_toolbox" style="margin-top: 8px; margin-left: 8px;">
	<div class="site_box" style="width: 775px;">
		<div class="site_box_head">
			<div class="shops_title">MY INVENTORY</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="inventory_box_hack" id="myInventory">
				<?php
					$resultI = $database->db_query("SELECT uhi.id, i.itemID, i.name, i.png FROM Items as i JOIN Users_has_Items as uhi ON i.itemID = uhi.itemID_FK JOIN Users as u ON uhi.userID_FK = u.userID WHERE userID = $user AND groups=0 AND trading = 0 ORDER BY name ASC");
					$counter = 0;
					while($rowI = mysqli_fetch_object($resultI)) {
				?>
						<script type="text/javascript">
							var tmp = new Array();
							tmp.push(<?php echo $rowI->id; ?>, <?php echo $rowI->itemID; ?>, '<?php echo $rowI->png; ?>', '<?php echo $rowI->name; ?>'); 
							inventoryItems.push(tmp);
							myInventoryItemsCount++;
						</script>
					
						<img style="cursor: pointer;" src="/characterBuilder/images/<?php echo $rowI->png; ?>" title="<?php echo $rowI->name; ?>" onclick="addItem(<?php echo $counter; ?>);" /><input type='hidden' name='myInventoryItem<?php echo $counter; ?>' value='<?php echo $rowI->id; ?>' />
				<?php 
						$counter++;
					} 
				?>
			</div>
		</div>
	</div>
</div>
<?php } // finalized? ?>
<!--<div style="width: 792px; height: 8px;"></div>-->
<div id="forums_ad2" style="margin-top: 8px; margin-bottom: 16px; margin-left: 7px;">
	<img src="/theme/images/forums_ad2.png" />
</div>
<!--<div style="width: 792px; height: 16px;"></div>-->
<?php } ?>
