<?php // default user controller

    namespace becwork\controller;

    class UserController {

        // check if user logged
        public function isUserLogged() {

			global $sessionUtils;
			global $pageConfig;

			// start session
			$sessionUtils->sessionStartedCheckWithStart();

			// check if login cookie seted
			if (isset($_SESSION[$pageConfig->getValueByName('loginCookie')])) {
				
				// check if login cookie is valid
				if ($_SESSION[$pageConfig->getValueByName('loginCookie')] == $pageConfig->getValueByName('loginValue')) {
					return true;
				} else {
					return false;
				}

			// check if token is null
			} elseif ($this->getUserToken() != NULL) {
				return false;
			} else {
				return false;
			}
        }
    
        // get current username
        public function getUserName() {

			global $mysqlUtils;
            global $loginController;

			// check if user token is not null
			if ($this->getUserToken() != NULL) {
				
				// return username
				return $mysqlUtils->readFromMysql("SELECT username FROM users WHERE token = '".$this->getUserToken()."'", "username");
			} else {
				$loginController->logout();
			}
        }

        // get user token
        public function getUserToken() {

			global $mysqlUtils;
			global $pageConfig;

			// check if user token in session
			if (!empty($_SESSION["userToken"])) {
				
				// get token count
				$count = mysqli_fetch_assoc(mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName('basedb')), "SELECT COUNT(*) AS count FROM users WHERE token='".$_SESSION["userToken"]."'"))["count"];
				
				// check if token exist in users
				if ($count == "1") {
					return $_SESSION["userToken"];
				} else {
					return NULL;
				}

			} else {
				return NULL;
			}
        }

        // get user role
        public function getUserRole() {

			global $mysqlUtils;
			global $pageConfig;

			// get token count
			$count = mysqli_fetch_assoc(mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName('basedb')), "SELECT COUNT(*) AS count FROM users WHERE token='".$this->getUserToken()."'"))["count"];
				
			// check if token exist in users
			if ($count == "1") {

				// check if user token is null
				if ($this->getUserToken() != NULL) {

					// get user role from database
					$userRole = $mysqlUtils->readFromMysql("SELECT role FROM users WHERE token = '".$this->getUserToken()."'", "role");
					 
					// get user role output
					if (strtolower(($userRole)) == "owner") {
						$role = "Owner";
					} elseif (strtolower($userRole) == "admin") {
						$role = "Admin";
					} elseif (strtolower($userRole) == "developer") {
						$role = "Developer";
					} elseif (strtolower($userRole) == "vip") {
						$role = "VIP";
					} else {
						$role = "User";
					}
				
					// final role output
					return $role;
					
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
        }

		// check if user is admin
		public function checkIsUserAdmin() {

			// check if user logged in
			if ($this->isUserLogged()) {

				// check if user admin
				if (($this->getUserRole() == "Owner") || ($this->getUserRole() == "Admin")) {
					$output = true;
			
				} else {
					$output = false;
				}

			} else {
			
				$output = false;
			}

			// return final output
			return $output;
		}
    }
?>