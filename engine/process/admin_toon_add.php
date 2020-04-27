<?php
	global $database;
	global $error;
	global $core;
	global $session;
	
	$counterIcon = "content/toons/images/counter.txt";
	$counterSwf  = "content/toons/swfs/counter.txt";

	$name    = $_POST['name'];
	$season  = $_POST['season'];	
	$release = $_POST['rDate'];
	$NGLink  = $_POST['NG_Link'];
	$desc    = $_POST['description'];
	$episode = $_POST['episode'];
	$point   = $_POST['pointcost'];
	$feature = $_POST['featured'];
	$cast;

	//check for valid input	
	if($name == "")
	{
		$error->setError("name must be set");
		header('Location: /' . $session->referrer);
	}
	if($season == "")
	{
		$error->setError("season must be set");
		header('Location: /' . $session->referrer);
	}
	if($release == "")
	{
		$error->setError("release date must be set");
		header('Location: /' . $session->referrer);
	}
	if($NGLink == "")
	{
		$error->setError("New grounds link must be set");
		header('Location: /' . $session->referrer);
	}
	if($desc == "")
	{
		$error->setError("description must be set");
		header('Location: /' . $session->referrer);
	}
	if($episode == "")
	{
		$error->setError("episode must be set");
		header('Location: /' . $session->referrer);
	}


	//make safe name from name
	$tempName = eregi_replace(" ","_",$name);
	$safeName = strtolower($tempName);


	//open files and get the counters for both icons and swfs
	$fh = fopen($counterIcon, "r");
	$ImageCounter = fread($fh, 50);
	fclose($fh);

	$fh = fopen($counterIcon, "w+");
	fwrite($fh, $ImageCounter+1);
	fclose($fh);


	$fh = fopen($counterSwf, "r");
	$SwfCounter = fread($fh, 50);
	fclose($fh);

	$fh = fopen($counterSwf, "w+");
	fwrite($fh, $SwfCounter+1);
	fclose($fh);


	//check for valid file types
	if($_FILES['file']['type'] != "application/x-shockwave-flash")
	{
		$error->setError("invalid file type");
		header('Location: /admin/toons/add');
	}
	if($_FILES['iconS']['type'] != "image/png")
	{
		$error->setError("invalid small icon");
		header('Location: /admin/toons/add');
	}
	if($_FILES['iconL']['type'] != "image/png")
	{
		$error->setError("invalid large icon");
		header('Location: /admin/toons/add');
	}
	if($_FILES['fImage']['type'] != "image/png")
	{
		$error->setError("invalid featured image");
		header('Location: /admin/toons/add');
	}


	//swf name and path
	$swf_name = $safeName."_".$SwfCounter.".swf";
	$swf_path = "content/toons/swfs/".$swf_name;

	$tmp_path = "tmp/";
	$tmp_path .= basename($_FILES['file']['name']);
	if(move_uploaded_file($_FILES['file']['tmp_name'], $tmp_path)) {
		rename($tmp_path, $swf_path);
		chmod($swf_path, 0777);
	}

	// small icon name and path
	$si_name = "small_icon_".$ImageCounter.".png";
	$si_path = "content/toons/images/".$si_name;

	$tmp_path2 = "tmp/";
	$tmp_path2 .= basename($_FILES['iconS']['name']);
	if(move_uploaded_file($_FILES['iconS']['tmp_name'], $tmp_path2)) {
		rename($tmp_path2, $si_path);
		chmod($si_path, 0777);
	}
	
	//large icon name and path
	$li_name = "large_icon_".$ImageCounter.".png";
	$li_path = "content/toons/images/".$li_name;

	$tmp_path3 = "tmp/";
	$tmp_path3 .= basename($_FILES['iconL']['name']);
	if(move_uploaded_file($_FILES['iconL']['tmp_name'], $tmp_path3)) {
		rename($tmp_path3, $li_path);
		chmod($li_path, 0777);
	}

	//featured image icon name and path
	$fi_name = "featured_icon_".$ImageCounter.".png";
	$fi_path = "content/toons/images/".$fi_name;

	$tmp_path4 = "tmp/";
	$tmp_path4 .= basename($_FILES['fImage']['name']);
	if(move_uploaded_file($_FILES['fImage']['tmp_name'], $tmp_path4)) {
		rename($tmp_path4, $fi_path);
		chmod($fi_path, 0777);
	}

	//upload information to database
	$fileName = $safeName.".swf";
	$result = $database->db_query("INSERT INTO Toons (name, season, description, releaseDate, ngLink, episode, pointCost, featured, file, safeName, iconSmall, iconLarge, featuredImage) VALUES ('$name', '$season', '$desc', '$release', '$NGLink', '$episode', '$point', '$feature', '$swf_name', '$safeName', '$si_name', '$li_name', '$fi_name')");

	if (!$result)
	{
		$error->setError("There was a snake in my boot!");
	}
	else
	{
		$error->setError("You uploaded a toon");
	}

	//get the tid from recently inserted toon.
	$id = mysql_insert_id();


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
