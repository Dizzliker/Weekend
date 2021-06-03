<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    $searchTerm = filter_var(trim($_POST['searchTerm']), FILTER_SANITIZE_STRING);
    $output = "";

    $sql = "SELECT * FROM users 
    WHERE (name LIKE '%{$searchTerm}%' OR surname LIKE '%{$searchTerm}%')";

    $rows = R::getAll($sql);

    if ($rows) {
        foreach ($rows as $friend) {
            $output .= "<transition appear name='custom-classes-transition' enter-active-class='animated bounceIn' leave-active-class='animated bounceOut'>
            <div class='user-friend_con' v-show='user'>
                <div class='friend-info'>
                    <a href='./Profile.php?id=$friend[id]'>
                        <img src='$friend[ava]' alt='' class='friend-ava'>
                    </a>
                    <div class='friend-name-online'>
                        <p class='friend-name'>
                            <a href='./Profile.php?id=$friend[id]' class='link-friend-name'>
                                $friend[name] $friend[surname]
                            </a>
                        </p>
    
                        <p class='friend-online'>
                            $friend[online]
                        </p>
                    </div>
                </div>  
                
                <div class='friend-actions'>
                    <a href='./MessagesPage.php?id=$friend[id]'>
                        <img src='./img/iconMessage.svg' alt='Send message' class='icon-send-msg' title='Send message'>
                    </a>
    
                    <div class='popup-kebab' style='display:none' v-show='popup'>
                        <ul>
                            <li>Delete friend</li>
                        </ul>
                    </div>
    
                    <div class='kebab' @click='hidePopup()'>
                        <div class='circle'></div>
                        <div class='circle'></div>
                        <div class='circle'></div>
                    </div>
                </div>
            </div>
        </transition>
        ";
        }
    } else {
        $output .= "<div class='search-not-found-text'>No user found related to your search term</div>";
    }
    echo $output;
?>