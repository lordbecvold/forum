<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>
	<link href="assets/css/main.css" rel="stylesheet">
	<title>Forum</title>
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