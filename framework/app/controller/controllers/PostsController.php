<?php // posts controller (get, add, delete, edit, count post data)

    namespace becwork\controller;

    class PostsController {

        // get posts by forum name (use * for all forums)
        public function getPostsObjectByForum($forum) {

            global $mysqlUtils;
            global $pageConfig;

            // default posts value
            $posts = null;

            // check if forum is all
            if ($forum == "*") {

                // select all posts data
                $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts");
            } else {
                
                // select posts data by forum name
                $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts WHERE forum = '$forum'");
            }

            // return final posts objects
            return $posts;
        }

        // get posts associative array by forum name
        public function getPostsArrayByForumName($forum) {

            // get posts and fetch assoc
            $posts = mysqli_fetch_assoc($this->getPostsObjectByForum($forum));

            // return final posts objects
            return $posts;
        }
    }
?>