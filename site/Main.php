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

		// check if admin process used
		if ($adminProcess != null) {
			
			// use admin system component
			include_once("admin/AdminMain.php");
		} else {

			// use main (public) site component
			include_once("components/MainComponent.php");
		}
	?>
</body>
</html>