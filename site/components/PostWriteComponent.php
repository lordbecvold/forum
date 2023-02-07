<?php 

    // get forum name from url
    $forum = $siteController->getQueryString("forum");  

    if ($forum != null) {

        echo "new post componnt in ".$forum;
    }
?>