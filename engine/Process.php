<?php
/**
 *	process.php
 *	Holds all of our constants
 *
 *	Written by Tyler Wright
 * 	Last Modified: 3.5.2008
 */

class Process {
	
	function __construct(){
		global $core;
		global $session;
		
		//echo $this->selfURL();
		// This needs to verify that the http_referer is our site
		/*if(!isset($_SERVER['HTTP_REFERER'])){
			echo "bad";
			return;
		} else {
			echo "goood";
		}*/
		
		// Another thing I would like to do is make this
		// Switch the args and then call a file in /engine/pscripts
		// Also it needs to set a session to make it valid which
		// the files in pscripts check against
		
		include_once("engine/process/".$core->args[1].".php");
		
	}
	
}

$process = new Process;

?>
