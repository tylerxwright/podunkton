<?php
/**
 *	Core.php
 *	This is the meat of podunkton
 *
 *	Written by Tyler Wright
 * 	Last Modified: 3.5.2008
 */

class Database {
	
	var $connection;
	var $name;
	
	function __construct(){
		
		global $error;
		$this->name = "Database";
		
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, "podunkton");
		if(!$this->connection){
			$error->setError("Could not connect");
		}
		//mysql_select_db(DB_NAME, $this->connection) or die(mysql_error);
		
	}
	
	function login($user, $pass){
		global $error;
		
		if(get_magic_quotes_gpc()){
			$user = addslashes($user);
			$pass = addslashes($pass);
		}
		
		$pass = md5($pass);
		
		$query = sprintf("SELECT userID, name FROM Users WHERE name='%s' AND password='%s'", $user, $pass);
		mysqli_real_escape_string($this->connection, $query);
		
		$result = mysqli_query($this->connection, $query);
		
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_object($result);
			$array = array(0 => $row->userID, 1 => $row->name);
		} else {
			$array = array(0 => 0, 1 => 0);
		}
		
		return $array;
	}
	
	function checkUserId($userid, $username){
		if(get_magic_quotes_gpc()){
			$userid = stripslashes($userid);
			$username = stripslashes($username);
		}
		
		$query = sprintf("SELECT userID, name FROM Users WHERE userID='%s' AND name='%s'", $userid, $username);
		mysqli_real_escape_string($this->connection, $query);
		
		$result = mysqli_query($this->connection, $query);
		
		if(mysqli_num_rows($result) == 1){
			return 1;
		} else {
			return 0;
		}
	}
	
	function register($uname, $pword, $sex, $date, $email, $aim, $msn, $icq){
		if(get_magic_quotes_gpc()){
			$uname = stripslashes($uname);
			$pword = stripslashes($pword);
			$sex = stripslashes($sex);
			$date = stripslashes($date);
			$email = stripslashes($email);
			$aim = stripslashes($aim);
			$msn = stripslashes($msn);
			$icq = stripslashes($icq);
		}
		
		$pword = md5($pword);
		
		$query = sprintf("INSERT INTO Users(name, password, sex, birthday, email, aim, msn, icq, goodevil, points, rankID, experience, featured, forumView, permissions) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %d, %d, %d, 0, '%s', 0)", $uname, $pword, $sex, $date, $email, $aim, $msn, $icq, 0, 0, 1, 0, "0", "Classic", 0);
		mysqli_real_escape_string($this->connection, $query);
		
		$result = mysqli_query($this->connection, $query);
		return 1;
	}
	
	function registerFull($uname, $pword, $sex, $date, $email, $aim, $msn, $icq, $goodevil, $points, $rankid, $experience, $favoriteToon, $favoriteGame, $featured, $forumView, $permissions){
		if(get_magic_quotes_gpc()){
			$uname = stripslashes($uname);
			$pword = stripslashes($pword);
			$sex = stripslashes($sex);
			$date = stripslashes($date);
			$email = stripslashes($email);
			$aim = stripslashes($aim);
			$msn = stripslashes($msn);
			$icq = stripslashes($icq);
			$goodevil = stripslashes($goodevil);
			$points = stripslashes($points);
			$rankid = stripslashes($rankid);
			$experience = stripslashes($experience);
			$favoriteToon = stripslashes($favoriteToon);
			$favoriteGame = stripslashes($favoriteGame);
			$featured = stripslashes($featured);
			$forumView = stripslashes($forumView);
			$permissions = stripslashes($permissions);
		}
		
		$pword = md5($pword);
		
		//$query = sprintf("INSERT INTO Users(name, password, sex, birthday, email, aim, msn, icq, goodevil, points, rankID, experience, favoriteToon, favoriteGame, featured, forumView, permissions) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %d, %d, %d, '%s', '%s', '%s', '%s', %d)", $uname, $pword, $sex, $date, $email, $aim, $msn, $icq, $goodevil, $points, $rankid, $experience, $favoriteToon, $favoriteGame, $featured. $forumView, $permissions);
		$query = "INSERT INTO Users(name, password, sex, birthday, email, aim, msn, icq, goodevil, points, rankID, experience, favoriteToon, favoriteGame, featured, forumView, permissions) VALUES('$uname', '$pword', '$sex', '$date', '$email', '$aim', '$msn', '$icq', $goodevil, $points, $rankid, $experience, $favoriteToon, $favoriteGame, $featured, '$forumView', $permissions)";
		
		mysqli_real_escape_string($this->connection, $query);
		
		$result = mysqli_query($this->connection, $query);
		
		return 1;
	}
	
	function getUserData($username){
		global $error;
		
		$data = array();
		
		if(get_magic_quotes_gpc()){
			$username = stripslashes($username);
		}
		
		$query = sprintf("SELECT userId, name, sex, email, aim, msn, icq, goodevil, points, experience, signup FROM Users WHERE name='%s'", $username);
		mysqli_real_escape_string($this->connection, $query);
		
		$result = mysqli_query($this->connection, $query);
		
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_object($result);
			foreach($row as $col){
				array_push($data, $col);
			}
			//return $data;
			return $row;
		} else {
			$error->setError("User doesn't exist");
			return 0;
		}
		
	}
	
	function db_query($query){
		global $error;
		
		mysqli_real_escape_string($this->connection, $query);
		
		$result = mysqli_query($this->connection, $query);
		return $result;
	}
	
	function close() {
		mysqli_close($this->connection);
	}
	
}

$database = new Database;

?>
