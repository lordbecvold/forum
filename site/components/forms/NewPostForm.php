<?php 
    // get forum name from url
    $forum = $siteController->getQueryString("forum");  

    // print form
    echo '
        <form class="form" action="?process=new&forum='.$forum.'" method="post">
            <p class="form-title margin-bot-8">Create new post</p>
            <input class="user-input-field new-post-title" type="text" name="name" placeholder="Title"><br>
            <textarea class="user-input-field new-post-content margin-bot-8" name="post-content" placeholder="Post text"></textarea><br>
            <center>
                <input class="user-input-field" type="submit" name="new-post-submit" value="Submit">
            </center>
        </form>
    ';
?>