<main class="container">
    <?php 
        // import main user bar
        include_once("elements/UserBar.php");

        // import navigation panel
        include_once("elements/Navigation.php");

        ///////////////////////////////////////////////////////////////////////

        // get forum name (if set)
        $forum = $siteController->getQueryString("forum");

        // check if forum not seted
        if ($forum == null) {

            // import forum board
            include_once("BoardComponent.php");
        } 
        
        // forum borwser
        else {

            // import forum browser
            include_once("ForumBrowserComponnt.php");
        }
        ///////////////////////////////////////////////////////////////////////

        // import page footer
        include_once("elements/Footer.php");
    ?>
</main>
