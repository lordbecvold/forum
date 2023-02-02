<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link href="assets/css/main.css" rel="stylesheet">

	<?php // add favicon to app
		echo '<link rel="icon" href="assets/'.$pageConfig->getValueByName("favicon_path").'" type="image/x-icon"/>';
	?>

	<link href="assets/fontawesome/fontawesome.min.css" rel="stylesheet">
	<title><?php echo $pageConfig->getValueByName('appName'); ?></title>
</head>
<body>
	<?php // main site public/admin component redirect

		// AUTO LOGIN /////////////////////////////////////////////////////////
		if ($userController->isUserLogged() == false) {

			// check if cookie used
			if (isset($_COOKIE[$pageConfig->getValueByName('loginCookie')]) and isset($_COOKIE["userToken"])) {
            
				// auto login if user have token cookie
				if (isset($_COOKIE[$pageConfig->getValueByName('loginCookie')]) and isset($_COOKIE["userToken"])) {
	
					// check if token valid
					if ($_COOKIE[$pageConfig->getValueByName('loginCookie')] == $pageConfig->getValueByName('loginValue')) {
	
						// auto user login
						$loginController->autoLogin();
					}
				}				
			}
		}
		///////////////////////////////////////////////////////////////////////

		// get admin process (if used)
		$adminProcess = $siteController->getQueryString("admin");

		// get pocess value (if used)
		$process = $siteController->getQueryString("process");

		// check if admin process used
		if ($adminProcess != null) {
			
			// check if user logged in
			if ($userController->isUserLogged()) {

				// check if user admin
				if (($userController->getUserRole() == "Owner") || ($userController->getUserRole() == "Admin")) {

					// use admin system component
					include_once("admin/AdminMain.php");
				} else {
					header("location: ErrorHandlerer.php?code=403");
				}
			} else {
				header("location: ErrorHandlerer.php?code=404");
			}

		} 
		
		// check if process used (login)
		elseif ($process == "login") {

			// use login component
			include_once("components/LoginComponent.php");
		}

		// check if process used (logout)
		elseif ($process == "logout") {

			// logout user
			if ($userController->isUserLogged()) {
				$loginController->logout();
			} else {
				header("location: ErrorHandlerer.php?code=404");
			}
		}

		// check if process used (register)
		elseif ($process == "register") {

			// use registr component
			include_once("components/RegisterComponent.php");
		}

		// main default component
		else {

			// use main (public) site component
			include_once("components/MainComponent.php");
		}
	?>
</body>
</html>