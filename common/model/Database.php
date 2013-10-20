<?php

namespace common\model;

class Database{
	
	public function connectToDatabase(){
		$connect = mysql_connect("localhost","Erik","") or die("Failed to Connect");
		mysql_select_db("php3_users",$connect) or die("Failed to select database");	
	}
	
	public function insertUserInDatabase($username, $password){
		$this->connectToDatabase();		
		$query = "INSERT INTO user(Username,Password) VALUES (\"" . $username . "\",\"" . $password . "\")";
		mysql_query($query);
		mysql_close();
	}
	
	public function ifUserExistInDatabase($username){
		$this->connectToDatabase();
		$query = mysql_query("SELECT Username FROM user");
		
		$numrows = mysql_num_rows($query);
		if ($numrows != 0){
			while($row = mysql_fetch_assoc($query)){
				if($row['Username'] == $username){
					mysql_close();
					return true;
				}
			}//end of while	
		}
		mysql_close();
		return false;
	}//end of getUsers
	
	
}
