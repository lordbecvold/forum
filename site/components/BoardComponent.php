<div class="main-component">
    <?php 

        // get forums category
        $categorys = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT DISTINCT category FROM forums");
    
        // create category div
        foreach ($categorys as $category) {

            // get current category
            $category = $category['category'];

            // draw category header
            echo '<div class="forum-board"><p class="forum-title">'.$category.'</p><div>';
            
            // get forums by current category
            $forums = mysqli_query($mysqlUtils->mysqlConnect($pageConfig->getValueByName("basedb")), "SELECT * FROM forums WHERE category = '$category'");

            // create forum link by category
            foreach ($forums as $forum) {

                // print forum component
                echo '
                    <p class="forum-category">
                        <div class="forum-line">
                            <a class="forum-link" href="#">'.$forum["name"].'</a>
                            <span class="right posts-count">posts: 35</span>
                        </div>
                        <p class="category-desc"><i class="fas fa-dot-circle"></i>'.$forum["description"].'</p>
                    </p>
                ';
            }

            // end category component
            echo '</div></div>';
        }
    ?>
<br><br>
</div>