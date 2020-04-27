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
	if($core->args[1] == "view"){
		if($core->args[3] == "trivia") {
			include_once("theme/toons_trivia.tpl.php");
		} else {
			include_once("theme/toons_view.tpl.php");
		}
	} elseif(isset($core->args[1])) {
		if($core->args[1] == "featured"){
			$core->args[2] = "a_very_klunk_x_mas";
			include_once("theme/toons_view.tpl.php");
		} else {
			include_once("theme/toons_season.tpl.php");
		}
	} else {
		include_once("theme/toons_main.tpl.php");
	}
?>