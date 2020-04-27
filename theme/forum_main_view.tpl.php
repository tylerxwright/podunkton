<?php
	global $core;
	global $database;
?>
<?php
	$result = $database->db_query("SELECT categoryID as 'id', name, position FROM Forum_category ORDER BY position");
	while($row = mysqli_fetch_object($result)){
		print "<br/><b>".$row->name."</b><br/>";
		$result2 = $database->db_query("SELECT subcategoryID as 'id', name, description, link FROM Forum_subcategory WHERE parentCategory = ".$row->id);
		while($row2 = mysqli_fetch_object($result2)){
			print "<a href='/forum/".$row2->link."'>".$row2->name."</a><br/>";
			print "<span style='font-size: 8pt'>---".$row2->description."</span><br/>";
		}
	}
?>