<?php 

    // get profile name form url query
    $profile = $siteController->getQueryString("profile");

    // get profile role
    $role = $userController->getUserRoleByName($profile);

    // get profile avatar
    $avatar = $userController->getUserAvatar($profile);

    // get role color
    if ($role == "Owner") {
        $role = '<span class="color-red">'.$role.'</span>';

    } elseif ($role == "Admin") {
        $role = '<span class="color-red">'.$role.'</span>';

    } elseif ($role == "Developer") {
        $role = '<span class="color-blue">'.$role.'</span>';

    } elseif ($role == "VIP") {
        $role = '<span class="color-yellow">'.$role.'</span>';

    } elseif ($role == "User") {
        $role = '<span class="color-green">'.$role.'</span>';

    } else {
        $role = '<span>'.$role.'</span>';
    }

    // print profile-box
    echo '<div class="profile-box">';

    // print profile data box
    echo '
        <div class="profile-data">
            <center>
                <span class="profile-photo">
                    <img src="data:image/jpeg;base64, '.$avatar.'">
                </span>
                <span class="profile-name">
                    <p>'.$profile.'</p>
                </span>
                <span class="profile-role">
                    <p>role: '.$role.'</p>
                </span>
            </center>
        </div>
    ';

    // get posts by profile name
    $posts = $postsController->getPostsByUsername($profile);

    // print posts list
    echo '<div class="profile-posts-list">';

    // check if posts is empty
    if ($posts->num_rows > 0) {

        // print post list
        foreach ($posts as $value) {
            echo '
                <div class="profile-post-link">
                    <a href="?post='.$value["id"].'&forum='.$value["forum"].'" class="basic-link">'.$value["name"].'</a>
                    <span class="profile-post-date right">
                        '.$value["created_date"].'
                    </span>
                </div>
            ';
        }

    } else {
        echo "not found";
    }

    // end of posts list
    echo '</div>';

    // end of profile box
    echo '</div>';
?>