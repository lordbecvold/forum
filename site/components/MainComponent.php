<main class="container">
    <?php 

        // get forum name (if set)
        $forum = $siteController->getQueryString("forum");

		// get process value (if used)
		$process = $siteController->getQueryString("process");

        // get profile name form url query
        $profile = $siteController->getQueryString("profile");

        // import main user bar
        include_once("elements/UserBar.php");

        // check if process is not new
        if ($process != "new") {

            // import navigation panel
            include_once("elements/Navigation.php");
        }

        ///////////////////////////////////////////////////////////////////////

        // check if profile viewer used
        if ($profile != null) {

            // use profile viewer
            include_once("ProfileViewer.php");

        } else {

            // check if process = new post
            if ($process == "new") {

                // use new post component
                include_once("PostWriteComponent.php");

            } else {
                // check if forum not seted
                if ($forum == null) {

                    // import forum board
                    include_once("BoardComponent.php");
                } 
                
                // forum borwser
                else {

                    // import forum browser
                    include_once("ForumBrowserComponent.php");
                }
            }
        }
        ///////////////////////////////////////////////////////////////////////

        // import page footer
        include_once("elements/Footer.php");
    ?>
</main>
