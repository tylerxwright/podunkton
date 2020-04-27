<div id="vault_header">
	<div id="vault_header_left" style="padding: 0px;">
		<img src="/theme/images/vault_header.png" />
	</div>
	
	<!--
	<div id="vault_header_right">
		
		<div class="vault_header_link"><a href="/">HOME</a></div>
		<div class="vault_header_link"><a href="/">TOONS</a></div>
		<div class="vault_header_link"><a href="/">GAMES</a></div>
		<div class="vault_header_link"><a href="/">AUDIO</a></div>
		<div class="vault_header_link"><a href="/">COMMUNITY</a></div>
	</div>
	-->
	
	<div style="clear:both;"></div>	
</div>
<div style="width: 780; height: 8px; line-height: 0px; padding: 0px; margin: 0px;"></div>
	
<div style="float: left; width: 790px;">
<div id="page_content" style="width: 780px;">

	<div class="site_box" style="width: 250px; float: left; padding-right: 10px; padding-left: 4px;">
			<div class="site_box_head">
				<img src="/theme/images/site_box/vault_flash.png" />
			</div>
			<div class="vault_site_box_content" >
				<div class="vault_links" style="padding: 4px;">
					<ul class="vault">
						<?php
							$result = $database->db_query("SELECT name, file FROM Vault WHERE type='flash' ORDER BY sortOrder ASC");
							while($row = mysqli_fetch_object($result)){
								$file = str_replace(".", "-", $row->file);
						?>
						<li class="vault"><a class="blue" href="/vault/<?php echo $file; ?>"><?php echo $row->name; ?></a></li>
						<?php } ?>
					</ul>
				
					
				</div>
			</div>
	</div>

	<div class="site_box" style="width: 250px; float: left; padding-right: 10px;">
			<div class="site_box_head">
				<img src="/theme/images/site_box/vault_art.png" />
			</div>
			<div class="vault_site_box_content" >
				<div class="vault_links" style="padding: 4px;">
					<ul class="vault">
						<?php
							$result = $database->db_query("SELECT name, file FROM Vault WHERE type='art' ORDER BY sortOrder ASC");
							while($row = mysqli_fetch_object($result)){
								$file = str_replace(".", "-", $row->file);
						?>
						<li class="vault"><a class="blue" href="/vault/<?php echo $file; ?>"><?php echo $row->name; ?></a></li>
						<?php } ?>
					</ul>
				
					
				</div>
			</div>
	</div>

	<div class="site_box" style="width: 250px; float: left;">
			<div class="site_box_head">
				<img src="/theme/images/site_box/vault_misc.png" />
			</div>
			<div class="vault_site_box_content">
				<div class="vault_links" style="padding: 4px;">
					<ul class="vault">
						<?php
							$result = $database->db_query("SELECT name, file FROM Vault WHERE type='misc' ORDER BY sortOrder ASC");
							while($row = mysqli_fetch_object($result)){
								$file = str_replace(".", "-", $row->file);
						?>
						<li class="vault"><a class="blue" href="/vault/<?php echo $file; ?>"><?php echo $row->name; ?></a></li>
						<?php } ?>
					</ul>
				
					
				</div>
			</div>
	</div>
	<div style="clear:both;"></div>
	
	<div id="vault_ad_bottom" style="margin-left: 4px; margin-top: 8px;">
		<img src="/theme/images/forums_ad2.png" />
	</div>
	
</div>


<!--<?php include_once("theme/sidebars/right.tpl.php"); ?>-->


</div>
<div style="clear:both;"></div>