<?php
	global $core;
	global $database;
	global $session;
?>

<script type="text/javascript" src="/engine/jquery.js"></script>
<script type="text/javascript">
	
	var ajax = new Ajax();
	var itemPage = 1;
	var skinPage = 1;
	var physicalPage = 1;
	var num = 3;
	var mouseX, mouseY;
	var detailsBoxUp = 0;
	
	$(document).ready(function() {
		ajax.doGet("/process/getAdminItems/1", showItems);
		//ajax.doGet("/process/getAdminSkins/1", showSkins);
		//ajax.doGet("/process/getAdminPhysicals/1", showPhysicals);
	});
	
	function showItems(str){
		var itemBox = document.getElementById("itemList");
		itemBox.innerHTML = str;
	}
	
	function showSkins(str){
		var itemBox = document.getElementById("skinList");
		itemBox.innerHTML = str;
	}
	
	function showPhysicals(str){
		var itemBox = document.getElementById("physicalList");
		itemBox.innerHTML = str;
	}
	
	function getDetails(type, id){
		var detailsBox = document.getElementById("detailsBox");
		
		detailsBoxUp = 1;
		
		if(type == 1){
			ajax.doGet("/process/getAdminItemsDetails/"+id, showDetails);
		}
		
		detailsBox.innerHTML = "<div style='width: 100%; text-align: center; padding-top: 20px;'><b>LOADING</b><br/><img src='/theme/images/ajax-loader.gif' /></div>";
		detailsBox.style.display = "block";
		detailsBox.style.top = mouseY+"px";
		detailsBox.style.left = mouseX+20+"px";
		
	}
	
	function showDetails(str){
		var detailsBox = document.getElementById("detailsBox");
		detailsBox.innerHTML = str;
	}
	
	function closeDetails(){
		var detailsBox = document.getElementById("detailsBox");
		detailsBoxUp = 0;
		detailsBox.innerHTML = "";
		detailsBox.style.display = "none";
	}
	
	function changeItemsPage(obj){
		itemPage = obj.options[obj.selectedIndex].value;
		ajax.doGet("/process/getAdminItems/"+itemPage, showItems);
	}
	
	function deleteItem(itemID){
		var answer = confirm ("Are you sure you want to delete this item?")
		if (answer){
			location="/process/deleteItem/"+itemID;
		} else {
			return false;
		}
	}
	
	function clicked(id) {
		$('div#box'+id).slideToggle("slow");
		for(var i=1; i<=num; i++) {
			if(id != i) {
				$('div#box'+i).slideUp("slow");
			}
		}
	}
	
	function getMousePos(e){
		if (!e)
			var e = window.event||window.Event;
		
		if('undefined'!=typeof e.pageX){
			mouseX = e.pageX;
			mouseY = e.pageY;
		} else {
			mouseX = e.clientX + document.body.scrollLeft;
			mouseY = e.clientY + document.body.scrollTop;
		}
	
		if(detailsBoxUp == 1){
			var detailsBox = document.getElementById("detailsBox");
			detailsBox.style.top = mouseY+"px";
			detailsBox.style.left = mouseX+20+"px";
		}
	
	}
	
	// You need to tell Mozilla to start listening:
	
	if(window.Event && document.captureEvents)
	document.captureEvents(Event.MOUSEMOVE);
	
	// Then assign the mouse handler
	
	document.onmousemove = getMousePos;
	
	function editHere(id) {
		var element = document.getElementById(id);
		element.style.display = "block";
	}
	
</script>

<div id="detailsBox"></div>

<div style="font-size: 14pt; font-weight: bold; float: left; margin-top: 5px;">Character Admin</div>
<div style="clear: both; margin-bottom: 8px;"></div>

<div class="genreBar">
	<div class="genreName"><a class="white" href="#">Items</a></div>
	<div class="genreRight">
		<div title="View Details" class="slideBtn" onclick="clicked(1);"></div>
		<div title="Edit" style="float: left; padding-top: 2px; padding-right: 2px;"><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/character/item/add';" title="Add a new item" src="/theme/images/icons/add.png" width="15" height="15"/></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box1" class="genreDesc" style="display: block;">
	<div class="albumHolder">
		<div style="width: 100%; text-align: right; padding-bottom: 5px; border-bottom: solid 1px #333;">
			<select id="itemPager" onchange="changeItemsPage(this)">
				<?php
					$result = $database->db_query("SELECT COUNT(itemID) as 'count' FROM Items WHERE groups=0");
					$row = mysqli_fetch_object($result);
					for($i=1; $i<=ceil($row->count/ADMIN_ITEMS_PER_PAGE); $i++){
				?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select> Total: <?php echo $row->count; ?>
		</div>
		<div style="width: 100%;" id="itemList"></div>
		<div style="width: 100%; text-align: right; padding-top: 5px;">
			<select id="itemPager2" onchange="changeItemsPage(this)">
				<?php
					for($i=1; $i<=ceil($row->count/ADMIN_ITEMS_PER_PAGE); $i++){
				?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select> Total: <?php echo $row->count; ?>
		</div>
	</div>
</div>

<div class="genreBar">
	<div class="genreName"><a class="white" href="#">Skins</a></div>
	<div class="genreRight">
		<div title="View Details" class="slideBtn" onclick="clicked(2);"></div>
		<div title="Edit" style="float: left; padding-top: 2px; padding-right: 2px;"><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/character/skin/add';" title="Add a new skin" src="/theme/images/icons/add.png" width="15" height="15"/></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box2" class="genreDesc" style="display: none;">
	<div class="albumHolder" id="skinList">
		hi
	</div>
</div>

<div class="genreBar">
	<div class="genreName"><a class="white" href="#">Physical Items</a></div>
	<div class="genreRight">
		<div title="View Details" class="slideBtn" onclick="clicked(3);"></div>
		<div title="Edit" style="float: left; padding-top: 2px; padding-right: 2px;"><img border="0" style="cursor: pointer; margin-left: 10px;" onclick="location='/admin/character/physical/add';" title="Add a new physical item" src="/theme/images/icons/add.png" width="15" height="15"/></div>
		<div style="clear: both;"></div>
	</div>
</div>
<div id="box3" class="genreDesc" style="display: none;">
	<div class="albumHolder" id="physicalList">
		<?php
			$result = $database->db_query("SELECT * FROM Physical_Features ORDER BY type, dateAdded");
			while($row = mysqli_fetch_object($result)){
		?>
			<div style="float: left; padding-right: 3px; padding-bottom: 3px;"><img src="/characterBuilder/images/<?php echo $row->png; ?>" /></div>
		<?php
			}
		?>
		<div style="clear: both;"></div>
	</div>
</div>