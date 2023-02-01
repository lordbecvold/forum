<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>
	<link href="assets/css/main.css" rel="stylesheet">
	<link href="assets/fontawesome/fontawesome.min.css" rel="stylesheet">
	<title><?php echo $pageConfig->getValueByName('appName'); ?></title>
</head>
<body>
	<?php // main site public/admin component redirect

		// get admin process (if used)
		$adminProcess = $siteController->getQueryString("admin");

		// get pocess value (if used)
		$process = $siteController->getQueryString("process");

		// check if admin process used
		if ($adminProcess != null) {
			
			// use admin system component
			include_once("admin/AdminMain.php");
		} 
		
		
		// check if process used (login)
		elseif ($process == "login") {

			// use login component
			include_once("components/LoginComponent.php");
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