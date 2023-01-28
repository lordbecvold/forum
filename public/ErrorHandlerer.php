<?php // error site handlerer
    if (isset($_GET["code"])) {

        // get error code form url
        $code = $_GET["code"];

        // error page by code
        if ($code == 404) {
            include_once("../site/errors/404.php");
        } else if ($code == 403) {
            include_once("../site/errors/403.php");
        } else if ($code == 400) {
            include_once("../site/errors/400.php");
        } else {
            include_once("../site/errors/UnknownError.php");
        }
    } else {
        include_once("../site/errors/404.php");
    }
?>