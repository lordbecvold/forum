<main class="container">
    <?php 

        // get forum name (if set)
        $forum = $siteController->getQueryString("forum");

		// get process value (if used)
		$process = $siteController->getQueryString("process");

        // get profile name form url query (if used)
        $profile = $siteController->getQueryString("profile");
 
        // get post id from url (if used)
        $postID = $siteController->getQueryString("post");

        // import main user bar
        include_once("elements/UserBar.php");

        // check if process is not new
        if ($process != "new") {

            // import navigation panel
            include_once("elements/Navigation.php");
        }

        ///////////////////////////////////////////////////////////////////////

        // check if used search form
        if (isset($_POST["search-submit"])) {

            // use search component
            include_once("core/SearchComponent.php");

        } else {

            // check if post reader used
            if ($postID != null) {

                // use prost reader
                include_once("core/PostReaderComponent.php");

            } else {

                // check if profile viewer used
                if ($profile != null) {

                    // use profile viewer
                    include_once("core/ProfileViewer.php");

                } else {

                    // check if process = new post
                    if ($process == "new") {

                        // use new post component
                        include_once("core/PostWriteComponent.php");

                    } else {
                        // check if forum not seted
                        if ($forum == null) {

                            // import forum board
                            include_once("core/BoardComponent.php");
                        } 
                        
                        // forum borwser
                        else {

                            // import forum browser
                            include_once("core/ForumBrowserComponent.php");
                        }
                    }
                }
            }
        }
        ///////////////////////////////////////////////////////////////////////

        // import page footer
        include_once("elements/Footer.php");
    ?>
</main>
