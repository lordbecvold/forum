<?php // user register controller

    namespace becwork\controller;

    class RegisterController {

        // check if user already registred
        public function isUserRegistred($userName) {

            global $pageConfig;
            global $mysqlUtils;

            // select all rows with username
            $users = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM users WHERE username = '$userName'");

            // check if user registred
            if ($users->num_rows == 0) {
                $out = false;
            } else {
                $out = true;
            }

            return $out;
        }

        // check if email already registred
        public function isEmailRegistred($email) {

            global $pageConfig;
            global $mysqlUtils;

            // select all rows with email
            $users = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM users WHERE email = '$email'");

            // check if user registred
            if ($users->num_rows == 0) {
                $out = false;
            } else {
                $out = true;
            }

            return $out;
        }

        // register new user
        public function registerUser($username, $email, $password) {

            global $mysqlUtils;
            global $hashUtils;
            global $mainUtils;
            global $stringUtils;
            global $pageConfig;

            // hash password
            $passwordhash = $hashUtils->genBlowFish($password);

            // default user role
            $role = "user";
            $image_base64 = "/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw4RDQ0OEA0QDhANDQ0NDw4NDhsNDg0OFREWFxcTFRUYICggGBolGxMTITEhJSkrLi4uFx8zODMsNygtLisBCgoKDQ0NDg0NDisZFRkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOYA2wMBIgACEQEDEQH/xAAaAAEAAwEBAQAAAAAAAAAAAAAAAQQFAwIH/8QAMhABAQABAQYEBAQGAwAAAAAAAAECEQMEEiFRkSIxQWEFcYGhQnKxwSMyUoLh8DNi0f/EABUBAQEAAAAAAAAAAAAAAAAAAAAB/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8A+qAKgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIebtMf6p3B7HObXH+qd49ygkQkAAAAAAAAAAAAAAAAAAAEWgjLKSa26SKe232/hn1v/jhvG3uV9vSfu5A9Z7TK+eVv1eNEiiNHrHKzytnyqAFnZb5lPPxT7r2y2kyxlmul6shY3Ta2Zaa8ulvJBpCEgAAAAAAAAAAAAAAAAK2/bSTCzXnfT10WMrpLb6c/oyNpncsrlfX7QHkBQAAAAdN2kueOt05uYDZSr7nteLDn5zlVhAAAAAAAAAAAAAAAABX37LTC+9mP+9mau/EbywnvapAAKAAAAAALPw/LxWdcf0aLL3O/wATH31n2aiAAAAAAAAAAAAAAADjvW14cdZ53lAVfiF8WP5f3VXrabS5XW3V5UAAAAAAAAdN3v8AEw/NGqxpdLrPTmv7nvFytmXPSayoLYAAAAAAAAAAAAACp8Qnhntl+y28bXCZY2X1BkD1tMLjdLNHlQAAAAAAAAWdwnjvtjVaRpbnseHHn53z9vZB3SAAAAAAAAAAAAACEgK2/wD/AB/3Ys5o7/PB/dGcAAoAAAAAAtfD74svy/u0FD4dj4sr6Sad19BCQAAAAAAAAAAAAAABz281wyn/AFrJbNjHzx0tnS6AgBQAAAAAkBf+Hzw29clpz3fDhwxl8/V1QAAAAAAAAAAAAAAAAFLf9l5ZSeXnp0XUWAxha2+52S2XWTW6XlZFVQAAAAWNy2VuUvpOf1eNhsLneknnWls8JjJJ5T7+6D0kAAAAAAAAAAAAAAQCRFrxdrjPxTuDoOGW94T8Wvyjllv2Ppjb9gd95vgy+TKd9tvWWUs0klcFAAAAF74deWU95+i4ydhtrjrppz6rOO/T1x7VBdFeb5h1s+ce8dvhfxQHUeZlOsv1egAAAAAAAAAU983jTwzz9b09gdNvvWOPL+a9J6fNT2m9Z3109pycQC29UaJFAAAAAAAAAAAAB0w2+c8sr8rzjmAvbHfZeWU0955f4W5WMsbrvHDdL/Lfsg0hCQAAAAc9vtOHG325fNk2+t875rvxDK+HGS9byU+G9L2BAnhvS9jhvS9lECeG9L2OG9L2BAnhvS9jhvS9gQJ4b0vY4b0vYECeG9L2OG9L2BAnhvS9jhvS9gQJ4b0vY4b0vYECeG9L2OG9L2BAnhvS9jhvS9gQJ4b0vY4b0vYF/cNrrjcb54/otMzdLcc5yvPleXVpoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP/9k=";
            $remote_addr = $mainUtils->getRemoteAdress();
            $token = $stringUtils->genRandomStringAll(40);

            // select all rows with token
            $users = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM users WHERE token = '$token'");

            // check if token exist in database
            if ($users->num_rows) {

                // repeate this function for regenerate
                $this->registerUser($username, $email, $passwordhash);
            } else {

                // check if user or email not registed
                if (($this->isEmailRegistred($email) == false) && ($this->isUserRegistred($username) == false)) {

                    // insert new user row
                    $mysqlUtils->insertQuery("INSERT INTO `users`(`username`, `email`, `password`, `role`, `image_base64`, `remote_addr`, `token`) VALUES ('$username', '$email', '$passwordhash', '$role', '$image_base64', '$remote_addr', '$token')");
                
                    // log action to database
                    $mysqlUtils->logToMysql("register", "new user $username with $email = register");
                }
            }
        }
    }
?>