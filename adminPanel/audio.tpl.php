<?php
	global $core;
?>
<div id="adminMenu">
	<div class="adminButton" <?php if(!isset($core->args[2])) { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/audio">Audio</a>
	</div>
	<div class="adminButton" <?php if($core->args[2] == "band") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/audio/band">Bands</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "genre") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/audio/genre">Genres</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "instrument") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/audio/instrument">Instruments</a>
		
	</div>
	<div class="adminButton" <?php if($core->args[2] == "recordlabel") { ?>style="background-color: #f3f3f3;"<?php } ?>>
		<a class="menuTxt" href="/admin/audio/recordlabel">Record Labels</a>
		
	</div>
</div>
<?php
	global $core;
	
	if(isset($core->args[2])){
		switch($core->args[2]){
			case "band":
				if(isset($core->args[3])){
					if(is_numeric($core->args[3])) {
						include_once("adminPanel/audio_band.tpl.php");
					} else {
						switch($core->args[3]){
							case "add":
								include_once("adminPanel/audio_band_add.tpl.php");
								break;
							case "edit":
								include_once("adminPanel/audio_band_edit.tpl.php");
								break;
							case "delete":
								include_once("adminPanel/audio_band_delete.tpl.php");
								break;
							case "member":
								switch($core->args[4]){
									case "add":
										include_once("adminPanel/audio_member_add.tpl.php");
										break;
									case "edit":
										include_once("adminPanel/audio_member_edit.tpl.php");
										break;
									case "delete":
										//include_once("adminPanel/audio_member_delete.tpl.php");
										break;
									default:
										include_once("theme/errordocs/404.tpl.php");
										break;
								}
								break;
							default:
							case "album":
								if(is_numeric($core->args[4])) {
									include_once("adminPanel/audio_album.tpl.php");
								} else {
									switch($core->args[4]){
										case "add":
											include_once("adminPanel/audio_album_add.tpl.php");
											break;
										case "song":
											switch($core->args[5]) {
												case "add":
													include_once("adminPanel/audio_song_add.tpl.php");
													break;
												case "edit":
													include_once("adminPanel/audio_song_edit.tpl.php");
													break;
												default:
													include_once("theme/errordocs/404.tpl.php");
													break;
											}
										break;
										default:
											include_once("theme/errordocs/404.tpl.php");
											break;
									}
								}
								break;
							default:
							include_once("theme/errordocs/404.tpl.php");
							break;
						}
					}
				} else {
					include_once("adminPanel/audio_band.tpl.php");
				}
				break;
			case "genre":
				if(isset($core->args[3])){
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/audio_genre_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/audio_genre_edit.tpl.php");
							break;
						case "delete":
							include_once("adminPanel/audio_genre_delete.tpl.php");
							break;
						default:
						include_once("theme/errordocs/404.tpl.php");
						break;
					}
				} else {
					include_once("adminPanel/audio_genre.tpl.php");
				}
				break;
			case "instrument":
				if(isset($core->args[3])){
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/audio_instrument_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/audio_instrument_edit.tpl.php");
							break;
						case "delete":
							include_once("adminPanel/audio_instrument_delete.tpl.php");
							break;
						default:
						include_once("theme/errordocs/404.tpl.php");
						break;
					}
				} else {
					include_once("adminPanel/audio_instrument.tpl.php");
				}
				break;
			case "recordlabel":
				if(isset($core->args[3])){
					switch($core->args[3]){
						case "add":
							include_once("adminPanel/audio_recordlabel_add.tpl.php");
							break;
						case "edit":
							include_once("adminPanel/audio_recordlabel_edit.tpl.php");
							break;
						case "delete":
							include_once("adminPanel/audio_recordlabel_delete.tpl.php");
							break;
						default:
						include_once("theme/errordocs/404.tpl.php");
						break;
					}
				} else {
					include_once("adminPanel/audio_recordlabel.tpl.php");
				}
				break;
			default:
				include_once("theme/errordocs/404.tpl.php");
				break;
		}
	} else {
		include_once("adminPanel/audio_main.tpl.php");
	}
?>