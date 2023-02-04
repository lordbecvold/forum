<div class="sub-panel">
    <p>
        <a class="basic-link" href="#">NEW POST</a>
        <?php // and my posts link to sub panel (if user logged in)
            if ($userController->isUserLogged()) {
                echo '<a class="basic-link" href="#">MY POSTS</a>';
            }
        ?>
        <span class="right sort-panel">
            <span class="sort-text">sort by: </span>
            <?php 

                // get forum name (if set)
                $forum = $siteController->getQueryString("forum");   

                // get sort (if set)
                $sort = $siteController->getQueryString("sort");  

                // check if sort seted
                if ($sort == null) {

                    // add sort by new button
                    echo '<a class="basic-link" href="?forum='.$forum.'&sort=new">NEW</a>';
                } else {

                    // add default sort
                    echo '<a class="basic-link" href="?forum='.$forum.'">OLDER</a>';
                }
            ?>
        </span>
    </p>
</div>