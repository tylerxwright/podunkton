<?php
	global $core;
?>
<div id="adminMenu">
	<div class="adminButton" <?php if(!isset($core->args[2])) { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/game">Games</a>
	</div>
	<div class="adminButton" <?php if($core->args[2] == "season") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/game/categories">Categories</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "mpaa") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/game/mpaa">MPAA Ratings</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "featured") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/game/featured">Featured Game</a>
		
	</div>
	<div style="clear: both;"></div>
</div>
<?php
	if(isset($core->args[2])){
		if(is_numeric($core->args[2])) {
			include_once("adminPanel/game_main.tpl.php");
		} else {
			switch($core->args[2]){
				case "add":
					include_once("adminPanel/game_add.tpl.php");
					break;
				case "edit":
					include_once("adminPanel/game_edit.tpl.php");				
					break;
				/*case "season":
					if(isset($core->args[3])) {
						switch($core->args[3]){
							case "add":
								include_once("adminPanel/toon_season_add.tpl.php");
								break;
							case "edit":
								include_once("adminPanel/toon_season_edit.tpl.php");
								break;
						}
					} else {
						include_once("adminPanel/toon_season.tpl.php");
					}
					break; */
				case "cast":
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/game_cast_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/game_cast_edit.tpl.php");
							break;
					}
					break;
				case "trivia":
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/game_trivia_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/game_trivia_edit.tpl.php");
							break;
					}
					break;
				case "mpaa":
					if(isset($core->args[3])) {
						switch($core->args[3]){
							case "add":
								include_once("adminPanel/game_mpaa_add.tpl.php");
								break;
							case "edit":
								include_once("adminPanel/game_mpaa_edit.tpl.php");
								break;
						}
					} else {
						include_once("adminPanel/game_mpaa.tpl.php");
					}
					break;
				case "featured":
					switch($core->args[3]){
						case "add":
							//include_once("adminPanel/toon_featured_add.tpl.php");
							break;
						case "edit":
							//include_once("adminPanel/toon_featured_edit.tpl.php");
							break;
					}
					break;
				default:
					include_once("theme/errordocs/404.tpl.php");
					break;
			}
		}
	} else {
		include_once("adminPanel/game_main.tpl.php");
	}
?>
