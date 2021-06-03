<?
    echo "
    <transition appear name='custom-classes-transition' enter-active-class='animated bounceIn' leave-active-class='animated bounceOut'>
        <div class='user-friend_con' v-show='user'>
            <div class='friend-info'>
                <a href='./Profile.php?id=$user[id]'>
                    <img src='$user[ava]' alt='' class='friend-ava'>
                </a>
                <div class='friend-name-online'>
                    <p class='friend-name'>
                        <a href='./Profile.php?id=$user[id]' class='link-friend-name'>
                            $user[name] $user[surname]
                        </a>
                    </p>

                    <p class='friend-online'>
                        $user[online]
                    </p>
                </div>
            </div>  
            
            <div class='friend-actions'>
                <a href='./MessagesPage.php?id=$user[id]'>
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
?>