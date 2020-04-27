<b>Add a New Store</b>
<form enctype="multipart/form-data" action="/process/addStore" method="POST">
	<table border="0">
		<tr><td>Name:</td><td><input type="text" name="name" /></td></tr>
		<tr><td>Tagline:</td><td><input type="text" name="tagline" size="60" /></td></tr>
		<tr><td>Banner:</td><td><input type="file" name="banner" /></td></tr>
		<tr><td>hotbox:</td><td><input type="file" name="hotbox" /></td></tr>
		<tr><td>Order:</td><td><input type="text" name="order" /></td></tr>
		<input type="hidden" name="admin" value="1"/>
		<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
	</table>
</form>