<?php // this is the main class to include all active controllers in the application
    
    // require all controlers
    require_once(__DIR__."/controllers/SiteController.php");
    require_once(__DIR__."/controllers/UserController.php");
    
    // init controllers instances
    $siteController = new becwork\controller\SiteController();
    $userController = new becwork\controller\UserController();
?>