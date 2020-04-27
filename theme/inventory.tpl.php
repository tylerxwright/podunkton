<?php
	$user = $session->user;
	if($user){
?>
<script type="text/javascript">
	var ajax = new Ajax();
	
	function getDetails(type, id){
		var detailsBox = document.getElementById("detailsBox");
		
		detailsBoxUp = 1;
		
		if(type == 1){
			ajax.doGet("/process/getItemsDetails/"+id, showDetails);
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
			
			var pageWidth = document.documentElement.clientWidth;
			
			if(mouseX+40+300 >= pageWidth){
				mouseX = mouseX - 300 - 40;
			}
			
			detailsBox.style.top = mouseY+"px";
			detailsBox.style.left = mouseX+20+"px";
		}
	
	}
	
	// You need to tell Mozilla to start listening:
	
	if(window.Event && document.captureEvents)
	document.captureEvents(Event.MOUSEMOVE);
	
	// Then assign the mouse handler
	
	document.onmousemove = getMousePos;
	
</script>

<link rel="stylesheet" type="text/css" href="/theme/scripts/trade.css" />
<div id="detailsBox"></div>
<a class="blue" href="/user/<?php echo $session->username; ?>">Back to your user page</a><br/>
<div id="shops_toolbox" style="margin-top: 8px; margin-left: 8px;">
	<div class="site_box" style="width: 775px;">
		<div class="site_box_head">
			<div class="shops_title">MY INVENTORY</div>
		</div>
		<div class="site_box_content" style="background-color: #fff;">
			<div class="inventory_box_hack" id="myInventory">
				<?php
					$resultI = $database->db_query("SELECT uhi.id, i.itemID, i.name, i.png FROM Items as i JOIN Users_has_Items as uhi ON i.itemID = uhi.itemID_FK JOIN Users as u ON uhi.userID_FK = u.userID WHERE userID = $user AND groups=0 AND trading = 0 ORDER BY name ASC");
					$counter = 0;
					while($rowI = mysqli_fetch_object($resultI)) {
				?>
						<img src="/characterBuilder/images/<?php echo $rowI->png; ?>"  onmouseover="getDetails(1, <?php echo $rowI->itemID; ?>);" onmouseout="closeDetails();" />
				<?php 
						$counter++;
					} 
				?>
			</div>
		</div>
	</div>
</div>
<?php } else { 
	include_once("theme/errordocs/404.tpl.php");
} ?>