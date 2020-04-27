<?php
/**
 *	Message.php
 *	Allows us to pass messages
 *
 *	Written by Tyler Wright
 * 	Last Modified: 7.6.2008
 */

class Message {
	
	var $msg;
	
	function __construct(){
		
	}
	
	function start(){
		if(isset($_SESSION['message'])){
			$this->msg = $_SESSION['message'];
		}
	}
	
	function setMsg($string){
		if(!isset($_SESSION['message'])){
			$_SESSION['message'] = $string;
		} else {
			$_SESSION['message'] .= "<br/>".$string;
		}
	}
	
	function getMsg(){
		unset($_SESSION['message']);
		return $this->msg;
	}
	
}

$msgObj = new Message;

?>