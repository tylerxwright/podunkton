<?php
	global $core;
	global $database;
?>
<script language="JavaScript" type="text/javascript" src="/theme/scripts/toolman/core.js"></script>
<script language="JavaScript" type="text/javascript" src="/theme/scripts/toolman/events.js"></script>
<script language="JavaScript" type="text/javascript" src="/theme/scripts/toolman/css.js"></script>
<script language="JavaScript" type="text/javascript" src="/theme/scripts/toolman/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="/theme/scripts/toolman/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="/theme/scripts/toolman/dragsort.js"></script>
<script type="text/javascript">

	function ajaxFunction(str){
		try{
			xmlHttp = new XMLHttpRequest();
		} catch(e){
			try{
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e){
				try{
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch(e){
					alert("Your browser does not support AJAX!");
					return false;
				}
			}
		}
		xmlHttp.onreadystatechange = function(){
			if(xmlHttp.readyState==4){
				document.getElementById("test").innerHTML = xmlHttp.responseText;
			}
		}
		var url = "/process/admin_forum_reorder/"+str;
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);
	}
	
	
	var dragsort = ToolMan.dragsort()

	window.onload = function() {

		dragsort.makeListSortable(document.getElementById("phonetic3"), verticalOnly, saveOrder)
	}

	function verticalOnly(item) {
		item.toolManDragGroup.verticalOnly()
	}

	function speak(id, what) {
		var element = document.getElementById(id);
		element.innerHTML = 'Clicked ' + what;
	}

	function saveOrder(item) {
		var group = item.toolManDragGroup
		var list = group.element.parentNode
		var id = list.getAttribute("id")
		if (id == null) return
		group.register('dragend', function() {
			inputs = document.getElementsByTagName("li");
			buffer = "";
			for(i=0; i<inputs.length; i++){
				var brokenstring=inputs[i].innerHTML.split(':');
				inputs[i].innerHTML = (i+1)+":"+brokenstring[1];
				if(i == inputs.length-1){
					buffer += inputs[i].id;
				} else {
					buffer += inputs[i].id+"=";
				}
			}
			ajaxFunction(buffer);
		})
	}

</script>
<style>

</style>

Drag to reorder the categories
<ul id="phonetic3" class="boxy">
<?php
	$result = $database->db_query("SELECT categoryID, name, position FROM Forum_category ORDER BY position");
	
	$counter = 1;
	while($row = mysqli_fetch_object($result)){
		print "<li class='drag' id='".$row->categoryID."'>".$counter.": ".$row->name."</li>";
		$counter++;
	}
?>
</ul>

<p id="test">

</p>
