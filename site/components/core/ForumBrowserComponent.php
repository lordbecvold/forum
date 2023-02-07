<?php // forum borwser component

    // get max per page form config
    $maxPerPage = $pageConfig->getValueByName("max_items_per_page");

    // get forum name (if set)
    $forum = $siteController->getQueryString("forum");   

    // get sort (if set)
    $sort = $siteController->getQueryString("sort");   

    // page system ////////////////////////////////////////////////////////////
    $startByString = $siteController->getQueryString("startBy");  
    $startBy = intval($startByString);

    // next/back page values
    $backPageStartBy = $startBy - $maxPerPage;
    $nextPageStartBy = $startBy + $maxPerPage;
    ///////////////////////////////////////////////////////////////////////////

    // check if forum seted
    if ($forum != null) {

        // include sub panel
        include_once(__DIR__."/../elements/ForumBorwserSubPanel.php");

        // check if forum empty
        if ($postsController->getPostsObjectByForum($forum, $sort, $startBy, $maxPerPage)->num_rows < 1) {
            
            if ($boardController->isForumExist($forum)) {

                // print empty forum msg
                $alertController->normalAlert($forum . " is empty<br><a href='?process=new' class='basic-link'>create post</a>");
            } else {
                
                header("location: ErrorHandlerer.php?code=404");      
            }
        } 
            
        // draw forum posts
        else {

            // get posts
            $posts = $postsController->getPostsObjectByForum($forum, $sort, $startBy, $maxPerPage);

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
                            <a class="post-link" href="?post='.$value["id"].'&forum='.$forum.'">'.$value["name"].'</a>
                            <div class="post-name-line"></div>
                            <p class="post-line-text">
                                by <a class="post-author-link" href="?profile='.$value["author"].'">'.$value["author"].'</a>
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

            // PAGE SYSTEM BUTTONS ////////////////////////////////////////////

            // add back page button
            if ($startBy != 0) {
                echo '<a class="page-button left" href="?forum=FORUM%201&startBy='.$backPageStartBy.'">Back</a>';
            }
        
            // add next page button
            if ($postsController->getPostsObjectByForum($forum, $sort, $startBy, $maxPerPage)->num_rows >= $maxPerPage) {
                echo '<a class="page-button right" href="?forum=FORUM%201&startBy='.$nextPageStartBy.'">Next</a>';
            }

            // print spacer
            if (($postsController->getPostsObjectByForum($forum, $sort, $startBy, $maxPerPage)->num_rows >= $maxPerPage) || ($startBy != 0)) {
                echo "<br><br>";
            }

            ///////////////////////////////////////////////////////////////////

            // end of posts box
            echo '</div>';
        }

    } else {

        // redirect to 400 if forum null
        header("location: ErrorHandlerer.php?code=400");        
    }
?>
