<?php // default user controller

    namespace becwork\controller;

    class UserController {

        // check if user logged
        public function isUserLogged() {
            return false;
        }
    
        // get current username
        public function getUserName() {

            // check if user logged
            if ($this->isUserLogged()) {
                $userName = "username";
            } else {
                $userName = null;
            }
            
            return $userName;
        }

        // get user token
        public function getUserToken() {

            // check if logged
            if ($this->isUserLogged()) {
                $token = "user_token";
            } else {
                $token = null;
            }

            return $token;
        }

        // get user role
        public function getUserRole() {

            // check if user logged
            if ($this->isUserLogged()) {

                $role = "role_name where token: ".$this->getUserToken();
            } else {
                $role = null;
            }

            return $role;
        }
    }
?>