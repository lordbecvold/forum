<?php 

    // get post ID from url
    $postID = $siteController->getQueryString("post");

    // get forum name from url
    $forumName = $siteController->getQueryString("forum");

    // check if url use valid parameters
    if ($postID == null or $forumName == null) {
        
        // redirect to error page
        header("location: ErrorHandlerer.php?code=400");
    } 
    
    // post content reader
    else {

        // post reader component
        echo '<div class="post-reader">';
    
        // get post data where ID
        $postData = $postsController->getPostDataByID($postID);

        // add path line
        echo '
            <div class="color-white">
                <a class="basic-link" href="/">board</a> / <a class="basic-link" href="?forum='.$forumName.'">forum</a> / <a class="basic-link" href="#">'.$postData["name"].'</a>
            </div>
        ';

        // add post title
        echo '<p class="post-title">'.$postData["name"].'</p>';

        // ADMIN USER-NAME COLOR
        if ($userController->getUserRoleByName($postData["author"]) == "Owner" || $userController->getUserRoleByName($postData["author"]) == "Admin") {
            $username = '<span class="post-author-name"><a class="profile-link color-red" href="?profile='.$postData["author"].'">'.$postData["author"].'</a></span>';

        // DEVELOPER USER-NAME COLOR
        } else if ($userController->getUserRoleByName($postData["author"]) == "Developer") {

            $username = '<span class="post-author-name"><a class="profile-link color-blue" href="?profile='.$postData["author"].'">'.$postData["author"].'</a></span>';

        // VIP USER-NAME COLOR
        } else if ($userController->getUserRoleByName($postData["author"]) == "VIP") {

            $username = '<span class="post-author-name"><a class="profile-link color-yellow" href="?profile='.$postData["author"].'">'.$postData["author"].'</a></span>';

        // USER USER-NAME COLOR
        } else if ($userController->getUserRoleByName($postData["author"]) == "User") {
            
            $username = '<span class="post-author-name"><a class="profile-link color-green" href="?profile='.$postData["author"].'">'.$postData["author"].'</a></span>';

        } else {

            // get unknow user role color
            $username = '<span class="post-author-name"><a class="profile-link" href="?profile='.$postData["author"].'">'.$postData["author"].'</a></span>';
        }


        // add post author line
        echo '
            <p class="post-author">
                <img class="post-author-avatar" src="data:image/jpeg;base64, '.$userController->getUserAvatar($postData["author"]).'"> 
                '.$username.'
                <span class="post-date-line">'.$postData["created_date"].'</span>
            </p>
        ';

        // add post content
        echo '
            <p class="post-content">
                '.$postData["content"].'
            </p>
        ';

        // end of post component
        echo '</div>';
    }
?>
