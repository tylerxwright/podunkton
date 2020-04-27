<?php
 /**
 *	PrettyPrint.php
 *	Makes things pretty
 *
 *	Written by Tyler Wright
 * 	Last Modified: 8.16.2008
 */

class PrettyPrint {
	
	var $fullMonths;
	var $smMonths;
	var $days;
	
	function __construct() {
		$this->defaults();
	}
	
	/* 
		Formats:
		M = August
		m = Aug
		D = 16th
		d = 16
		Y = 2008
		y = 08
		M D, Y = August 16th, 2008
	*/
	function prettyDate($str, $format) {
		
		$dateArr = array();
		$timeArr = array();
		
		$date = substr($str, 0, 10);
		
		if(strlen($str) > 11) {
			$time = substr($str, 10, strlen($str));
			$timeArr = explode(":", $time);
		}
		
		$dateArr = explode("-", $date);
		
		// Remove leading 0 on month
		if(substr($dateArr[1], 0, 1) == "0") {
			$dateArr[1] = substr($dateArr[1], 1, 1);
		}
		
		// Remove leading 0 on day
		if(substr($dateArr[2], 0, 1) == "0") {
			$dateArr[2] = substr($dateArr[2], 1, 1);
		}
		
		$dayNorm = $dateArr[2];
		
		switch($dayNorm) {
			case 1:
			case 21:
			case 31:
				$dayEnd = $dayNorm."st";
				break;
			case 2:
			case 22:
				$dayEnd = $dayNorm."nd";
				break;
			case 3:
			case 23:
				$dayEnd = $dayNorm."rd";
				break;
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
			case 10;
			case 11:
			case 12:
			case 13:
			case 14:
			case 15:
			case 16:
			case 17:
			case 18:
			case 19:
			case 20:
			case 24:
			case 25:
			case 26:
			case 27:
			case 28:
			case 29:
			case 30:
				$dayEnd = $dayNorm."th";
		}
		
		if(substr($timeArr[0], 0, 1) == "0") {
			$timeArr[0] = substr($timeArr[0], 1, 1);
		}
		
		if($timeArr[0] > 12) {
			$ampm = "pm";
			$timeArr[0] = $timeArr[0]-12;
		} else {
			$ampm = "am";
		}
		
		$time = $timeArr[0].":".$timeArr[1].":".$timeArr[2];
		
		$format = str_replace("[D]", $dayEnd, $format);
		$format = str_replace("[d]", $dayNorm, $format);
		$format = str_replace("[Y]", $dateArr[0], $format);
		$format = str_replace("[y]", substr($dateArr[0],2,2), $format);
		$format = str_replace("[M]", $this->fullMonths[$dateArr[1]], $format);
		$format = str_replace("[m]", $this->smMonths[$dateArr[1]], $format);
		$format = str_replace("[x]", $time, $format);
		$format = str_replace("[CZ]", strtoupper($ampm), $format);
		$format = str_replace("[cz]", $ampm, $format);
		
		$pretty = $format;
		
		return $pretty;
	}
	
	function smallString($str, $len) {
		$return = "";
		
		if(strlen($str) > $len) {
			$return = substr($str, 0, $len-3)."...";
		} else {
			$return = $str;
		}
		
		$return = stripslashes($return);
		
		return $return;
	}
	
	function defaults() {
		$this->fullMonths = array("",
								  "January",
								  "February",
								  "March",
								  "April",
								  "May",
								  "June",
								  "July",
								  "August",
								  "September",
								  "October",
								  "November",
								  "December");
		
		$this->smMonths = array("",
								"Jan.",
								"Feb.",
								"Mar.",
								"Apr.",
								"May.",
								"Jun.",
								"Jul.",
								"Aug.",
								"Sep.",
								"Oct.",
								"Nov.",
								"Dec.");
	}
	
	function stars($rating) {
		
		$return = "<div class='stars' style='width: 80px;'>";
		
		$fullStars = floor($rating);
		$half = $rating - $fullStars;
		
		if($half > .75) {
			$extra = 1;
			$backStars = 5 - ($fullStars+1);
		} elseif($half >= .25 AND $half <= .75) {
			$extra = 2;
			$backStars = 5 - ($fullStars+1);
		} else {
			$extra = 0;
			$backStars = 5 - $fullStars;
		}
		
		for($i=1; $i<=$fullStars; $i++) {
			$return .= "<div class='star_fill'></div>";
		}
		
		
		if($extra == 1) {
			$return .= "<div class='star_fill'></div>";
		} elseif($extra == 2) {
			$return .= "<div class='star_half'></div>";
		}
		
		for($i=1; $i<=$backStars; $i++) {
			$return .= "<div class='star_back'></div>";
		}
		
		$return .= "<div style='clear: both;'></div></div>";
		
		return $return;
	}
	
}

$prettyprint = new PrettyPrint;

?>
