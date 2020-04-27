<?php
	global $database;
	global $error;
	
	$counterFile = "characterBuilder/images/counter.txt";
	$counterFile2 = "characterBuilder/items/counter.txt";
	
	$name = $_POST['name'];
	$desc = $_POST['description'];
	$type = $_POST['type'];
	$cost = $_POST['cost'];
	$credits = $_POST['credits'];
	$sex = $_POST['sex'];
	
	/*if($_POST['store'] == "on"){
		$store = 1;
	} else {
		$store = 0;
	}*/
	
	$store = $_POST['store'];
	
	if($_POST['isdefault'] == "on"){
		$isdefault = 1;
	} else {
		$isdefault = 0;
	}
	
	$pngSArr = array();
	$pngLArr = array();
	
	$levels = 0;
	for($i=1; $i<=5; $i++){
		if($_FILES['spl'.$i]['type'] == "image/png" AND $_FILES['sll'.$i]['type'] == "image/png"){
			$fh = fopen($counterFile, "r");
			$counter = fread($fh, 50);
			fclose($fh);
			
			$fh = fopen($counterFile, "w+");
			fwrite($fh, $counter+1);
			fclose($fh);
			
			$pngS_name = "pngS_$counter.png";
			$pngL_name = "pngL_$counter.png";
			
			$pngS_path = "characterBuilder/images/".$pngS_name;
			$pngL_path = "characterBuilder/images/".$pngL_name;
			
			$pngSArr["l$i"] = $pngS_name;
			$pngLArr["l$i"] = $pngL_name;
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['spl'.$i]['name']);
			if(move_uploaded_file($_FILES['spl'.$i]['tmp_name'], $tmp_path)) {
				rename($tmp_path, $pngS_path);
				chmod($pngS_path, 0777);
			}
			
			$tmp_path = "tmp/";
			$tmp_path .= basename($_FILES['sll'.$i]['name']);
			if(move_uploaded_file($_FILES['sll'.$i]['tmp_name'], $tmp_path)) {
				rename($tmp_path, $pngL_path);
				chmod($pngL_path, 0777);
			}
			$levels++;
		} else {
			break;
		}
	}
	
	$query = sprintf("INSERT INTO Items(name, munniez, credits, png, store, isdefault, description, type, groups, isPhysical, sex, pngLarge) VALUES('%s', %d, %d, '%s', %d, %d, '%s', '%s', %d, %d, %d, '%s')", $name, $cost, $credits, $pngSArr["l1"], $store, $isdefault, $desc, $type, 0, 0, $sex, $pngLArr["l1"]);
	$result = $database->db_query($query);
	
	$itemID = mysql_insert_id();
	
	for($i=1; $i<=9; $i++){
		if($_POST['slot'.$i] != "none"){
			$query = sprintf("INSERT INTO Items_has_Slots(itemID, slotID, ui_slot) VALUES(%d, %d, %d)", $itemID, $_POST['slot'.$i], 1);
			$result = $database->db_query($query);
			
			$numSlots = 0;
			
			$ihsID = mysql_insert_id();
			
			for($j=1; $j<=5; $j++){
				if($_FILES['s'.$i.'l'.$j]['type'] == "application/x-shockwave-flash"){
					
					$fh = fopen($counterFile2, "r");
					$counter = fread($fh, 50);
					fclose($fh);
					
					$fh = fopen($counterFile2, "w+");
					fwrite($fh, $counter+1);
					fclose($fh);
					
					$swf_name = "swf_$counter.swf";
					$swf_path = "characterBuilder/items/".$swf_name;
					
					$tmp_path = "tmp/";
					$tmp_path .= basename($_FILES['s'.$i.'l'.$j]['name']);
					if(move_uploaded_file($_FILES['s'.$i.'l'.$j]['tmp_name'], $tmp_path)) {
						rename($tmp_path, $swf_path);
						chmod($swf_path, 0777);
					}
					
					$query = sprintf("INSERT INTO ItemSWF(link, pngSmall, pngLarge) VALUES('%s', '%s', '%s')", $swf_name, $pngSArr["l$j"], $pngLArr["l$j"]);
					$result = $database->db_query($query);
					
					$itemswfID = mysql_insert_id();
					
					$query = sprintf("INSERT INTO Items_has_ItemSWF(ihsID, itemswfID, level) VALUES(%d, %d, %d)", $ihsID, $itemswfID, $j);
					$result = $database->db_query($query);
				} else {
					break;
				}
			}
			$numSlots++;
		} else {
			break;
		}
	}
	
	if($_POST['grouped'] == "on"){
		header("Location: /admin/character/addgroup/$itemID/$sex/$levels/$numSlots");
	} else {
		$error->setError("Item has been added!");
		header("Location: /admin/character/add");
	}
?>