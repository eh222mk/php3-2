<?php

namespace register\model;

require_once("common/model/Database.php");

class RegisterModel{
	
	private $database = "";
	
	private $message = "";
	
	private $success = true;
	
	
	public function __construct(){
		$this->database = new \common\model\Database();
	}
	
	public function ifRegistered(){
		return $this->success;	
	}
	
	public function checkUserCredential($username, $password, $repeatPassword){
		$this->message = "";
		$username = $this->checkInvalidCharacters($username);
		if($this->success){
			if(strlen($username) > 9){
				$this->message .= "<p>Användarnamnet är för långt, ange ett användarnamn under 30 tecken.</p>";
				$this->success = false;
			}
			else if(strlen($username) < 3){
				$this->message .= "<p>Användarnamnet är för kort, ange ett användarnamn över 4 tecken.</p>";
				$this->success = false;
			}
			if(strlen($password) > 16){
				$this->message .= "<p>Lösenordet är för långt, ange ett lösenord under 50 tecken.</p>";
				$this->success = false;
			}
			else if(strlen($password) < 6){
				$this->message .= "<p>Lösenordet är för kort, ange ett lösenord över 5 tecken.</p>";
				$this->success = false;
			}
			if($password != $repeatPassword){
				$this->message .= "<p>Lösenorden stämmer inte överens!</p>";
				$this->success = false;
			}
			
			if($this->success){
				$this->doRegister($username, $password);	
			}
		}
		return $this->message;
	}
	
	private function checkInvalidCharacters($username){
		
		if($username != strip_tags($username)){
			$username = strip_tags($username);
			$this->success = false;
			$this->message = "<p>Användarnamnet innehåller ogiltiga tecken.</p>";
		}
		$_SESSION["registerUsername"] = $username;
		return $username;
	}
	
	private function doRegister($username, $password){
		if($this->database->ifUserExistInDatabase($username) || $username == "Admin"){
			$this->message .= "<p>Användarnamnet existerar redan.</p>";
		}
		else{
			$this->database->insertUserInDatabase($username, $password);
			//$this->message .= "<p>Registrering lyckades.</p>";
			$_SESSION["message"] = "<p>Registrering lyckades.</p>";
			header("location: ../php3-2/");
		}
	}
	
}
