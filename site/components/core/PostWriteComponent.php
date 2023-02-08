<?php 

    // check if user logged in
    if ($userController->isUserLogged()) {

        // get forum name from url
        $forum = $siteController->getQueryString("forum");  
    
        // check if forum is not null
        if ($forum != null) {
    
            echo "new post componnt in ".$forum;
        }
    } else {
        $alertController->normalAlert(
            "Only a logged in user can create a new thread!
            <br>
            <a href='?process=login' class='basic-link'>login here</a>
            "
        );
    }

?>