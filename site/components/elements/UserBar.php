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
                    echo " <span class='welcome-header'>Welcome: [". $userController->getUserName()." - (".$userController->getUserRole().")]</span>";
                } else {
                    echo " <span class='welcome-header'>Welcome on ". $pageConfig->getValueByName('appName')."</span>";
                }
            ?>
        </span>
        <span class="right">
            <?php 
                // check if user logged in
                if ($userController->isUserLogged()) {
                    echo '<a href="?process=logout" class="user-input-field">Logout</a>';
                } else {
                    
                    // get process name
                    $process = $siteController->getQueryString("process");

                    // check if process is not login
                    if ($process != "login") {

                        // add login button to user bar
                        echo '<a href="?process=login" class="user-input-field">Login</a>';
                    }

                    // check if process is not register
                    if ($process != "register") {

                        // add register button to user bar
                        echo '<a href="?process=register" class="user-input-field">Register</a>';
                    }
                }
            ?>
        </span>
    </p>
</div>