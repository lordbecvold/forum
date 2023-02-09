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

        // check if user logged in
        if ($userController->isUserLogged()) {

            // check if submit comment
            if (isset($_POST["comment-submit"])) {

                // get comment form input
                $comment = $mysqlUtils->escapeString($_POST["comment-text"], true, true);

                // check if comment is empty
                if (!empty($comment)) {

                    // check if comment have maximal lenght
                    if (strlen($comment) < 850) {

                        // send comment 
                        $postsController->inserComment($postID, $comment);
        
                        // redirect to this
                        header("location: ?post=".$postID."&forum=".$forumName);
                    }
                }
            }
        }

        // post reader component
        echo '<div class="post-reader">';
    
        // get post data where ID
        $postData = $postsController->getPostDataByID($postID);

        // add path line
        echo '
            <div class="color-white">
                <a class="basic-link" href="/">board</a> / <a class="basic-link" href="?forum='.$forumName.'">'.$forumName.'</a> / <a class="basic-link" href="#">'.$postData["name"].'</a>
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
                '.nl2br($postData["content"]).'
            </p>
        ';

        // get comments objects
        $comments = $postsController->getCommentsWherePostID($postData["id"]);

        // add coment box
        echo '<div class="comment-box">';

        // add comments title
        echo '<p class="comment-box-title">Comments</p>';

        // check if comments found
        if ($comments->num_rows > 0) {

            // add all comments
            foreach ($comments as $value) {

                // ADMIN USER-NAME COLOR
                if ($userController->getUserRoleByName($value["author"]) == "Owner" || $userController->getUserRoleByName($value["author"]) == "Admin") {
                    $username = '<a href="?profile='.$value["author"].'" class="comment-username color-red">'.$value["author"].'</a>';

                // DEVELOPER USER-NAME COLOR
                } else if ($userController->getUserRoleByName($value["author"]) == "Developer") {

                    $username = '<a href="?profile='.$value["author"].'" class="comment-username color-blue">'.$value["author"].'</a>';

                // VIP USER-NAME COLOR
                } else if ($userController->getUserRoleByName($value["author"]) == "VIP") {

                    $username = '<a href="?profile='.$value["author"].'" class="comment-username color-yellow">'.$value["author"].'</a>';

                // USER USER-NAME COLOR
                } else if ($userController->getUserRoleByName($value["author"]) == "User") {
                    
                    $username = '<a href="?profile='.$value["author"].'" class="comment-username color-green">'.$value["author"].'</a>';

                } else {

                    // get unknow user role color
                    $username = '<a href="?profile='.$value["author"].'" class="comment-username">'.$value["author"].'</span>';
                }

                // add comment component
                echo '
                    <div class="comment">
                        <div class="comment-title">
                            <img class="comment-avatar" src="data:image/jpeg;base64, '.$userController->getUserAvatar($value["author"]).'"> 
                            '.$username.'
                            <span class="post-date-line comment-date">'.$value["comment_date"].'</span>
                        </div>
                        <p class="comment-text">
                            '.nl2br($value["comment"]).'
                        </p>
                    </div>
                ';
            }

        } else {

            // add not found msg
            echo "<p class='no-comments'>No comments found</p>";

        }

        // include new comment form
        include_once(__DIR__."/../forms/NewCommentForm.php");

        echo '</div>';

        // end of post component
        echo '</div>';
    }
?>
