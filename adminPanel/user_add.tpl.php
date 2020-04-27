<?php
	global $core;
	global $database;
?>
<span style="color: #ff0000">*</span> required<br/>
<b>Add a New User</b>
<form action="/process/register" method="POST">
	Username: <input type="text" name="uname" /><span style="color: #ff0000">*</span><br/>
	Password: <input type="password" name="pword" /><span style="color: #ff0000">*</span><br/>
	Confirm Password: <input type="password" name="pword2" /><span style="color: #ff0000">*</span><br/>
	Sex: 
	<select name="sex">
		<option value="" selected="selected"></option>
		<option value="male">male</option>
		<option value="female">female</option>
	</select><br/>
	Birthday:
	<select name="month">
		<option value="" selected="selected"></option>
		<?php
			$months = $core->months();
			for($i=0; $i<12; $i++){
				print "<option value='".key($months)."'>".current($months)."</option>";
				next($months);
			}
		?>
	</select>
	<select name="day">
		<option value="" selected="selected"></option>
		<?php
			for($i=1; $i<=31; $i++){
				print "<option value='$i'>$i</option>";
			}
		?>
	</select>
	<select name="year">
		<option value="" selected="selected"></option>
		<?php
			for($i=1900; $i<=2008; $i++){
				print "<option value='$i'>$i</option>";
			}
		?>
	</select><span style="color: #ff0000">*</span><br/>
	Email: <input type="text" name="email" /><span style="color: #ff0000">*</span><br/>
	AIM: <input type="text" name="aim" /><br/>
	MSN: <input type="text" name="msn" /><br/>
	ICQ: <input type="text" name="icq" /><br/>
	GoodEvil: <input type="text" name="goodevil" /><br/>
	Points: <input type="text" name="points" /><br/>
	RankID: <input type="text" name="rankid" /><br/>
	Experience: <input type="text" name="experience" /><br/>
	FavoriteToon:
	<select name="favoriteToon">
		<option value="" selected="selected"></option>
		<?php
			$result = $database->db_query("SELECT toonID, name FROM Toons");
			while($row = mysqli_fetch_object($result)){
				print "<option value='".$row->toonID."'>".$row->name."</option>";
			}
		?>
	</select>
	<br/>
	FavoriteGame: 
	<select name="favoriteGame">
		<option value="" selected="selected"></option>
		<?php
			$result = $database->db_query("SELECT gameID, name FROM Games");
			while($row = mysqli_fetch_object($result)){
				print "<option value='".$row->gameID."'>".$row->name."</option>";
			}
		?>
	</select>
	<br/>
	featured: <input type="text" name="featured" /><br/>
	forumView:  
	<select name="forumView">
		<option value="Classic" selected="selected">Classic</option>
		<option value="Tolerance">Tolerance</option>
	</select>
	<br/>
	Permissions: <input type="text" name="permissions" /><br/>
	<input type="hidden" name="admin" value="1"/>
	<input type="submit" value="Submit" />
</form>