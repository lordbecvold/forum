<div class="navigation-bar">
    <span class="left">
        <?php 
            // check if user logged in
            if ($userController->isUserLogged()) {

                // check if user admin
                if ($userController->checkIsUserAdmin()) {

                    // add admin link
                    echo '<a class="nav-link admin-link" href="?admin=dashboard"><i class="fas fa-cog"></i></a>';
                }
            }
        ?>    
        <a class="nav-link" href="/"><i class="fas fa-home"></i></a>
    </span>
    <?php // add search form
        include_once($_SERVER["DOCUMENT_ROOT"]."/../site/components/forms/SearchForm.php");
    ?>
</div>