<?php
	global $core;
	global $session;
	global $database;
	
	$result = $database->db_query("SELECT categoryID, name FROM Forum_Category ORDER BY sort");
?>
<h3>Add a new Subcategory</h3>
<form enctype="multipart/form-data" action="/process/addForumSubcategory" method="POST">
	<table border="0">
		<tr><td>Subcategory</td><td>
			<select name="categoryID">
				<?php
					while($row = mysqli_fetch_object($result)) {
				?>
						<option value="<?php echo $row->categoryID; ?>"><?php echo $row->name; ?></option>
				<?php
					}
				?>
			</select>
		</td></tr>
		<tr><td>Name</td><td><input type="text" name="name" style="width: 150px;"></td></tr>
		<tr><td valign="top">Description</td>
			<td>
				<textarea name="description"></textarea>
			</td>
		</tr>
		<tr><td>Icon</td><td><input type="file" name="icon" /> (35x34 PNG)</td></tr>
		<tr><td>Order</td><td><input type="text" name="order" size="2"> Leave blank for next highest</td></tr>
		<input type="hidden" name="admin" value="1"/>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>