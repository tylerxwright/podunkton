<?php
	global $database;
	global $session;
	global $error;
	global $core;

	$result = $database->db_query("SELECT name,tid FROM Toons WHERE 1 ORDER BY tid");
	

	while($row = mysqli_fetch_array($result))
	{

		echo "<a href='edit/".$row['tid']."'>".$row['name']."</a><br/>";

			
	}

	

?>