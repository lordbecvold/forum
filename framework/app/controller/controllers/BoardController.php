<?php // main forum board component

    namespace becwork\controller;

    class BoardController {

        // get forum category object
        public function getForumCategoryes() {

            global $mysqlUtils;
            global $pageConfig;

            // get catgoryes from database
            $categorys = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT DISTINCT category FROM forums");

            // check if category is empty
            if ($categorys->num_rows < 1) {

                // output empty table
                $output = null;

            } else {

                // output category objects
                $output = $categorys;
            }

            // return final output
            return $output;
        }

        // get forum list by category
        public function getForumList($category) {

            global $mysqlUtils;
            global $pageConfig;

            // get forum list by category name
            $forums = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM forums WHERE category = '$category'");

            return $forums;
        }

        // get forum posts count (where forum name)
        public function getPostsCountByForum($forum) {

            global $postsController;

            return $postsController->getPostsObjectByForum($forum, null)->num_rows;
        }
    }
?>