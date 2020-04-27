<?php
	
	$username = $core->args[1];
	$user = $session->user;
	
	$result = $database->db_query("SELECT * FROM Users WHERE name = '$username' AND userID = $user");
	$count = mysqli_num_rows($result);
	if($count == 1) {
		$row = mysqli_fetch_object($result);
?>

<div id="user_edit_top">
	<div style="float: left;"><img src="/theme/images/my_information.png" /></div>
	<div style="float: right; padding-top: 6px;"><a class="blue" href="/user/<?php echo $username; ?>">BACK TO USER PAGE</a></div>
	<div style="clear: both;"></div>
</div>
<div id="user_edit_left">
	<div class="site_box" style="width: 588px;">
		<div class="site_box_head">
			<div class="user_title">EDIT GENERAL INFO</div>
		</div>
		<div class="site_box_content" style="background-color: #fff; padding-top: 8px; padding-bottom: 10px; font-size: 8pt;">
			<form action="/process/userEdit" method="POST" name="userForm">
				<table border="0" style="width: 588px;">
					<tr class="user"><td class="user" colspan="3" align="right" width="70">Catchphrase:</td><td class="user" width="5"></td><td class="user" colspan="2"><input type="text" class="uedit" name="catchphrase" value="<?php echo $row->catchphrase; ?>"/></td></tr>
					<tr class="user" style="height: 1px;"><td class="user" colspan="6"><div class="hr"></div></td></tr>
					<tr class="user"><td class="user" width="25"></td><td class="user" align="left" class="head" width="110">BASIC INFO</td><td class="user" align="right" width="70">Real Name:</td><td width="5"></td><td class="user" colspan="2"><input type="text" class="uedit" name="realName" value="<?php echo $row->realName; ?>" /></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70">Sign:</td><td width="5"></td><td colspan="2"><input type="text" class="uedit" name="sign" value="<?php echo $row->sign; ?>" /></td></tr>
					<tr class="user" style="height: 25px;"><td colspan="6"></td></tr>
					<tr class="user"><td class="user" width="25"></td><td align="left" class="head" width="110">CONTACT INFO</td><td class="user" align="right" width="70">Email:</td><td width="5"></td><td class="user" colspan="2"><input type="text" class="uedit" name="email" value="<?php echo $row->email; ?>" /></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70">AIM:</td><td width="5"></td><td class="user" colspan="2"><input type="text" class="uedit" name="aim" value="<?php echo $row->aim; ?>" /></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70">Website:</td><td width="5"></td><td class="user" colspan="2"><input type="text" class="uedit" name="website" value="<?php echo $row->website; ?>" /></td></tr>
					<tr class="user" style="height: 25px;"><td colspan="6"></td></tr>
					<tr class="user"><td class="user" width="25"></td><td align="left" class="head" width="110" valign="top">CONTACT INFO</td><td class="user" align="right" width="70" valign="top">Activities:</td><td width="5"></td><td colspan="2"><textarea class="uedit" name="activities"><?php echo $podunkton->PrintUserTags2(1, $user); ?></textarea></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70" valign="top">Music:</td><td width="5"></td><td class="user" colspan="2"><textarea class="uedit" name="music"><?php echo $podunkton->PrintUserTags2(2, $user); ?></textarea></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70" valign="top">Movies:</td><td width="5"></td><td class="user" colspan="2"><textarea class="uedit" name="movies"><?php echo $podunkton->PrintUserTags2(3, $user); ?></textarea></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70" valign="top">Television:</td><td width="5"></td><td class="user" colspan="2"><textarea class="uedit" name="television"><?php echo $podunkton->PrintUserTags2(4, $user); ?></textarea></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70" valign="top">Quotes:</td><td width="5"></td><td class="user" colspan="2"><textarea class="uedit" name="quotes"><?php echo stripslashes(str_replace("<br />", "\n", $row->quotes)); ?></textarea></td></tr>
					<tr class="user"><td class="user" colspan="3" align="right" width="70" valign="top"></td><td width="5"></td><td class="user" width="134"><img style="cursor: pointer;" src="/theme/images/save_changes.png" onclick="document.userForm.submit();" /></td><td><a href="/user/<?php echo $username; ?>"><img src="/theme/images/cancel_changes.png" /></a></td></tr>
				</table>
			</form>
		</div>
	</div>
	<div style="width: 235px; height: 20px;"></div>
</div>
<div id="user_right">
	<div class="user_tower_ad">
		<div><img src="/theme/images/skyscraper.gif" /></div>
	</div>
</div>
<div style="clear: both;"></div>
<?php
	} else {
		include_once("theme/errordocs/404.tpl.php");
	}
?>