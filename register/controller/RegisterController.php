<?php

namespace register\controller;

require_once("register/view/RegisterView.php");
require_once("register/model/RegisterModel.php");

class RegisterController{
	
	private $registerView;
	private $registerModel;
	
	public function __construct(){
		$this->registerView = new \register\view\RegisterView();
		$this->registerModel = new \register\model\RegisterModel();
	}
	
	public function doRegisterPage(){
		if(isset($_SESSION["message"])){
			return false;
		}
		if($this->registerView->ifRegisterUser()){
			return true;	
		}
		if($this->registerView->ifRegisterAttempt()){
			return true;
		}
		return false;
	}
	
	public function doRegister(){
		if($this->registerView->ifRegisterUser()){
			$username = $this->registerView->getUsername();	
			$password = $this->registerView->getPassword();
			$repeatPassword = $this->registerView->getRepeatPassword();
			
			
			$message = $this->registerModel->checkUserCredential($username, $password, $repeatPassword);
			$this->registerView->setRegistrationMessage($message);
			$this->registerView->registrationMessage();
		}
	}
	
}
