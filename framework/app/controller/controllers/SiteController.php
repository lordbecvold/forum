<?php // Example app controller

    namespace becwork\controller;

	class SiteController {

        // get maintenance mode value
        public function ifMaintenance() {

            global $pageConfig;

            // check if maintenance enabled
            if (($pageConfig->getValueByName('maintenance') == true)) {
                return true;
            } else {
                return false;
            }
        }

        // get query string by name
        public function getQueryString($query) {
            
            global $mysqlUtils;

            // check if query is empty
            if (empty($_GET[$query])) {
                $output = null;
            } else {

                // escape query
                $output = $mysqlUtils->escapeString($_GET[$query], true, true);
            }

            // return final query value
            return $output;
        }

        // get http host url
        public function getHTTPhost() {
            return $_SERVER['HTTP_HOST'];
        }
	}
?>