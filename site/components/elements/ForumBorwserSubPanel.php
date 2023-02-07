<?php 

    // get forum name (if set)
    $forum = $siteController->getQueryString("forum");   

    // get sort (if set)
    $sort = $siteController->getQueryString("sort");  
?>
<div class="sub-panel">
    <p>
        <?php 
            // add new post link
            echo '<a class="basic-link" href="?process=new&forum='.$forum.'">NEW POST</a>';
        ?>
        <span class="right sort-panel">
            <span class="sort-text">sort by: </span>
            <?php 

                // check if sort seted
                if ($sort == null) {

                    // add sort by new button
                    echo '<a class="basic-link" href="?forum='.$forum.'&sort=new">NEW</a>';
                } else {

                    // add default sort
                    echo '<a class="basic-link" href="?forum='.$forum.'">OLDER</a>';
                }
            ?>
        </span>
    </p>
</div>