<div class="main-component">
    <?php 
 
        // get forums category
        $categorys = $boardController->getForumCategoryes();
    
        // check if forums empty
        if ($categorys == null) {

            // print not found msg
            $alertController->normalAlert($pageConfig->getValueByName("appName") . " board is empty");

        } else {

            // create category div
            foreach ($categorys as $category) {

                // get current category
                $category = $category['category'];

                // draw category header
                echo '<div class="forum-board"><p class="forum-title">'.$category.'</p><div>';
                
                // get forums by current category
                $forums = $boardController->getForumList($category);

                // create forum link by category
                foreach ($forums as $forum) {

                    // print forum component
                    echo '
                        <p class="forum-category">
                            <div class="forum-line">
                                <i class="fas fa-dot-circle"></i>  <a class="forum-link" href="?forum='.$forum["name"].'">'.$forum["name"].'</a>
                                <span class="right posts-count">posts: ('.$boardController->getPostsCountByForum($forum["name"]).')</span>
                            </div>
                            <p class="category-desc">'.$forum["description"].'</p>
                        </p>
                    ';
                }

                // end category component
                echo '</div></div>';
            }
        }
    ?>
</div>