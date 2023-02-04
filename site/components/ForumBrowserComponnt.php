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

            // print form title
            echo '<div class="forum-title margin-bottom-0">'.$forum.'</div>';
            
            // add posts box
            echo '<div class="post-list"> ';

            // draw table structure
            echo '
                <table>
                    <tr>
                        <th>Post</th>
                        <th>Answers</th>
                        <th>Likes</th>
                    </tr>
            ';
            
            // draw all posts
            foreach ($posts as $value) {

                // print post component
                echo '
                    <tr>
                        <td>
                            <a class="post-link" href="#">'.$value["name"].'</a>
                            <div class="post-name-line"></div>
                            <p class="post-line-text">
                                by <a class="post-author-link" href="#">'.$value["author"].'</a>
                                <span class="post-desc-date">
                                    » '.$value["created_date"].'
                                </span>
                            </p>
                        </td>
                        
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                ';
            }

            // end of table
            echo '</tr></table>';

            // end of posts box
            echo '</div>';
        }

        //print_r($postsController->getPostsArrayByForumName("forum 1"));

    } else {

        // redirect to 400 if forum null
        header("location: ErrorHandlerer.php?code=400");        
    }
?>
