<?php
	global $core;
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/toons.css" />
<script type="text/javascript">
	function highlight(obj){
		obj.style.backgroundColor = "#D1DDF9";
		obj.style.backgroundImage = "url('/theme/images/top_toons_top.png')"
	}
	
	function regular(obj){
		obj.style.backgroundColor = "#fff";
		obj.style.backgroundImage = "url('/theme/images/top_toons_top_2.png')"
	}
</script>
<?php
	if(isset($core->args[1])){
		if($core->args[1] == "featured"){
			$core->args[1] = "drunk_klunk";
			include_once("theme/games_view.tpl.php");
		} else {
			if($core->args[2] == "trivia") {
				include_once("theme/games_trivia.tpl.php");
			} else {
				include_once("theme/games_view.tpl.php");
			}
		}
	} else {
		include_once("theme/games_main.tpl.php");
	}
?>