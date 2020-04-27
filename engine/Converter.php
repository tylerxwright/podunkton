<?php
/**
 *	Converter.php
 *	Converts tags into html
 *
 *	Written by Tyler Wright
 * 	Last Modified: 7.5.2008
 */

class Converter {
	
	var $tagArr;
	var $htmlStr;
	
	function __construct(){
		
		$this->tagArr = array();
		
		$this->createTags();
		$this->htmlStr = "";
		
	}
	
	function convert($tagCode, $name) {
		
		// Initial replacing
		for($i=0; $i<sizeof($this->tagArr); $i++){
			while(($pos=stripos($tagCode, $this->tagArr[$i][0], 0)) !== FALSE){
				$tagCode = substr_replace($tagCode, $this->tagArr[$i][1], $pos, strlen($this->tagArr[$i][0]));
				if($this->tagArr[$i][0] == "[url=") {
					$nextBar = stripos($tagCode, ']', $pos+strlen($this->tagArr[$i][1]));
					$distance = $nextBar-($pos+strlen($this->tagArr[$i][1]));
					$link = substr($tagCode, $pos+strlen($this->tagArr[$i][1]), $distance);
					//echo $link;
					$tagCode = substr_replace($tagCode, '', $nextBar, 1);
					$tagCode = str_replace($link, '', $tagCode);
					$tagCode = str_replace("%LINK%", $link, $tagCode);
				} else if($this->tagArr[$i][0] == "[img=") {
					$nextBar = stripos($tagCode, ']', $pos+strlen($this->tagArr[$i][1]));
					$distance = $nextBar-($pos+strlen($this->tagArr[$i][1]));
					$img = substr($tagCode, $pos+strlen($this->tagArr[$i][1]), $distance);
					
					if(stripos($img, "photobucket.com") === false) {
						break;
					}
					
					$tagCode = substr_replace($tagCode, '', $nextBar, 1);
					$tagCode = str_replace($img, '', $tagCode);
					$tagCode = str_replace("%IMG%", $img, $tagCode);
				}
				$this->tagArr[$i][2]++;
			}
		}
		
		// Fix unequal totals
		for($i=0; $i<sizeof($this->tagArr); $i+=2){
			if($this->tagArr[$i][2] > $this->tagArr[$i+1][2]){
				$diff = $this->tagArr[$i][2] - $this->tagArr[$i+1][2];
				for($j=0; $j<$diff; $j++){
					$tagCode .= $this->tagArr[$i+1][1];
				}
			}
		}
		
		// Fix lingering tags
		for($i=0; $i<sizeof($this->tagArr); $i+=2){
			$lastClosePos=strripos($tagCode, $this->tagArr[$i+1][1], 0);
			//echo $lastClosePos."<br/>";
			//echo stripos($tagCode, $this->tagArr[$i][1], $lastClosePos)."<br/>";
			$startPos = $lastClosePos;
			while(($pos=stripos($tagCode, $this->tagArr[$i][1], $startPos)) !== FALSE){
				if($pos > $lastClosePos) {
					$tagCode .= $this->tagArr[$i+1][1];
				}
				$startPos = $pos+1;
				if(strlen($tagCode) > $startPos){
					break;
				}
			}
		}
		
		$tagCode = str_replace("%NAMEVAR%", $name, $tagCode);
		
		return $tagCode;
		
	}
	
	function createTags() {
		$t = array("[b]", "<b>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/b]", "</b>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[i]", "<i>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/i]", "</i>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[u]", "<u>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/u]", "</u>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[strike]", "<del>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/strike]", "</del>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[alignleft]", "<div style='width: 100%; text-align: left;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/alignleft]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[aligncenter]", "<div style='width: 100%; text-align: center;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/aligncenter]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[alignright]", "<div style='width: 100%; text-align: right;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/alignright]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[fontsmall]", "<div style='font-size: 7pt;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/fontsmall]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[fontlarge]", "<div style='font-size: 12pt;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/fontlarge]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[quote]", "<div class='forums_quote_block'><div class='forums_quote_top'>Quote from <a class='blue' href='/user/%NAMEVAR%'>%NAMEVAR%</a></div><div class='forums_quote_bot'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/quote]", "</div></div><div style='height: 8px;'></div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[url=", "<a class='blue' href='%LINK%'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/url]", "</a>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[img=", "<img src='%IMG%' border='0' alt='test'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/img]", "</img>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[red]", "<div style='color: #FF0000;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/red]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[orange]", "<div style='color: #FFA500;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/orange]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[brown]", "<div style='color: #804C1F;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/brown]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[yellow]", "<div style='color: #FFFF00;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/yellow]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[green1]", "<div style='color: #008000;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/green1]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[green2]", "<div style='color: #808000;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/green2]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[blue1]", "<div style='color: #00FFFF;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/blue1]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[blue2]", "<div style='color: #0000FF;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/blue2]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[blue3]", "<div style='color: #00008B;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/blue3]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[purple]", "<div style='color: #4B0082;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/purple]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[pink]", "<div style='color: #EE82EE;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/pink]", "</div>", 0);
		array_push($this->tagArr, $t);
		
		$t = array("[white]", "<div style='color: #FFFFFF;'>", 0);
		array_push($this->tagArr, $t);
		$t = array("[/white]", "</div>", 0);
		array_push($this->tagArr, $t);
	}
	
}

$converter = new Converter;

?>