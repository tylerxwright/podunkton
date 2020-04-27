<?php
	global $core;
	global $database;
	global $session;
?>
<div id="adminMenu">
	<div class="adminButton" <?php if(!isset($core->args[2])) { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/character">Main</a>
	</div>
	<div class="adminButton" <?php if($core->args[2] == "item") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/character/item">Items</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "skin") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/character/skin">Skins</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "physical") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/character/physical">Physical Items</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "testpurchase") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/character/testpurchase">Get Items</a>
		
	</div>
	<div style="clear: both;"></div>
</div>
<?php
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "item":
				if(isset($core->args[3])){
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/character_item_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/character_item_edit.tpl.php");
							break;
						default:
							include_once("adminPanel/character_item.tpl.php");
							break;
					}
				} else {
					include_once("adminPanel/character_item.tpl.php");
				}
				break;
			case "skin":
				if(isset($core->args[3])){
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/character_skin_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/character_skin_edit.tpl.php");
							break;
						default:
							include_once("adminPanel/character_skin.tpl.php");
							break;
					}
				} else {
					include_once("adminPanel/character_skin.tpl.php");
				}
				break;
			case "physical":
				if(isset($core->args[3])){
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/character_physical_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/character_physical_edit.tpl.php");
							break;
						default:
							include_once("adminPanel/character_physical.tpl.php");
							break;
					}
				} else {
					include_once("adminPanel/character_physical.tpl.php");
				}
				break;
			case "addgroup":
				include_once("adminPanel/character_addgroup.tpl.php");
				break;
			case "testpurchase":
				include_once("adminPanel/character_testpurchase.tpl.php");
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		include_once("adminPanel/character_main.tpl.php");
	}
?>