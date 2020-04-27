<script type="text/javascript">
	
	var start = 0;
	var maxHit = 0;
	var ajax = new Ajax();
	
	var doPoll = function() {
		start = new Date();
		start = start.getTime();
		ajax.doGet("/process/testAjax/"+start, showPoll);
	}
	
	window.onload = doPoll;
	
	var showPoll = function(str) {
		var pollResult = "";
		var diff = 0;
		var end = new Date();
		if(str == "ok") {
			end = end.getTime();
			diff = (end - start) / 1000;
			pollResult = diff;
		} else {
			pollResult = "error";
		}
		printResult(pollResult);
		var pollHand = setTimeout(doPoll, 100); // wait 15 seconds
	}
	
	function printResult(str) {
		/*var pollDiv = document.getElementById("pollDiv");
		if(pollDiv.firstChild) {
			pollDiv.removeChild(pollDiv.firstChild);
		}
		pollDiv.appendChild(document.createTextNode(str));*/
		
		// could just use innerHTML here
		document.getElementById('bar').style.width = (str*1000)+"px";
		document.getElementById('pollDiv').innerHTML = "Server response time: "+str+" seconds";
		
		if(str == "error"){
			document.getElementById("working").style.color = "#990000";
			document.getElementById("working").innerHTML = "Not Working";
		} else {
			document.getElementById("working").style.color = "#00cc00";
			document.getElementById("working").innerHTML = "Working";
		}
		
		if(str > maxHit) {
			maxHit = str;
			document.getElementById("max").innerHTML = "Max Delay: "+str;
		}
	}
	
</script>
<h2>Ajax Test Page <span id="working" style="color: #990000;"></span></h2>
<div id="bar" style="width: 0px; height: 10px; background-color: #009900"></div>
<div id="pollDiv"></div>
<div id="max"></div>