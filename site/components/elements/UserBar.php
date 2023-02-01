<div class="user-bar">
    <p>
        <span class="left">
            <?php 

                // get process name form query
                $process = $siteController->getQueryString("process");

                // check if process is null
                if ($process != null) {

                    // add home button to user bar
                    echo '<a class="nav-link nav-link-small" href="/"><i class="fas fa-home"></i></a>';
                }

                // check if user logged in
                if ($userController->isUserLogged()) {
                    echo " <span class='welcome-header'>Welcome: [". $userController->getUserName()."]</span>";
                } else {
                    echo " <span class='welcome-header'>Welcome on ". $pageConfig->getValueByName('appName')."</span>";
                }
            ?>
        </span>
        <span class="right">
            <?php 
                // check if user logged in
                if ($userController->isUserLogged()) {
                    echo '<a href="#" class="user-bar-link">Logout</a>';
                } else {
                    echo '<a href="?process=login" class="user-bar-link">Login</a>';
                    
                    $process = $siteController->getQueryString("process");

                    if ($process != "register") {
                        echo '<a href="?process=register" class="user-bar-link">Register</a>';
                    }
                }
            ?>
        </span>
    </p>
</div>