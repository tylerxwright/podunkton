<?php
/**
 *	Core.php
 *	This is the meat of podunkton
 *
 *	Written by Tyler Wright
 * 	Last Modified: 3.5.2008
 */

include_once("Constants.php");
include_once("Error.php");
include_once("Message.php");
include_once("Database.php");
include_once("Session.php");
include_once("PrettyPrint.php");
include_once("Podunkton.php");
include_once("SystemMessage.php");

class Core {

	var $args;
	var $oldurl;
	var $breadcrumb;
	var $core;
	
	function __construct() {
		$this->name = "core";
	}
	
	function setArgs($url){
		$this->oldurl = $_SESSION['url'] = $url;
		$this->args = explode('/', $url);
		
		$this->createBreadcrumb();
		
	}
	
	function months(){
		$month = array( '01'=>'Jan',
						'02'=>'Feb',
						'03'=>'Mar',
						'04'=>'Apr',
						'05'=>'May',
						'06'=>'Jun',
						'07'=>'Jul',
						'08'=>'Aug',
						'09'=>'Sep',
						'10'=>'Oct',
						'11'=>'Nov',
						'12'=>'Dec');
		return $month;
	}
	
	function createBreadcrumb() {
		$values = array();
		
		foreach($this->args as $arg){
			array_push($values, $arg);
			$this->breadcrumb .= "/<a href='";
			
			$str = '';
			foreach($values as $value){
				$str .= "/".$value;
			}
			
			$this->breadcrumb .= $str;
			
			$this->breadcrumb .= "'>$arg</a>";
		}
	}
}

$core = new Core;

?>