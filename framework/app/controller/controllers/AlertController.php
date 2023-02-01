<?php // flash alert controller

    namespace becwork\controller;

    class AlertController {

        // normal neutral alert
        public function normalAlert($msg) {
            echo '
                <center>
                    <div class="alert">
                        <p class="alert-text">'.$msg.'</p>    
                    </div>
                </center>
            ';
        }

        // error alert 
        public function errorAlert($msg) {
            echo '
                <center>
                    <div class="alert alert-error">
                        <p class="alert-text">'.$msg.'</p>    
                    </div>
                </center>
            ';
        }

        // success alert
        public function successAlert($msg) {
            echo '
                <center>
                    <div class="alert alert-success">
                        <p class="alert-text">'.$msg.'</p>    
                    </div>
                </center>
            ';
        }
    }

?>