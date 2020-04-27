<?php
/**
 *	error.php
 *	Holds all of our constants
 *
 *	Written by Tyler Wright
 * 	Last Modified: 3.5.2008
 */

class Err {
	
	var $errorMsg;
	
	function __construct(){
		
	}
	
	function start(){
		if(isset($_SESSION['error'])){
			$this->errorMsg = $_SESSION['error'];
		}
	}
	
	function setError($string){
		if(!isset($_SESSION['error'])){
			$_SESSION['error'] = $string;
		} else {
			$_SESSION['error'] .= "<br/>".$string;
		}
	}
	
	function getError(){
		unset($_SESSION['error']);
		return $this->errorMsg;
	}
	
}

$error = new Err;

?>