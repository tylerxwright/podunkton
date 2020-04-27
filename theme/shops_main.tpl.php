<?php
	global $core;
	global $database;
	
	if($session->user) {
		$userData = $database->db_query("SELECT sex FROM Users WHERE userID=".$session->user);
		$sexR = mysqli_fetch_object($userData);
		$sex = $sexR->sex;
	} else {
		srand(time());
		if(rand(0, 1)){
			$sex = "m";
		} else {
			$sex = "f";
		}
	}
?>

<div id="shops_top_left">
	<?php if($session->user) { ?>
	<a href="/store"><img src="/theme/images/shops_ad.png" /></a>
	<?php } else { ?>
	<a href="/store"><img src="/theme/images/shop_register_ad.png" /></a>
	<?php } ?>
</div>
<div id="shops_top_right">
	<div id="shops_top_sign"><img src="/theme/images/shops_top.png" /></div>
	<!--<div class="spacer" style="width: 500px;"></div>-->
	<div id="shops_toolbox" style="margin-top: 8px;" >
		<div class="site_box" style="width: 500px;">
			<div class="site_box_head">
				<div class="shops_title">SEARCH FOR ITEMS</div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 490px; overflow: hidden;">
					<div style="float: left; padding-left: 8px;"><a href="#"><img src="/theme/images/shops_btn_list.png" /></a></div>
					<div style="float: right; padding-right: 8px;"><a href="#"><img src="/theme/images/shops_btn_sell.png" /></a></div>
					<div style="clear: both;"></div>
					<!--<div style="width: 472px; height: 4px;"></div>-->
					<div id="shops_search_box" style="margin-top: 4px;">
						<form action="" method="POST">
							<div style="padding-left: 20px; padding-top: 8px;">
								<table border="0">
									<tr>
										<td>Search for:</td>
										<td><input type="text" style="width: 190px; margin-left: 10px;" /></td>
										<td>
											<select style="width: 130px;">
												<option value="1">All Items</option>
											</select>
										</td>
									</tr>
								</table>
								<table border="0">
									<tr>
										<td>Price Range: </td>
										<td style="color: #8797C1;"> Min:</td>
										<td><input type="text" style="width: 80px;" /></td>
										<td style="color: #8797C1;"> Max:</td>
										<td><input type="text" style="width: 80px;" /></td>
										<td><input type="submit" value="SEARCH" style="width: 80px;" /></td>
									</tr>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="clear: both;"></div>
<!--<div style="width: 792px; height: 8px;"></div>-->
<?php 
	$result = $database->db_query("SELECT storeID, name, tagline, banner, safeName FROM Store ORDER BY sort ASC");
	$c = 0;
	while($row = mysqli_fetch_object($result)){
		if($row->safeName != "custom_characters") {
?>
<div class="shops_store_box" style="margin-top: 8px;">
	<div class="shops_store_sign"><a href="/shops/<?php echo $row->safeName; ?>"><img src="/content/stores/<?php echo $row->banner; ?>" /></a></div>
	<div class="site_box" style="width: 386px;">
		<div class="site_box_head">
			<div class="shops_title"><?php echo strtoupper($row->name); ?></div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
				<div class="shops_store_grey">
					"<?php echo $row->tagline; ?>"
				</div>
				<div class="shops_store_box_inner" style="overflow: hidden;">
					<?php
						$j = 0;
						if($row->safeName == "barber_shop") {
							$resultF = $database->db_query("SELECT pid, png, name, munniez FROM Physical_Features WHERE sex = '".$sex."' AND (type='hair' or type='eyebrows') ORDER BY munniez DESC LIMIT 0, 4");
						} else {
							$resultF = $database->db_query("SELECT itemID, png, name, munniez FROM Items WHERE groups=0 AND monthly = 0 AND store=".$row->storeID." ORDER BY munniez DESC LIMIT 0, 4");
						}
						while($rowF = mysqli_fetch_object($resultF)) {
					?>
							<div class="shops_store_item" onmouseover="this.style.backgroundColor = '#CDDAF9'" onmouseout="this.style.backgroundColor = '#fff'">
								<div class="flea_item_pic">
									<a href="/shops/<?php echo $row->safeName; ?>/featured"><img src="/characterBuilder/images/<?php echo $rowF->png; ?>" style="margin-left: 5px; margin-top: 5px;" /></a>
								</div>
								<div class="flea_item_desc">
									<a href="/shops/<?php echo $row->safeName; ?>/featured"><?php echo $rowF->name; ?><br/><?php echo $rowF->munniez; ?> Z</a>
								</div>
							</div>
					<?php 
							$j++;
							if($j == 2) {
					?>
								<div style="clear: both; width: 200px; height: 2px; line-height: 1px; font-size: 1px;"></div>
					<?php
							}
						}
					?>
					<div class="shops_go_shopping" style="overflow: hidden; margin-top: 8px;">
						<img src="/theme/images/shops_arrow.png" />
						<a class="blue" href="/shops/<?php echo $row->safeName; ?>">Go Shop Here!</a>
					</div>
					<div style="clear: both;"></div>
				</div>
		</div>
	</div>
</div>
<?php 
		$c++;
		if($c == 2) {
			$c = 0;
?>
			<div style="clear: both;"></div>
			<!--<div style="width: 792px; height: 8px;"></div>-->
<?php } else {	?>
			<div style="width: 17px; height: 20px; float: left;"></div>
<?php
		}
		}
	} 

?>
<div style="clear: both;"></div>

