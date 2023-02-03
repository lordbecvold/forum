<?php // login controller
    namespace becwork\controller;

    class LoginController {

        // check if user can login
        public function canUserLogin($email, $password) {

			global $mysqlUtils;
			global $pageConfig;
            global $hashUtils;

            // get password hash
            $passwordHash = $hashUtils->genBlowFish($password);

			// build login query
			$query = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName('basedb')), "SELECT id FROM users WHERE email = '$email' AND password = '$passwordHash'"); 
						
			// get query results user row
			$count = mysqli_num_rows($query);
			
			// check if user with password exist
			if ($count == 1) {
				return true; 
			} else { 
				return false; 
			}             
        }

        // login user
        public function login($email) {

            global $mysqlUtils;
            global $pageConfig;

            // get user data by email
            $user = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM users WHERE email = '$email'");

            // get user data array
            $user = mysqli_fetch_assoc($user);

            // set login session
            $this->setLoginSession($user["token"]);

            // redirect to index
            header("location: /");
        }

		// set login session
		public function setLoginSession($token) {

			global $sessionUtils;
			global $pageConfig;
			global $userController;
			global $mysqlUtils;

			// start session
			$sessionUtils->sessionStartedCheckWithStart();

			// set token session
			$sessionUtils->setSession($pageConfig->getValueByName("loginCookie"), $pageConfig->getValueByName("loginValue"));		

			// set token session
			$sessionUtils->setSession("userToken", $token);

			// save role to session
			$sessionUtils->setSession("role", $userController->getUserRole());

			// log action to mysql
			$mysqlUtils->logToMysql("Success login", "user ".$userController->getUserName()." success login");
		}
    
		// set login cookie
		public function setLoginCookies($token) {

			global $cookieUtils;
			global $pageConfig;

			// set username cookie for next auth
			$cookieUtils->cookieSet("userToken", $token, time() + (60*60*24*7*365));

			// set token cookie for next login
			$cookieUtils->cookieSet($pageConfig->getValueByName("loginCookie"), $pageConfig->getValueByName("loginValue"), time() + (60*60*24*7*365));			
		}

		// unset login cookie
		public function unSetLoginCookies() {

			global $cookieUtils;
			global $pageConfig;

			// unset login key cookie
			$cookieUtils->unset_cookie($pageConfig->getValueByName("loginCookie"));

			// unset token
			$cookieUtils->unset_cookie("userToken");			
		}

		// auto user login (for cookie login)
		public function autoLogin() {
			
			global $sessionUtils;
			global $mysqlUtils;
			global $urlUtils;
			global $pageConfig;
			global $mainUtils;
			global $userController;

			// get user token
			$userToken = $_COOKIE["userToken"];

			// get user ip
			$userIP = $mainUtils->getRemoteAdress();

			// start session
			$sessionUtils->sessionStartedCheckWithStart();

			// set login identify session
			$sessionUtils->setSession($pageConfig->getValueByName('loginCookie'), $_COOKIE[$pageConfig->getValueByName('loginCookie')]);
 
			// set token session
			$sessionUtils->setSession("userToken", $userToken);

			// save role to session
			$sessionUtils->setSession("role", $userController->getUserRole());

			// log action to mysql
			$mysqlUtils->logToMysql("Success login", "user ".$userController->getUserName()." success login by login cookie");

			// update user ip
			$mysqlUtils->insertQuery("UPDATE users SET remote_addr='$userIP' WHERE token='$userToken'");

			// refresh page
			$urlUtils->redirect("/");
		}

		// logout user
		public function logout() {

			// init all classes
			global $cookieUtils;
			global $mysqlUtils;
			global $urlUtils;
			global $sessionUtils;
			global $pageConfig;
            global $userController;
			
			// destroy all sessions
			$sessionUtils->sessionDestroy();

			// unset login key cookie
			$cookieUtils->unset_cookie($pageConfig->getValueByName("loginCookie"));

			// unset username
			$cookieUtils->unset_cookie("userToken");

			// log logout to mysql dsatabase 
			if (!empty($userController->getUserName())) {

				// log logout action
				$mysqlUtils->logToMysql("Logout", "User ".$userController->getUserName()." logout out of site");
			}

			// redirect to index page
			$urlUtils->redirect("/");			
		}
    }
?>