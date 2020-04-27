<?php
	$file = $core->args[1];
	$file = str_replace("-", ".", $file);
?>
<a class="blue" href="/vault">Go back to the vault</a><br/><br/>
<iframe src="/content/vault/<?php echo $file; ?>" width="100%" frameborder="0" height="600"></iframe>
<div id="vault_ad_bottom" style="margin-left: 4px; margin-top: 8px;">
	<img src="/theme/images/forums_ad2.png" />
</div>