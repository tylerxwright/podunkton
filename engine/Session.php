<?php
/**
 *	session.php
 *	Holds all of our constants
 *
 *	Written by Tyler Wright
 * 	Last Modified: 3.5.2008
 */

class Session {
	
	var $user;
	var $username;
	var $admin;
	var $referrer;
	var $sessionid;
	var $usersOnline;
	var $beta;
	
	function __construct(){
		global $error;
		global $msgObj;
		
		session_start();
		$this->sessionid = session_id();
		
		$error->start();
		$msgObj->start();
		
		$this->checkLogin();
		
		$this->usersOnline();
		
		if(isset($_SESSION['url'])){
			$this->referrer = $_SESSION['url'];
		} else {
			$this->referrer = "/";
		}
		
		$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
		//$this->url = $_SESSION['url'] = "/";
	}
	
	function checkLogin(){
		global $database;
		
		$this->admin = 0;
		
		// If the user has a cookie set
		if(isset($_COOKIE['username']) && isset($_COOKIE['userid'])){
			$this->user = $_SESSION['userID'] = $_COOKIE['userid'];
			$this->username = $_SESSION['username'] = $_COOKIE['username'];
		}
		
		if(isset($_SESSION['userID']) && isset($_SESSION['username'])){
			if($database->checkUserId($_SESSION['userID'], $_SESSION['username']) != 0){
				$this->user = $_SESSION['userID'];
				$this->username = $_SESSION['username'];
			} else {
				unset($_SESSION['userID']);
				unset($_SESSION['username']);
				$this->username = "GUEST";
				$this->user = 0;
			}
			
			$result = $database->db_query("SELECT permissions FROM Users WHERE userID = ".$this->user);
			$row = mysqli_fetch_object($result);
			$this->admin = $row->permissions;
			
			$_SESSION['beta'] = 1;
		} else {
			$this->username = "GUEST";
			return 0;
		}
	}
	
	function login($un, $pw, $rm){
		global $database;
		
		$success = 0;
		
		$user = $database->login($un, $pw);
		
		if($user[0]){
			$success = 1;
			$_SESSION['userID'] = $user[0];
			$_SESSION['username'] = $user[1];
		} else {
			$success = 0;
			return $success;
		}
		$this->user = $user[0];
		$this->username = $user[1];
		
		if($rm == 1){
			setcookie('username', $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
			setcookie('userid', $this->user, time()+COOKIE_EXPIRE, COOKIE_PATH);
		}
		
		return $success;
	}
	
	function logout(){
		$this->user = 0;
		$this->username = "GUEST";
		
		unset($_SESSION['userID']);
		unset($_SESSION['username']);
		
		if(isset($_COOKIE['username']) && isset($_COOKIE['userid'])){
			setcookie('username', "", time()-COOKIE_EXPIRE, COOKIE_PATH);
			setcookie('userid', "", time()-COOKIE_EXPIRE, COOKIE_PATH);
		}
	}
	
	function register($uname, $pword, $sex, $date, $email, $aim, $msn, $icq){
		global $database;
		$success = $database->register($uname, $pword, $sex, $date, $email, $aim, $msn, $icq);
		return $success;
	}
	
	// This is for everyone whos online guests and users
	// We can change this to differentiate between users and guests
	// Also base it off of ip address
	function usersOnline(){
		global $database;
		$time = time();
		$timech=$time-300;
		
		$ip = $_SERVER['REMOTE_ADDR'];
		
		//$result = mysqli_query("SELECT * FROM Users_online WHERE sessionid='".$this->sessionid."'");
		$result = mysqli_query($database->connection, "SELECT * FROM Users_online WHERE sessionid='".$ip."'");
		$num = mysqli_num_rows($result);
		
		if($num == "0"){
			//$result1 = mysqli_query("INSERT INTO Users_online (sessionid, time)VALUES('".$this->sessionid."', '$time')");
			if($this->user) {
				$result1 = mysqli_query($database->connection, "INSERT INTO Users_online (sessionid, time, userid)VALUES('".$ip."', '$time', ".$this->user.")");
			} else {
				$result1 = mysqli_query($database->connection, "INSERT INTO Users_online (sessionid, time, userid)VALUES('".$ip."', '$time')");
			}
		}else{
			//$result2 = mysqli_query("UPDATE Users_online SET time='$time' WHERE session = '".$this->sessionid."'");
			$result2 = mysqli_query($database->connection, "UPDATE Users_online SET time='$time' WHERE sessionid = '".$ip."'");
		}
		
		mysqli_query($database->connection, "DELETE FROM Users_online WHERE time<$timech");
		
		$result3 = mysqli_query($database->connection, "SELECT * FROM Users_online"); 
		
		$usersonline = mysqli_num_rows($result3);
		$this->usersOnline = $usersonline; 
	}
}

$session = new Session;

?>