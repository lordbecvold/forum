<?php // posts controller (get, add, delete, edit, count post data)

    namespace becwork\controller;

    class PostsController {

        // get posts by forum name (use * for all forums)
        public function getPostsObjectByForum($forum, $sort) {

            global $mysqlUtils;
            global $pageConfig;

            // default posts value
            $posts = null;

            // check if forum is all
            if ($forum == "*") {

                // check if sort new 
                if ($sort == "new") {

                    // select data sort by new
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts ORDER BY id DESC");

                } else {

                    // select all posts data
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts");
                }
            } else {
                
                // check if sort new 
                if ($sort == "new") {

                    // select post data with sort by new
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts WHERE forum = '$forum' ORDER BY id DESC");

                } else {

                    // select posts data by forum name
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts WHERE forum = '$forum'");
                }

            }

            // return final posts objects
            return $posts;
        }
    }
?>