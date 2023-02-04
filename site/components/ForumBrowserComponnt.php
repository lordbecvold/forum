<?php // forum borwser component

    // get forum name (if set)
    $forum = $siteController->getQueryString("forum");   

    // check if forum seted
    if ($forum != null) {

        // include sub panel
        include_once("elements/ForumBorwserSubPanel.php");

        // check if forum empty
        if ($postsController->getPostsObjectByForum($forum)->num_rows < 1) {
           
            // print empty forum msg
            $alertController->normalAlert($forum . " is empty<br><a href='#' class='basic-link'>create post</a>");
        } 
        
        // draw forum posts
        else {

            // get posts
            $posts = $postsController->getPostsObjectByForum($forum);

            echo '<div class="forum-title">'.$forum.'</div>';
            
            // add posts box
            echo '<div class="post-list">';
            

            // draw all posts
            foreach ($posts as $value) {

                // print post component
                echo '
                    <div class="post-element">
                        <a class="post-link" href="#">'.$value["name"].'</a>
                        <div class="post-name-line"></div>
                        <span class="right margin-top-2">
                            <span class="post-desc-date">
                                <span class="post-line-text">created:</span>    
                                '.$value["created_date"].',
                            </span>
                            <span class="post-desc-date">
                                <span class="post-line-text">updated:</span>   
                                '.$value["update_date"].'
                            </span>
                        </span>
                        <p class="post-line-text">
                            by <a class="post-author-link" href="#">'.$value["author"].'</a>
                        </p>
                    </div>
                ';
            }

            // end of posts box
            echo '</div>';
        }

        //print_r($postsController->getPostsArrayByForumName("forum 1"));

    } else {

        // redirect to 400 if forum null
        header("location: ErrorHandlerer.php?code=400");        
    }
?>

