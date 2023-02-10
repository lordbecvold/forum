<main class="container">
<?php // new user register component

    // check if user logged in
    if ($userController->isUserLogged()) {
        
        // redirect to 404 if user logged in
        header("location: ErrorHandlerer.php?code=404");

    } else {

        // import main user bar
        include_once(__DIR__."/../elements/UserBar.php");

        // get register status
        $status = $siteController->getQueryString("status");

        // check if status is ok
        if ($status == "ok") {
            $alertController->successAlert("Register successful");
        } 

        // check if post request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // check if register submit
            if (isset($_POST["submit-register"])) {

                // check if honeypot
                if (!empty($_POST["name"])) {
                    
                    // redirect to error page
                    header("location: ErrorHandlerer.php?code=400");

                // main register function (if request valid)
                } else {

                    // get form data and escape
                    $userName = $mysqlUtils->escapeString($_POST["username"], true, true);
                    $email = $mysqlUtils->escapeString($_POST["email"], true, true);
                    $password = $mysqlUtils->escapeString($_POST["password"], true, true);
                    $passwordAgain = $mysqlUtils->escapeString($_POST["password-again"], true, true);

                    // check if username is empty /////////////////////////////////
                    if (empty($userName)) {
                        $alertController->errorAlert("Please enter username");
                    
                    // check if email is empty
                    } elseif (empty($email)) {
                        $alertController->errorAlert("Please enter email");

                    // check if password empty
                    } elseif (empty($password)) {
                        $alertController->errorAlert("Please enter password");

                    // check if password validator empty
                    } elseif (empty($passwordAgain)) {
                        $alertController->errorAlert("Please enter password-again");


                    // check if lenght valid //////////////////////////////////////
                    } elseif (strlen($userName) < 5) {
                        $alertController->errorAlert("minimal username lenght is 5 characters");

                    } elseif (strlen($password) < 8) {
                        $alertController->errorAlert("minimal password lenght is 8 characters");


                    // check if passwords matched /////////////////////////////////
                    } elseif ($password != $passwordAgain) {
                        $alertController->errorAlert("passwords dont matched");

                    // register inputs valid (insert new user)
                    } else {
                        
                        // check if username used
                        if ($registerController->isUserRegistred($userName)) {
                            $alertController->errorAlert($userName . " is used");
                        } 

                        // check if email used
                        elseif ($registerController->isEmailRegistred($email)) {
                            $alertController->errorAlert($email . " is registred");
                        } 
                        
                        // all valid
                        else {

                            // insert new user
                            $registerController->registerUser($userName, $email, $password);
                        
                            // redirect to OK status (registred successful msg)
                            header("location: ?process=register&status=ok");
                        }
                    }
                }
            }
        }

        // import user register from
        include_once(__DIR__."/../forms/RegisterForm.php");
    }
?>
</div>