<?php
	global $core;
?>
<link rel="stylesheet" type="text/css" href="/theme/scripts/audio.css" />
<script type="text/javascript">
	function highlight(obj){
		obj.style.backgroundColor = "#D1DDF9";
	}
	
	function regular(obj){
		obj.style.backgroundColor = "#fff";
	}
</script>
<?php
	if($core->args[1] == "list"){
		include_once("theme/artist_list.tpl.php");
	} elseif(isset($core->args[1])) {
		include_once("theme/artist_view.tpl.php");
	} else {
		include_once("theme/audio_main.tpl.php");
	}
?>