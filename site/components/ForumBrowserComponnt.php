<?php // forum borwser component

    // get forum name (if set)
    $forum = $siteController->getQueryString("forum");   

    // check if forum seted
    if ($forum != null) {

        // include sub panel
        include_once("elements/ForumBorwserSubPanel.php");

    } else {

        // redirect to 400 if forum null
        header("location: ErrorHandlerer.php?code=400");        
    }
?>

<div class="post-list">
    
    <div class="post-element">

        <a class="post-link" href="#">POST_NAMEPOS T_NAMEPOST_NAMEPO ST_NAMEPOST _NAMEPOST_NAMEPOST _NAMEPOST_NAM EPOST_NAMEPOST_NAMEPOS TNAME</a>

        <div class="post-name-line"></div>
        
        <span class="right margin-top-2">
            <span class="post-desc-date">
                <span class="post-line-text">created:</span>    
                1.1.1999,
            </span>
            <span class="post-desc-date">
                <span class="post-line-text">updated:</span>   
                1.1.1999
            </span>
        </span>

        <p class="post-line-text">
            by <a class="post-author-link" href="#">user_name</a>
        </p>
    </div>


    <div class="post-element">

        <a class="post-link" href="#">POST_NAMEPOS T_NAMEPOST_NAMEPO ST_NAMEPOST _NAMEPOST_NAMEPOST _NAMEPOST_NAM EPOST_NAMEPOST_NAMEPOS TNAME</a>

        <div class="post-name-line"></div>
        
        <span class="right margin-top-2">
            <span class="post-desc-date">
                <span class="post-line-text">created:</span>    
                1.1.1999,
            </span>
            <span class="post-desc-date">
                <span class="post-line-text">updated:</span>   
                1.1.1999
            </span>
        </span>

        <p class="post-line-text">
            by <a class="post-author-link" href="#">user_name</a>
        </p>
    </div>

</div>