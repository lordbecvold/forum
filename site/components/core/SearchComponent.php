<?php 

    // check if used search form
    if (isset($_POST["search-submit"])) {

        // get search value and escape
        $search = $mysqlUtils->escapeString($_POST["search-value"], true, true);

        // check if search is empty
        if (empty($search)) {

            // print empty search error
            $alertController->normalAlert("Search text is empty");

        // search system
        } else {

            // get posts search
            $posts = $postsController->getSearchPosts($search);

            // print posts list
            echo '<div class="profile-posts-list search-list">';

            // check if posts is empty
            if ($posts->num_rows > 0) {

                // print post list
                foreach ($posts as $value) {
                    echo '
                        <div class="profile-post-link">
                            <a href="?post='.$value["id"].'&forum='.$value["forum"].'" class="basic-link">'.$value["name"].'</a>
                            
                            by <a class="post-author-link" href="?profile='.$value["author"].'">'.$value["author"].'</a>

                            <span class="profile-post-date right">
                                '.$value["created_date"].'
                            </span>
                        </div>
                    ';
                }

            } else {
                $alertController->normalAlert("posts not found");
            }

            // end of posts list
            echo '</div>';
        }
    }
?>