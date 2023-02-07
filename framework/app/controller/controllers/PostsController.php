<?php // posts controller (get, add, delete, edit, count post data)

    namespace becwork\controller;

    class PostsController {

        // get posts by forum name (use * for all forums)
        public function getPostsObjectByForum($forum, $sort, $startBy, $limit) {

            global $mysqlUtils;
            global $pageConfig;

            // default posts value
            $posts = null;

            // check if forum is all
            if ($forum == "*") {

                // check if sort new 
                if ($sort == "new") {

                    // select data sort by new
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts ORDER BY id DESC LIMIT $startBy, $limit");

                } else {

                    // select all posts data
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts LIMIT $startBy, $limit");
                }
            } else {
                
                // check if sort new 
                if ($sort == "new") {

                    // select post data with sort by new
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts WHERE forum = '$forum' ORDER BY id DESC LIMIT $startBy, $limit");

                } else {

                    // select posts data by forum name
                    $posts = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts WHERE forum = '$forum' LIMIT $startBy, $limit");
                }

            }

            // return final posts objects
            return $posts;
        }

        // get post data by ID
        public function getPostDataByID($id) {

            global $pageConfig;
            global $mysqlUtils;

            // build select query where post id
            $query = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM posts WHERE id = '$id'");
            
            // get associative array
            $output = mysqli_fetch_assoc($query);

            // return selected data
            return $output;
        }
    }
?>