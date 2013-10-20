<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("login/controller/LoginController.php");
require_once("register/controller/registerController.php");

/**
 * Main application controller
 */
class Application {
	/**
	 * \view\view
	 * @var [type]
	 */
	private $view;

	/**
	 * @var \login\controller\LoginController
	 */
	private $loginController;
	
	private $registerController;
	
	public function __construct() {
		$this->registerController = new \register\controller\RegisterController();
	
		$loginView = new \login\view\LoginView();
		
		$this->loginController = new \login\controller\LoginController($loginView);
		$this->view = new \application\view\View($loginView);
		
	}
	
	/**
	 * @return \common\view\Page
	 */
	public function doFrontPage() {
		if($this->registerController->doRegisterPage()){
			$registerView = $this->registerController->doRegister();
			return $this->view->getRegisterPage();
		}
		else{
			$this->loginController->doToggleLogin();
			if ($this->loginController->isLoggedIn()) {
				$loggedInUserCredentials = $this->loginController->getLoggedInUser();
				return $this->view->getLoggedInPage($loggedInUserCredentials);	
			} else {
				return $this->view->getLoggedOutPage();
			}
		}
	}//end of method

}
