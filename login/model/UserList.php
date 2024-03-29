<?php

namespace login\model;


require_once("UserCredentials.php");
require_once("common/model/PHPFileStorage.php");

/**
 * represents All users in the system
 *

 */
class UserList {
	/**
	 * Temporary solution with only one user "Admin" in PHPFileStorage
 	 * You might want to use a database instead.
	 * @var \common\model\PHPFileStorage
	 */
	private $adminFile;
	
	private $database;

	/**
	 * We only have one user in the system right now.
	 * @var array of UserCredentials
	 */
	private $users;


	public function  __construct( ) {
		$this->users = array();
		$this->loadUsers();
	}

	/**
	 * Do we have this user in this list?
	 * @throws  Exception if user provided is not in list
	 * @param  UserCredentials $fromClient
	 * @return UserCredentials from list
	 */
	public function findUser($fromClient) {
		foreach($this->users as $user) {
			if ($user->isSame($fromClient)) {
				\Debug::log("found User");
				return  $user;
			}
		}
		throw new \Exception("could not login, no matching user");
	}

	public function update($changedUser) {
		//this user needs to be saved since temporary password changed
		$this->adminFile->writeItem($changedUser->getUserName(), $changedUser->toString());

		\Debug::log("wrote changed user to file", true, $changedUser);
		$this->users[$changedUser->getUserName()->__toString()] = $changedUser;
	}

	/**
	 * Temporary function to store "Admin" user in file "data/admin.php"
	 * If no file is found a new one is created.
	 * 
	 * @return [type] [description]
	 */
	private function loadUsers() {
		
		$this->adminFile = new \common\model\PHPFileStorage("data/admin.php");
		try {
			//Read admin from file
			$adminUserString = $this->adminFile->readItem("Admin");
			$admin = UserCredentials::fromString($adminUserString);

		} catch (\Exception $e) {
			\Debug::log("Could not read file, creating new one", true, $e);

			//Create a new user
			$userName = new UserName("Admin");
			$password = Password::fromCleartext("Password");
			$admin = UserCredentials::create( $userName, $password);
			$this->update($admin);
		}

		$this->users[$admin->getUserName()->__toString()] = $admin;
		
		$connect = mysql_connect("localhost","Erik","") or die("Failed to Connect");
		mysql_select_db("php3_users",$connect) or die("Failed to select database");

		$query = mysql_query("SELECT * FROM user");
		
		$numrows = mysql_num_rows($query);
		if ($numrows != 0){
			while($row = mysql_fetch_assoc($query)){
				//create a new user
				$username = new UserName($row['Username']);
				$password = Password::fromCleartext($row['Password']);
				$user = UserCredentials::create($username, $password);
				$this->update($user);
			}//end of while	
		}
		mysql_close();
		
	}
	
	
	
	
}