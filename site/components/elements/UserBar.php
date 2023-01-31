<div class="user-bar">
    <p>
        <span class="left">
            <?php 
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
                    echo '<a href="#" class="user-bar-link">Login</a>';
                    echo '<a href="#" class="user-bar-link">Register</a>';
                }
            ?>
        </span>
    </p>
</div>