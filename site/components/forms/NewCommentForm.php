<?php 

    // get post ID from url
    $postID = $siteController->getQueryString("post");

    // get forum name from url
    $forumName = $siteController->getQueryString("forum");

    // print form
    echo '
        <form class="comment-form" method="post" action="?post='.$postID.'&forum='.$forumName.'">
            <p class="form-title new-comment-title">New comment</p>
            <textarea class="user-input-field comment-textarea" maxlength="800" name="comment-text"></textarea>
            <input class="user-input-field" type="submit" name="comment-submit" value="Submit">
        </form>
    ';
?>