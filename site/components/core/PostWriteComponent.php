<?php 

    // check if user logged in
    if ($userController->isUserLogged()) {

        // get forum name from url
        $forum = $siteController->getQueryString("forum");  

        // check if forum is not null
        if ($forum != null) {
     
            // check if forum exist
            if ($boardController->isForumExist($forum)) {

                // check if post used
                if (isset($_POST["new-post-submit"])) {

                    // get post data & escape
                    $name = $mysqlUtils->escapeString($_POST["name"], true, true);
                    $content = $mysqlUtils->escapeString($_POST["post-content"], true, true);

                    // check if name & content empty
                    if (empty($name)) {
                        
                        // print error
                        $alertController->errorAlert("Post title is empty");

                    } elseif (empty($content)) {

                        // print error
                        $alertController->errorAlert("Post content is empty");

                    // insert post content to database
                    } else {

                        // check if title lenght is maximal 50 chars
                        if (strlen($name) > 50) {
                            $alertController->errorAlert("Maximal title name can have 50 characters");

                        // check if comtent lenght is maximal 10000 chars
                        } elseif (strlen($content) > 10000) {
                            $alertController->errorAlert("Maximal content name can have 10000 characters");

                        } else {
                            // insert new post
                            $postsController->sendNewPost($name, $forum, $content);

                            // redirect to forum page
                            header("location: ?forum=$forum");
                        }
                    }
                } 
                
                // import new post form 
                include_once(__DIR__."/../forms/NewPostForm.php");

            // redirect to 404 if forum not exist
            } else {

                header("location: ErrorHandlerer.php?code=404");                   
            }
        }

    // no login users
    } else {

        // flash error alert
        $alertController->normalAlert(
            "
                Only a logged in user can create a new thread!
                <br>
                <a href='?process=login' class='basic-link'>login here</a>
            "
        );
    }
?>