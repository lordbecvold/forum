<main class="container">
<?php // user login component

    // check if user logged in
    if ($userController->isUserLogged()) {
        
        // redirect to 404 if user logged in
        header("location: ErrorHandlerer.php?code=404");

    } else {

        // import main user bar
        include_once("elements/UserBar.php");

        // check if post request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // check if login submit
            if (isset($_POST["submit-login"])) {

                // check if honeypot
                if (!empty($_POST["name"])) {
                    
                    // redirect to error page
                    header("location: ErrorHandlerer.php?code=400");

                // main login function (if request valid)
                } else {

                    // get form data and escape
                    $email = $mysqlUtils->escapeString($_POST["email"], true, true);
                    $password = $mysqlUtils->escapeString($_POST["password"], true, true);

                    // check if email is empty
                    if (empty($email)) {
                        $alertController->errorAlert("Please enter email.");

                    // check if password empty
                    } elseif (empty($password)) {
                        $alertController->errorAlert("Please enter password.");

                    // login inputs valid (init login function)
                    } else {
                        
                        // check if user can login
                        if ($loginController->canUserLogin($email, $password)) {

                            // login user
                            $loginController->login($email);
                        } else {
                            $alertController->errorAlert("Incorrect username or password.");
                        }
                    }
                }
            }
        }

        // import login form
        include_once("forms/LoginForm.php");
    }
?> 
</div>