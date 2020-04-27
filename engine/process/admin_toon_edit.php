<?php
	global $database;
	global $error;
	global $core;
	global $session;
	

	$name    = $_POST['name'];
	$season  = $_POST['season'];	
	$release = $_POST['rDate'];
	$NGLink  = $_POST['NG_Link'];
	$desc    = $_POST['description'];
	$episode = $_POST['episode'];
	$point   = $_POST['pointcost'];
	$feature = $_POST['featured'];
	$cast;
	$tid     = $_POST['toonID'];

	$result = $database->db_query("SELECT * FROM Toons WHERE tid = '$tid'");
	$row = mysqli_fetch_array($result);

	//original names
	$oName      = $row['name'];
	$oSeason    = $row['season'];
	$oRelease   = $row['releaseDate'];
	$ongLink    = $row['ngLink'];
	$oDesc      = $row['description'];
	$oEpisode   = $row['episode'];
	$oPoint     = $row['pointCost'];
	$oFeature   = $row['featured'];
	$oIconSmall = $row['iconSmall'];
	$oFileName  = $row['file'];

	//check for valid input	
	if($name == "")
	{
		$error->setError("name must be set");
		header('Location: /' . $session->referrer);
		die();
	}
	if($season == "")
	{
		$error->setError("season must be set");
		header('Location: /' . $session->referrer);
		die();
	}
	if($release == "")
	{
		$error->setError("release date must be set");
		header('Location: /' . $session->referrer);
		die();
	}
	if($NGLink == "")
	{
		$error->setError("New grounds link must be set");
		header('Location: /' . $session->referrer);
		die();
	}
	if($desc == "")
	{
		$error->setError("description must be set");
		header('Location: /' . $session->referrer);
		die();
	}
	if($episode == "")
	{
		$error->setError("episode must be set");
		header('Location: /' . $session->referrer);	
		die();
	}


	//make safe name from name
	$tempName = eregi_replace(" ","_",$name);
	$safeName = strtolower($tempName);


	//get counter number from previous
	//oIconSmall

	$removeUnderscore = explode('_' ,$oIconSmall);
	$removePeriod = explode('.', $removeUnderscore[2]);
	$ImageCounter = $removePeriod[0];

	//get counter number from previous swf
	$removeUnderscore = explode('_',$oFileName);
	$arrayLength = count($removeUnderscore);
	$removePeriod = explode('.', $removeUnderscore[$arrayLength - 1]);
	$SwfCounter = $removePeriod[0];

	//check for valid file types
	if($_FILES['file']['name'] != ""){
	   if($_FILES['file']['type'] != "application/x-shockwave-flash")
	   {	
		$error->setError("invalid file type");
		header('Location: /admin/toons/add');
		die();
           }
	}

	if($_FILES['icons']['name'] != ""){
	   if($_FILES['iconS']['type'] != "image/png")
	   {
		$error->setError("invalid small icon");
		header('Location: /admin/toons/add');
		die();
	   }
	}

	if($_FILES['iconL']['name'] != ""){
           if($_FILES['iconL']['type'] != "image/png")
	   {
		$error->setError("invalid large icon");
		header('Location: /admin/toons/add');
		die();
	   }
	}

	if($_FILES['fImage']['name'] != ""){
 	   if($_FILES['fImage']['type'] != "image/png")
	   {
		$error->setError("invalid featured image");
		header('Location: /admin/toons/add');
		die();
	   }
	}
	
	//if new swf is entered get name and path
	if($_FILES['file']['name'] != ""){		
		$swf_name = $safeName."_".$SwfCounter.".swf";
		$swf_path = "content/toons/swfs/".$swf_name;
		$swf_old_path = "content/toons/swfs/".$oFileName;
		unlink($swf_old_path);

		$tmp_path = "tmp/";
		$tmp_path .= basename($_FILES['file']['name']);
		if(move_uploaded_file($_FILES['file']['tmp_name'], $tmp_path)) {
		   rename($tmp_path, $swf_path);
		   chmod($swf_path, 0777);
		}
  	}
	else{
		$swf_old_name = $oFileName;	

		$swf_old_path = "content/toons/swfs/".$swf_old_name;

		$swf_name = $safeName."_".$SwfCounter.".swf";
		$swf_new_path = "content/toons/swfs/".$swf_name;

		rename($swf_old_path, $swf_new_path);

		
	}

	// small icon name and path
	if($_FILES['iconS']['name'] != ""){
		$si_name = "small_icon_".$ImageCounter.".png";
		$si_path = "content/toons/images/".$si_name;
		unlink($si_path);

		$tmp_path2 = "tmp/";
		$tmp_path2 .= basename($_FILES['iconS']['name']);
		if(move_uploaded_file($_FILES['iconS']['tmp_name'], $tmp_path2)) {
		   rename($tmp_path2, $si_path);
		   chmod($si_path, 0777);
		}
	}

	//large icon name and path
	if($_FILES['iconL']['name'] != ""){
		$li_name = "large_icon_".$ImageCounter.".png";
		$li_path = "content/toons/images/".$li_name;
		unlink($li_path);

		$tmp_path3 = "tmp/";
		$tmp_path3 .= basename($_FILES['iconL']['name']);
		if(move_uploaded_file($_FILES['iconL']['tmp_name'], $tmp_path3)) {
		   rename($tmp_path3, $li_path);
		   chmod($li_path, 0777);
		}
	}

	//featured image icon name and path
	if($_FILES['fImage']['name'] != ""){
		$fi_name = "featured_icon_".$ImageCounter.".png";
		$fi_path = "content/toons/images/".$fi_name;
		//delete the old one
		unlink($fi_path);
		

		$tmp_path4 = "tmp/";
		$tmp_path4 .= basename($_FILES['fImage']['name']);
		if(move_uploaded_file($_FILES['fImage']['tmp_name'], $tmp_path4)) {
		   rename($tmp_path4, $fi_path);
		   chmod($fi_path, 0777);
		}
	}
	//upload information to database
	$fileName = $safeName.".swf";
	/*$result = $database->db_query("INSERT INTO Toons (name, season, description, releaseDate, ngLink, episode, pointCost, featured, file, safeName, iconSmall, iconLarge, featuredImage) VALUES ('$name', '$season', '$desc', '$release', '$NGLink', '$episode', '$point', '$feature', '$fileName', '$safeName', '$si_name', '$li_name', '$fi_name')");
*/

	$result = $database->db_query("UPDATE Toons SET name = '$name' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET season = '$season' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET description = '$desc' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET releaseDate = '$release' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET ngLink = '$NGLink' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET episode = '$episode' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET pointCost = '$point' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET featured = '$feature' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET file = '$swf_name' WHERE tid = $tid");
	$result = $database->db_query("UPDATE Toons SET safeName = '$safeName' WHERE tid = $tid");
	if($_FILES['iconS']['name'] != ""){
		$result = $database->db_query("UPDATE Toons SET iconSmall = '$si_name' WHERE tid = $tid");
	}
	if($_FILES['iconL']['name'] != ""){
		$result = $database->db_query("UPDATE Toons SET iconLarge = '$li_name' WHERE tid = $tid");
	}
	if($_FILES['fImage']['name'] != ""){
		$result = $database->db_query("UPDATE Toons SET featuredImage= '$fi_name' WHERE tid = $tid");
	}
		
	if (!$result)
	{
		$error->setError("There was a snake in my boot!");
	}
	else
	{
		$error->setError("You edited a toon");// fix this. make ituser the msgObj thing to display green.
	}

	//get the tid from recently inserted toon.
	$id = $tid;
	
	//remove previous cast members and replace with new ones
	$database->db_query("DELETE FROM Toons_has_Cast WHERE tid = $tid");

	$counter = 1;
	while($castMember = $_POST['castMember'.$counter])
	{
		$result = $database->db_query("SELECT userID FROM Users WHERE name='$castMember'");
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			$uid = $row['userID'];		
			$database->db_query("INSERT INTO Toons_has_Cast (tid, uid) VALUES ('$id', '$uid')");
		}
		else
		{
			$error->setError("cast member does not exist");
		}

		$counter++;	
	}

	header('Location: /admin/toons');

?>