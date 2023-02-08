<?php 

    // check if used search form
    if (isset($_POST["search-submit"])) {

        $search = $_POST["search-value"];
        if (empty($search)) {
            echo "search si empty";
        } else {

            echo "search: " . $search;
        }
    }

?>