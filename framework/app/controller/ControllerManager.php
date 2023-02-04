<?php // this is the main class to include all active controllers in the application
    
    // require all controlers
    require_once(__DIR__."/controllers/SiteController.php");
    require_once(__DIR__."/controllers/UserController.php");
    require_once(__DIR__."/controllers/AlertController.php");
    require_once(__DIR__."/controllers/RegisterController.php");
    require_once(__DIR__."/controllers/LoginController.php");
    require_once(__DIR__."/controllers/BoardController.php");
    require_once(__DIR__."/controllers/PostsController.php");
    
    // init controllers instances
    $siteController = new becwork\controller\SiteController();
    $userController = new becwork\controller\UserController();
    $alertController = new becwork\controller\AlertController();
    $registerController = new becwork\controller\RegisterController();
    $loginController = new becwork\controller\LoginController();
    $boardController = new becwork\controller\BoardController();
    $postsController = new becwork\controller\PostsController();
?>