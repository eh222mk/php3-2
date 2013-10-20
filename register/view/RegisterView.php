<?php

namespace register\view;


class RegisterView{
	
	private $registrationMessage = "";
	
	public function getUsername(){
		return $_POST["registerUsername"];
	}
	
	public function getPassword(){
		return $_POST["registerPassword"];
	}
	
	public function getRepeatPassword(){
		return $_POST["repeatRegisterPassword"];
	}
		
	public function ifRegisterUser(){
		if(isset($_POST["registerUser"])){
			return true;
		}
		return false;
	}
	
	public function ifRegisterAttempt(){
		if(isset($_POST["register"])){
			return true;
		}
		return false;
	}
	
	public function setRegistrationMessage($message){
		$this->registrationMessage = $message;
	}
	
	public function registrationMessage(){
		echo "$this->registrationMessage";
	}
}
