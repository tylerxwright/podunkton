<?php
	global $core;
	global $database;
	global $session;
	
	$safeName = $core->args[1];
	
	$resultStore = $database->db_query("SELECT * FROM Store WHERE safeName='$safeName'");
	$rowStore = mysqli_fetch_object($resultStore);
	
	if($core->args[2] == ""){
		$sortBy = "new";
	} elseif($core->args[2] == "featured") {
		$featured = 1;
	} else {
		$sortBy = $core->args[2];
	}
	
	if($core->args[3] == ""){
		$page = 1;
	} else {
		$page = $core->args[3];
	}
	
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

<script type="text/javascript">
	
	var ajax = new Ajax();
	
	function popupM(width, height, id, name, image, description, munniez, type, sex) {
		
		boxInner = setOverlay(width, height);
		
		if(type == "hair") {
			type = 1;
		} else {
			type = 2;
		}
		
		if(<?php if($session->user) { echo 1;} else { echo 0; } ?>) {
			if(sex == '<?php echo $sex; ?>') {
				str = "<table width='"+(width-2)+"' border='0' align='center'>" +
					  "<tr><td colspan='2'><img src='/characterBuilder/images/"+image+"' /></td></tr>" +
					  "<tr><td colspan='2' style='font-weight: bold;'>"+name+"</td></tr>" +
					  "<tr><td colspan='2'>"+description+"</td></tr>" +
					  "<tr><td colspan='2' style='font-weight: bold;'>Cost: "+munniez+" munniez</td></tr>" +
					  "<tr><td colspan='2'></td></tr>" +
					  "<tr><td colspan='2'>Are you sure you want to buy this?</td></tr>" +
					  "<tr><td colspan='2'></td></tr>" +
					  "<tr><td>" +
						"<input type='button' name='id' value='Purchase' onclick='buyItem("+id+", "+width+", "+height+", "+type+" );' />" +
						"<input type='button' name='id' value='Cancel' onclick='cancelPopup();' />" +
					  "</td></tr>" +
					  "</table>";
			} else {
				str = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>Are you confused of your gender? Your not supposed to wear that, although Klunk would beg to differ.<br/><br/></td></tr></table><input type='button' name='id' value='Close' onclick='cancelPopup();' />";
			}
		} else {
			str = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>You must be logged in to buy items<br/><br/><input type='button' value='OK' onclick='cancelPopup();' /></td></tr></table>";
		}
		boxInner.innerHTML = str;
	}
	
	function popupC(width, height, id, name, image, description, credits, type, sex) {
		
		boxInner = setOverlay(width, height);
		
		if(type == "hair") {
			type = 1;
		} else {
			type = 2;
		}
		
		if(<?php if($session->user) { echo 1;} else { echo 0; } ?>) {
			if(sex == '<?php echo $sex; ?>') {
				str = "<table width='"+(width-2)+"' border='0' align='center'>" +
					  "<tr><td colspan='2'><img src='/characterBuilder/images/"+image+"' /></td></tr>" +
					  "<tr><td colspan='2' style='font-weight: bold;'>"+name+"</td></tr>" +
					  "<tr><td colspan='2'>"+description+"</td></tr>" +
					  "<tr><td colspan='2' style='font-weight: bold;'>Cost: "+credits+" credits</td></tr>" +
					  "<tr><td colspan='2'></td></tr>" +
					  "<tr><td colspan='2'>Are you sure you want to buy this?</td></tr>" +
					  "<tr><td colspan='2'></td></tr>" +
					  "<tr><td>" +
						"<input type='button' name='id' value='Purchase' onclick='buyItemC("+id+", "+width+", "+height+", "+type+" );' />" +
						"<input type='button' name='id' value='Cancel' onclick='cancelPopup();' />" +
					  "</td></tr>" +
					  "</table>";
			} else {
				str = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>Are you confused of your gender? Your not supposed to wear that, although Klunk would beg to differ.<br/><br/></td></tr></table><input type='button' name='id' value='Close' onclick='cancelPopup();' />";
			}
		} else {
			str = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>You must be logged in to buy items<br/><br/><input type='button' value='OK' onclick='cancelPopup();' /></td></tr></table>";
		}
		boxInner.innerHTML = str;
	}
	
	function popupTry(width, height, id, sex, type) {
		
		boxInner = setOverlay(width, height);
		
		if(<?php if($session->user) { echo 1;} else { echo 0; } ?> != 0) {
			if(sex == "<?php echo $sex; ?>") {
				str = "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='225' height='298' id='logo' align='middle'>" +
					  "<param name='allowScriptAccess' value='sameDomain' />" +
					  "<param name='movie' value='/characterBuilder/viewers/viewer_<?php echo $sex; ?>_tryP.swf?uid=<?php echo $session->user; ?>&itemID="+id+"&type="+type+"&dummy=<?php echo time(); ?>' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' /><embed src='/characterBuilder/viewers/viewer_<?php echo $sex; ?>_tryP.swf?uid=<?php echo $session->user; ?>&itemID="+id+"&type="+type+"&dummy=<?php echo time(); ?>' quality='high' bgcolor='#ffffff' width='225' height='298' name='logo' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />" +
					  "</object>";
			} else {
				str = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>Are you confused of your gender? Your not supposed to wear that, although Klunk would beg to differ.<br/><br/></td></tr></table>";
			}
		} else {
			str = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>You must be logged in to try on items<br/><br/></td></tr></table>";
		}
		boxInner.innerHTML = str;
	}
	
	function setOverlay(width, height) {
		overlayBox = document.getElementById("overlay");
		box = document.getElementById("overlay_message_box");
		box2 = document.getElementById("overlay_box");
		boxInner = document.getElementById("overlay_inner");
		
		box.style.width = width+'px';
		box.style.height = height+'px';
		box.style.marginLeft = (-width/2)+'px';
		box.style.marginTop = (-height/2)+'px';
		
		box2.style.width = (width-2)+'px';
		boxInner.style.width = (width-10)+'px';
		boxInner.style.height = (height-37)+'px';
		
		overlayBox.style.display = "block";
		box.style.display = "block";
		document.body.style.overflow='hidden';
		
		return boxInner;
	}
	
	function buyItem(id, width, height, type) {
		if(type == 1) {
			type = "hair";
		} else {
			type = "eyebrows";
		}
		ajax.doGet("/process/buyPhysical/"+id+"/"+type, showPurchase);
	}
	
	function buyItemC(id, width, height, type) {
		if(type == 1) {
			type = "hair";
		} else {
			type = "eyebrows";
		}
		ajax.doGet("/process/buyPhysicalC/"+id+"/"+type, showPurchase2);
	}
	
	function showPurchase(str) {
		box = document.getElementById("overlay_inner");
		width = box.style.width;
		height = box.style.height;
		str2 = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>";
		
		if(str == "fail") {
			str2 += "You don't have enough munniez!<br/><br/><input type='button' value='OK' onclick='cancelPopup();' />";
		} else {
			document.getElementById("munniez").innerHTML = str;
			str2 += "Item purchased!<br/><br/><input type='button' value='OK' onclick='cancelPopup();' />";
		}
		box.innerHTML = str2+"</td></tr></table>";
	}
	
	function showPurchase2(str) {
		box = document.getElementById("overlay_inner");
		width = box.style.width;
		height = box.style.height;
		str2 = "<table style='width: "+width+"; height: "+height+";' border='0' align='center' valign='middle'><tr><td>";
		
		if(str == "fail") {
			str2 += "You don't have enough credits!<br/><br/><input type='button' value='OK' onclick='cancelPopup();' />";
		} else {
			document.getElementById("credits").innerHTML = str;
			str2 += "Item purchased!<br/><br/><input type='button' value='OK' onclick='cancelPopup();' />";
		}
		box.innerHTML = str2+"</td></tr></table>";
	}
	
	function customSearch() {
		searchStr = document.getElementById("searchStr").value;
		typeVar = document.getElementById("type");
		type = typeVar.options[typeVar.selectedIndex].value;
		minVal = document.getElementById("min").value;
		maxVal = document.getElementById("max").value;
		
		if(searchStr == ""){
			searchStr = "anything";
		}
		
		if(minVal == "") {
			minVal = 0;
		}
		
		if(maxVal == "") {
			maxVal = "any";
		}
		
		location="/shops/<?php echo $safeName; ?>/custom/1/"+type+"/"+minVal+"/"+maxVal+"/"+searchStr;
	}
	
	function quickSearch(searchBy) {
		styleObj = document.getElementById("style_type");
		styleType = styleObj.options[styleObj.selectedIndex].value;
		location="/shops/<?php echo $safeName; ?>/"+styleType+"/1/"+searchBy;
	}
	
</script>

<div style="padding-bottom: 20px;"><a class="blue" href="/shops">Back to the Shopping Center</a></div>
<div id="shops_top_left">
	<?php if($session->user) { ?>
	<a href="/store"><img src="/theme/images/shops_ad.png" /></a>
	<?php } else { ?>
	<a href="/store"><img src="/theme/images/shop_register_ad.png" /></a>
	<?php } ?>
</div>
<div id="shops_top_right">
	<div id="store_sign"><img style="border: solid 1px #828282;" src="/content/stores/<?php echo $rowStore->banner; ?>" /></div>
	<!--<div style="width: 500px; height: 8px;"></div>-->
	<div id="shops_toolbox" style="margin-top: 8px;">
		<div class="site_box" style="width: 500px;">
			<div class="site_box_head">
				<div class="shops_title">SEARCH FOR ITEMS</div>
			</div>
			<div class="site_box_content" style="background-color: #fff;">
				<div class="site_box_content_inner" style="width: 490px;">
					<div style="float: left; padding-left: 8px;"><a href="/shops/<?php echo $safeName; ?>/all/1"><img src="/theme/images/shops_btn_list.png" /></a></div>
					<div style="float: right; padding-right: 8px;"><a href="#"><img src="/theme/images/shops_btn_sell.png" /></a></div>
					<div style="clear: both;"></div>
					<!--<div style="width: 472px; height: 4px;"></div>-->
					<div id="shops_search_box" style="margin-top: 4px;">
						<form action="" method="POST">
							<div style="padding-left: 20px; padding-top: 8px;">
								<table border="0">
									<tr>
										<td>Search for:</td>
										<td><input type="text" id="searchStr" style="width: 190px; margin-left: 10px;" /></td>
										<td>
											<select id="type" style="width: 130px;">
												<option value="all">All Styles</option>
												<option value="hair">Hairstyles</option>
												<option value="eyebrows">Eyebrow Styles</option>
											</select>
										</td>
									</tr>
								</table>
								<table border="0">
									<tr>
										<td>Price Range: </td>
										<td style="color: #8797C1;" value="0"> Min:</td>
										<td><input type="text" id="min" style="width: 80px;" /></td>
										<td style="color: #8797C1;" value="No Limit"> Max:</td>
										<td><input type="text" id="max" style="width: 80px;" /></td>
										<td><input type="button" value="SEARCH" style="width: 80px;" onclick="customSearch();"/></td>
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
<div id="shops_toolbox" style="margin-top: 8px;">
	<div class="site_box" style="width: 792px;">
		<div class="site_box_head">
			<div class="shops_title"><?php echo strtoupper($rowStore->name); ?></div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div style="background-color: #E2E2E2; border-bottom: solid 1px #828282;">
				<select id="style_type" class="barber_select"><option value="hairstyles">Hairstyles</option><option value="eyebrows">Eyebrows</option></select>
				<div class="barber_all"><img onclick="quickSearch('all');" src="/theme/images/barber_all.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "red") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('red');" src="/theme/images/barber_color1.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "orange") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('orange');" src="/theme/images/barber_color2.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "yellow") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('yellow');" src="/theme/images/barber_color3.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "green") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('green');" src="/theme/images/barber_color4.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "blue") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('blue');" src="/theme/images/barber_color5.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "purple") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('purple');" src="/theme/images/barber_color6.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "pink") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('pink');" src="/theme/images/barber_color7.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "ltbrown") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('ltbrown');" src="/theme/images/barber_color8.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "brown") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('brown');" src="/theme/images/barber_color9.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "black") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('black');" src="/theme/images/barber_color10.png" /></div>
				<div class="barber_color" <?php if($core->args[4] == "white") echo "style='background-color: #fff;'"; ?>><img onclick="quickSearch('white');" src="/theme/images/barber_color11.png" /></div>
				<div style="clear:both;"></div>
			</div>
			<div id="store_selector"></div>
			<?php 
				$c = 1;
				if($featured == 1){
					$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE sex = '".$sex."' AND (type='hair' or type='eyebrows') ORDER BY munniez DESC LIMIT 0, 4");
				} else {
					if($sortBy == "new") {
						$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' ORDER BY dateAdded DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
					} elseif($sortBy == "hairstyles" OR $sortBy == "eyebrows") {
						if($sortBy == "hairstyles") $sortBy = "hair";
						if($core->args[4] == "all") {
							$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE type = '$sortBy' AND sex = '".$sex."' ORDER BY dateAdded DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
						} else {
							$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE type = '$sortBy' AND color = '".$core->args[4]."' AND sex = '".$sex."' ORDER BY dateAdded DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
						}
					} elseif($sortBy == "custom") {
						
						// Custom search
						$customSort = $core->args[4];
						$min = $core->args[5];
						$max = $core->args[6];
						$search = $core->args[7];
						if($search == "anything") {
							$search = '';
						}
						
						if($max == "any") {
							if($customSort == "all"){
								$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE (name LIKE '%$search%' OR description LIKE '%$search%') AND sex = '".$sex."' ORDER BY name DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
							} else {
								$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE type='$customSort' AND (name LIKE '%$search%' OR description LIKE '%$search%') AND sex = '".$sex."' ORDER BY name DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
							}
						} else {
							if($customSort == "all") {
								$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE (name LIKE '%$search%' OR description LIKE '%$search%') AND munniez > $min AND munniez < $max AND sex = '".$sex."' ORDER BY name DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
							} else {
								$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE type='$customSort' AND (name LIKE '%$search%' OR description LIKE '%$search%') AND munniez > $min AND munniez < $max AND sex = '".$sex."' ORDER BY name DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
							}
						}
						
					} else {
						$resultItem = $database->db_query("SELECT * FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' ORDER BY dateAdded DESC LIMIT ".(($page-1)*ITEMS_PER_STORE_PAGE).", 10");
					}
				}
				$count = mysqli_num_rows($resultItem);
				if($count != 0) {
					while($rowItem = mysqli_fetch_object($resultItem)) {
			?>
					<div class="store_item_row" <?php if($c == $count) echo "style='border-bottom: none;'"; ?>>
						<div class="store_item_icon"><img src="/characterBuilder/images/<?php echo $rowItem->png; ?>" style="margin-left: 18px; margin-top: 18px;" /></div>
						<div class="store_item_mid">
							<table border="0">
								<tr class="store_item_tr"><td class="store_bold">NAME:</td><td class="store_bold"><?php echo $rowItem->name; ?></td></tr>
								<tr class="store_item_tr"><td class="store_bold">PRICE:</td><td><?php echo $rowItem->munniez; ?> Munniez / <?php echo $rowItem->credits; ?> Credits</td></tr>
								<tr class="store_item_tr"><td class="store_bold" valign="top">DESCRIPTION:</td><td><?php echo $rowItem->description; ?></td></tr>
								<?php
									if($rowItem->sex == 'm') {
										$sexText = "MALE";
									} else {
										$sexText = "FEMALE";
									}
								?>
								<tr class="store_item_tr"><td class="store_bold">SEX:</td><td><?php echo $sexText; ?></td></tr>
							</table>
						</div>
						<div class="store_item_tools">
							<a href="#"><img class="store_btn" src="/theme/images/store_btn_bm.png" onclick="popupM(350, 250, <?php echo $rowItem->pid.", '".addSlashes($rowItem->name)."', '".$rowItem->png."', '', '".$rowItem->munniez."', '".$rowItem->type."', '".$rowItem->sex."'"; ?> );" /></a>
							<a href="#"><img class="store_btn" src="/theme/images/store_btn_bc.png" onclick="popupC(350, 250, <?php echo $rowItem->pid.", '".addSlashes($rowItem->name)."', '".$rowItem->png."', '', '".$rowItem->credits."', '".$rowItem->type."', '".$rowItem->sex."'"; ?> );" /></a>
							<a href="#"><img class="store_btn" src="/theme/images/store_btn_try.png" onclick="popupTry(235, 365, <?php echo $rowItem->pid; ?>, '<?php echo $rowItem->sex; ?>', '<?php echo $rowItem->type; ?>');" /></a>
							<!--<a href="#"><img class="store_btn" src="/theme/images/store_btn_add.png" /></a>-->
						</div>
						<div style="clear: both;"></div>
					</div>
			<?php 
						$c++;
					} 
				} else {	// No items to show
			?>
				<div class="store_item_row" style='border-bottom: none; text-align: center;'>
					There are no items to show
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="shops_bread">
	<?php
		if($featured != 1){
			if($sortBy == "all" or $sortBy == "new"){
				if($core->args[4] == "all") {
					$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."'");
				} else {
					$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' AND color = '".$core->args[4]."'");
				}
			} elseif($sortBy == "custom") {
				if($max == "any") {
					if($customSort == "all"){
						$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' AND (name LIKE '%$search%' OR description LIKE '%$search%')");
					} else {
						$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' AND type='$customSort' AND (name LIKE '%$search%' OR description LIKE '%$search%')");
					}
				} else {
					if($customSort == "all") {
						$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' AND (name LIKE '%$search%' OR description LIKE '%$search%') AND munniez > $min AND munniez < $max");
					} else {
						$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE (type = 'hair' OR type = 'eyebrows') AND sex = '".$sex."' AND type='$customSort' AND (name LIKE '%$search%' OR description LIKE '%$search%') AND munniez > $min AND munniez < $max");
					}
				}
			} else {
				if($core->args[4] == "all") {
					$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE type='$sortBy' AND sex = '".$sex."'");
				} else {
					$resultNum = $database->db_query("SELECT COUNT(pid) as 'count' FROM Physical_Features WHERE type='$sortBy' AND color = '".$core->args[4]."' AND sex = '".$sex."'");
				}
			}
			
			$rowCount = mysqli_fetch_object($resultNum);
			$count = $rowCount->count;
		
			if(($page)*ITEMS_PER_STORE_PAGE > $count) {
				$endPage = $count;
			} else {
				$endPage = ($page)*ITEMS_PER_STORE_PAGE;
			}
			$numPages = ceil($count/ITEMS_PER_STORE_PAGE);
		?>
		Items <?php echo ($page-1)*ITEMS_PER_STORE_PAGE+1; ?> - <?php echo $endPage; ?> of <?php echo $count; ?> 
		<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/1<?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo "first"; ?> </a>
		<?php if($page > 1) { ?>
		<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $page-1; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo "<"; ?> </a>
		<?php } ?>
		<?php
			if($numPages > 5){
				if($page > 3){
					for($i=$page-2; $i<=$page; $i++){
						if($i == $page){
		?>
								<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php 		 } else {	?>
								<a class="blue" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php
						}
					}
					for($i=$page+1; $i<=$page+3; $i++){
						if($i > $numPages) {
							break;
						}
						if($i == $page){
		?>
								<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php 		 } else {	?>
								<a class="blue" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php
						}
					}
				} else {
				
					for($i=1; $i<=3; $i++){
						if($i == $page){
		?>
								<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php 		 } else {	?>
								<a class="blue" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php
						}
					}
					echo "...";
					for($i=$numPages-1; $i<=$numPages; $i++){
						if($i == $page){
		?>
								<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php 		 } else {	?>
								<a class="blue" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php
						}
					}
				}
			} else {
				for($i=1; $i<=$numPages; $i++){
					if($i == $page){
		?>
							<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php 		 } else {	?>
							<a class="blue" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $i; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo $i; ?> </a>
		<?php
					}
				}
			}
		?>
		<?php if($page < $numPages) { ?>
		<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $page+1; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo ">"; ?> </a>
		<?php } ?>
		<a class="blue" style="font-weight: bold;" href="/shops/<?php echo $safeName; ?>/<?php echo $sortBy; ?>/<?php echo $numPages; ?><?php if($sortBy == "custom") { echo "/".$core->args[4]."/".$core->args[5]."/".$core->args[6]."/".$core->args[7]; } else { echo "/".$core->args[4]; } ?>"><?php echo "last"; ?> </a>
		<?php } else { ?>
			
		<?php } ?>
</div>