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
            <a class="basic-link" href="#">CREATED</a>
            <a class="basic-link" href="#">UPDATE</a>
        </span>
    </p>
</div>