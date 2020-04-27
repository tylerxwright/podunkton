<?php
	global $database;
	global $session;
	global $core;
	global $error;
	global $msgObj;
	
	$itemName = '';
	$itemID = $core->args[2];
	if($itemID == ""){
		$error->setError("No item id was given!");
		header("Location: /admin/character");
		die();
	}
	
	// Get the item
	$result = $database->db_query("SELECT name, png, pngLarge FROM Items WHERE itemID = $itemID");
	if(!$result){
		$error->setError("Got Broken!");
		header("Location: /admin/character");
		die();
	}
	$row = mysqli_fetch_object($result);
	
	// Set name
	$itemName = $row->name;
	
	// Unlink main item pngs
	if(!unlink("characterBuilder/images/".$row->png)) {
		$error->setError("Error: Item png could not be deleted.");
		header("Location: /admin/character");
		die();
	}
	
	if(!unlink("characterBuilder/images/".$row->pngLarge)) {
		$error->setError("Error: Item pngLarge could not be deleted.");
		header("Location: /admin/character");
		die();
	}
	
	// Delete main item
	deleteItems($itemID);
	
	$result = $database->db_query("SELECT itemID FROM Items WHERE groups = $itemID");
	if(!$result){
		$error->setError("Error: Couldn't get items groups'!");
		header("Location: /admin/character");
		die();
	}
	while($row = mysqli_fetch_object($result)){
		deleteItems($row->itemID);
	}
	
	// Item has been deleted
	$msgObj->setMsg("You deleted the item $itemName and all of its dependencies");
	header("Location: /admin/character");
	die();
	
	
	
	
	function deleteItems($iID) {
		global $database;
		global $error;
		
		// Delete the item
		$result = $database->db_query("DELETE FROM Items WHERE itemID = $iID");
		if(!$result){
			$error->setError("Item could not be deleted!");
			header("Location: /admin/character");
			die();
		}
		
		// Delete item from users inventory
		$result = $database->db_query("DELETE FROM Users_has_Items WHERE itemID_FK = $iID");
		if(!$result){
			$error->setError("Item could not be deleted from users inventory!");
			header("Location: /admin/character");
			die();
		}
		
		// Get items slots
		$result = $database->db_query("SELECT id FROM Items_has_Slots WHERE itemID = $iID");
		if(!$result){
			$error->setError("Couldn't get items slots!");
			header("Location: /admin/character");
			die();
		}
		while($row = mysqli_fetch_object($result)){
			$ihsID = $row->id;
			
			// Get Items_has_ItemSWF id
			$resultIhi = $database->db_query("SELECT itemswfID FROM Items_has_ItemSWF WHERE ihsID = $ihsID");
			if(!$resultIhi){
				$error->setError("Couldn't get items ItemSWF connection!");
				header("Location: /admin/character");
				die();
			}
			while($rowIhi = mysqli_fetch_object($resultIhi)){
				$itemswfID = $rowIhi->itemswfID;
				
				// Get Items ItemSWF
				$resultItemSWF = $database->db_query("SELECT link FROM ItemSWF WHERE itemswfID = $itemswfID");
				if(!$resultItemSWF){
					$error->setError("Couldn't get items ItemSWF!");
					header("Location: /admin/character");
					die();
				}
				$rowItemSWF = mysqli_fetch_object($resultItemSWF);
				
				// Unlink items swf
				if(!unlink("characterBuilder/items/".$rowItemSWF->link)) {
					$error->setError("Error: Items swf could not be deleted.");
					header("Location: /admin/character");
					die();
				}
				
				// Delete Items ItemSWF
				$resultDeleteItemSWF = $database->db_query("DELETE FROM ItemSWF WHERE itemswfID = $itemswfID");
				if(!$resultDeleteItemSWF){
					$error->setError("Error: Items ItemSWF could not be deleted");
					header("Location: /admin/character");
					die();
				}
					
			}
			
			// Delete Items Items_has_ItemSWF
			$resultDeleteIhi = $database->db_query("DELETE FROM Items_has_ItemSWF WHERE ihsID = $ihsID");
			if(!$resultDeleteIhi){
				$error->setError("Error: Items Items_has_ItemSWF could not be deleted");
				header("Location: /admin/character");
				die();
			}
			
		}
		
		// Delete Items Items_has_Slots
		$resultDeleteSlots = $database->db_query("DELETE FROM Items_has_Slots WHERE itemID = $iID");
		if(!$resultDeleteSlots){
			$error->setError("Error: Items Items_has_Slots could not be deleted");
			header("Location: /admin/character");
			die();
		}
	}
?>
