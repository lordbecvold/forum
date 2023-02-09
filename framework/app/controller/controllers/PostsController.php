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

        // send new post data
        public function sendNewPost($name, $forum, $content) {

            global $mysqlUtils;
            global $userController;

            // get user & date
            $author = $userController->getUserName();
            $created_date = date('d.m.Y H:i');

            // insert new post
            $mysqlUtils->insertQuery("INSERT INTO `posts`(`name`, `author`, `forum`, `created_date`, `content`) VALUES ('$name', '$author', '$forum', '$created_date', '$content')");
        }

        // get comments where post ID
        public function getCommentsWherePostID($id) {

            global $mysqlUtils;
            global $pageConfig;

            // get comments where ID
            $comments = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName(("basedb"))), "SELECT * FROM comments WHERE post_ID = $id");

            // return comments
            return $comments;
        }

        // submit new comment to database
        public function inserComment($postID, $comment) {

            global $mysqlUtils;
            global $userController;

            // get comment date
            $comment_date = date('d.m.Y H:i');

            // get comment posted
            $author = $userController->getUserName();

            // insert new comment
            $mysqlUtils->insertQuery("INSERT INTO `comments`(`post_ID`, `author`, `comment`, `comment_date`) VALUES ('$postID', '$author', '$comment', '$comment_date')");
        }
    }
?>