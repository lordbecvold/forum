<?php 

    // get forum name (if set)
    $forum = $siteController->getQueryString("forum");   

    // check if forum seted
    if ($forum != null) {

        echo "browser: " . $forum;

    } else {

        // redirect to 400 if forum null
        header("location: ErrorHandlerer.php?code=400");        
    }
?>