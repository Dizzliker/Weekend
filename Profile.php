<?
    // Подключаем библиотку RedBeanPHP
    require_once './db/libs/rb-mysql.php';

    // Подключаемся к бд
    require_once './db/db.php';

    // Если пользователь не авторизован, редиректим его на страницу авторизации
    require_once "./db/redirect.php";
    
    // id пользователя, на странице которого мы находимся
    $id = $_GET['id'];

    // Вся информаци о пользователе на странице которого мы находимся
    $user = R::findOne('users', "id=?", array($id));

    $usernamePage = $user->name." ".$user->surname;
    $userStatus = $user->status;
    $userBirthday = $user->birthday;
    $userAva = $user->ava;
    $userOnline = $user->online;

    $title = $usernamePage;

    // Имя авторизованного пользователя
    $username = $title;
    // Аватарка авторизованного пользователя
    $ava = $_SESSION['logged_user']->ava;

    // Если пользователь на своей странице то подключаем скрипт смены аватарки
    // if ($_SESSION['logged_user']->id == $id) {
        // Скрипт для смены аватарки
        // require_once './db/editAva.php';
    // }
?>
<noscript>
    <div>
        <p>
            You have disable JavaScript on your browser. Please turn it on. 
        </p>
    </div>
</noscript>

<script>
    if (["http://weekend/Profile.php","http://weekend/Profile.php?id=","http://weekend/Profile.php?", "http://weekend/Profile.php#"].includes(location.href)) {
        location.href = "http://weekend/Profile.php?id=<?=$_SESSION['logged_user']->id?>";
    } 
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Подключаем общие теги в head -->
    <?require_once './views/partials/head.php';?>
    <link rel="stylesheet" href="./css/ProfileCss.css">
</head>

<body>
    <main>
        <!-- Подключаем боковое меню aside -->
        <?require_once './views/partials/aside.php';?>

        <section id="user-page_app">
            <div class="user-page-body_con">
                <div class="user-ava_con">
                    <a href="./MessagesPage.php?id=<?=$id?>">
                        <div class="user-btn-send-message" title="Send message"><img src="../img/Message.svg"></div>
                    </a>
                        <img src="<?=$userAva?>" class="user-ava">
                        
                        <?if ($_SESSION['logged_user']->id == $id):?>
                            <a href="#">
                                <div class="blackout-edit-ava" @click="showPopupAva()">
                                    <p class="blackout-edit-text">Click to edit avatar</p>
                                </div>
                            </a>
                        <?else:?>
                            <a href="#"></a>
                        <?endif;?>

                    <?
                        $friends = R::findOne('users', "id=?", [$_SESSION['logged_user']->id]);
                        $friend = explode(",", $friends->friend);

                        // Если пользователь уже добавлен в друзья, не даем добавить его второй раз
                        if (in_array($id, $friend) || $id == $_SESSION['logged_user']->id) {
                            echo "
                            <a href='#'>
                                <div class='user-btn-add-friend' title='Add to friends list'><img src='../img/Friends.svg'></div>
                            </a>
                            ";
                        } else {
                            echo "
                            <a href='./db/addFriend.php?id=$id'>
                                <div class='user-btn-add-friend' title='Add to friends list'><img src='../img/Friends.svg'></div>
                            </a>
                            ";
                        }
                    ?>

                    
                </div>

                <?if ($_SESSION['logged_user']->id == $id):?>
                <!-- Всплывающее меню загрузки новой аватарки -->
                <transition name='ava-edit-transition' enter-active-class='animated fadeIn' leave-active-class='animated fadeOut'>
                    <div class="popup-edit-ava_app" style="display: none" v-show="popupAvaApp">
                        <div class="popup-edit-ava_wrapper">
                            <div class="popup-edit-ava">
                                <div class="popup-edit-ava_head">
                                    <img src="./img/Logo.svg" class="popup-logo" alt="Weekend">
                                    <img src="./img/close.svg" class="popup-icon-close" @click="showPopupAva()" alt="Закрыть">
                                </div>

                                <div class="popup-error" ref="popupError"></div>

                                <form action="#" class="popup-form-ava" method="POST" enctype="multipart/form-data">
                                    <!-- Максимальный размер файла в байтах -->
                                    <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                                    <p class="popup-ava-text">Upload new avatar:</p>
                                    <label for="avatar" class="btn-upload">Upload</label>
                                    <input type="file" ref="inputFile" @change="editAva()" accept="image/*" id="avatar" name="avatar" required>
                                    <!-- <button type="submit" class="btn-save-edit-ava">Save</button> -->
                                </form>

                                <div id="dropzone" ref="dropzone" class="popup-dropzone">
                                    <img src="./img/iconImg.svg" class="dropzone-img" ref="dropzoneImg" alt="Загрузить аватарку">
                                    <p class="dropzone-text" ref="dropzoneText">Or drag a picture to this area</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
                <?endif;?>

                <div class="user-info_con">
                    <div class="user-info-name">
                        <h1><?=$usernamePage?></h1>
                        <div class="online-status <?=$userOnline?>"></div>
                        <p class="online-status-text"><?=$userOnline?></p>
                    </div>

                    <?if ($_SESSION['logged_user']->id == $id):?>
                        <div class="status">
                            <p class="status-text" v-show="statusText" @click="hideStatus()" title="Click to edit status"><?=$userStatus?></p>

                            <form action="./db/editStatus.php" style="display:none" v-show="statusForm" method="POST" class="status-form-edit">
                                <input type="text" name="status-new-text" class="status-text-form" value="<?=$userStatus?>" autocomplete="off">
                                <button type="submit" class="btn-status-save" @click="hideStatus()">
                                    Save
                                </button>
                            </form>

                            <img src="./img/iconEdit.svg" v-show="iconEdit"  class="status-icon-edit" @click="hideStatus()" alt="Редактировать">
                            <img src="./img/close.svg" v-show="iconClose" class="status-icon-close" @click="hideStatus()" alt="Отмена">
                        </div>
                    <?else:?>
                        <div class="status not-you">
                            <p class="status-text"><?=$userStatus?></p>
                        </div>
                    <?endif;?>

                    <div class="user-more-info">
                        <ul>
                            <li>
                                <p class="info-label">Sex:</p>
                                <div class="info-text">Male</div>
                            </li>

                            <li>
                                <p class="info-label">Birthday:</p>
                                <div class="info-text"><?=$userBirthday?></div>
                            </li>
                            <li>
                                <p class="info-label">Language:</p>
                                <div class="info-text">Russian</div>
                            </li>
                            <li>
                                <p class="info-label">Relationship:</p>
                                <div class="info-text">None</div>
                            </li>
                        </ul>

                        <div class="personal-info">

                            <a href="#">
                                <div>
                                    <img src="../img/FriendsP.svg">
                                    <p>Friends</p>
                                    <span class="personal-info-text">35</span>
                                </div>
                            </a>

                            <a href="#">
                                <div>
                                    <img src="../img/MusicP.svg">
                                    <p>Music</p>
                                    <span class="personal-info-text">127</span>
                                </div>
                            </a>

                            <a href="#">
                                <div>
                                    <img src="../img/PhotoP.svg">
                                    <p>Photos</p>
                                    <span class="personal-info-text">17</span>
                                </div>

                            </a>

                            <a href="#">
                                <div>
                                    <img src="../img/VideoP.svg">
                                    <p>Videos</p>
                                    <span class="personal-info-text">17</span>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            <section class="posts">
            <?if ($_SESSION['logged_user']->id == $id):?>
                <div class="submit-post">
                    <a href="#"><img src="<?=$ava?>" class="submit-post-ava"></a>
                    <form action="./db/addPost.php" method="POST" class="form-post">
                        <textarea type="text" name="txtarea-post" class="txtarea-post" id="" cols="30" rows="10" placeholder="What's news?" autocomplete="off"></textarea>

                        <div class="form-active">
                            <div class="form-attach-file">
                                <a href="#" class="icon-misuc"><img src="../img/Music.svg"></a>
                                <a href="#" class="icon-photo"><img src="../img/Photo.svg"></a>
                                <a href="#" class="icon-video"><img src="../img/Video.svg"></a>
                            </div>

                            <button type="submit" class="btn-public-post">
                                <img class="btn-icon-airplane" src="./img/iconSend(purple).svg" alt="&raquo;">
                            </button>
                        </div>
                    </form>
                </div>
            <?endif;?>

                <div class="my-posts">
                    <?
                        // Ищем посты определенного пользователя
                        $post = R::findLike('posts', ['user_id' => [$id]], 'ORDER BY id DESC');

                        // Если посты есть, вывести их
                        if ($_SESSION['logged_user']->id == $id) {
                            foreach($post as $postInfo) {
                                echo "
                                <transition appear name='custom-classes-transition' enter-active-class='animated bounceIn' leave-active-class='animated bounceOut'>
                                    <div class='post'>
                                        <a href='./Profile.php?id=$id'><img class='post-ava' src='$userAva' alt='Картинка'></a>
                                        <div class='post-container'>
                                            <div class='post-head'>
                                                <div class='post-author-data'>
                                                    <h5 class='post-author'><a href='#'>$usernamePage</a></h5>
                                                    <time class='post-data'>$postInfo[date]</time>
                                                </div>
                                
                                                <div class='edit-post'>
                                                    <div class='kebab'>
                                                        <div class='circle'></div>
                                                        <div class='circle'></div>
                                                        <div class='circle'></div>
                                                    </div>
                                
                                                    <img src='./img/iconEdit.svg' alt='Редактировать'>
                                                    <a href='./db/deletePost.php?id=$postInfo[id]'><img src='./img/close.svg' class='close' alt='Удалить'></a>
                                                </div>
                                            </div>

                                            <div class='post-content'>
                                                <p>
                                                    $postInfo[text]
                                                </p>
                                            </div>
                                
                                            <hr>
                                
                                            <div class='post-actions'>
                                                <div class='likes action'>
                                                    <img src='./img/heart.svg' alt='&#9825;'>
                                                    <span class='count-likes'>$postInfo[likes]</span>
                                                </div>
                                
                                                <div class='reposts action'>
                                                    <img src='./img/repost.svg' alt='&#8617;'>
                                                    <span class='count-reposts'>$postInfo[reposts]</span>
                                                </div>
                                
                                                <div class='comments action'>
                                                    <img src='./img/comment.svg' alt='&#9993;'>
                                                    <span class='count-comments'>$postInfo[comments]</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                                ";
                            }
                        } elseif ($_SESSION['logged_user']->id != $id) {
                            foreach($post as $postInfo) {
                                echo "
                                <transition appear name='custom-classes-transition' enter-active-class='animated bounceIn' leave-active-class='animated bounceOut'>
                                    <div class='post'>
                                        <a href='./Profile.php?id=$id'><img class='post-ava' src='$userAva' alt='Картинка'></a>
                                        <div class='post-container'>
                                            <div class='post-head'>
                                                <div class='post-author-data'>
                                                    <h5 class='post-author'><a href='#'>$usernamePage</a></h5>
                                                    <time class='post-data'>$postInfo[date]</time>
                                                </div>
                                
                                                <div class='edit-post not-you'>
                                                    <div class='kebab'>
                                                        <div class='circle'></div>
                                                        <div class='circle'></div>
                                                        <div class='circle'></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class='post-content'>
                                                <p>
                                                    $postInfo[text]
                                                </p>
                                            </div>
                                
                                            <hr>
                                
                                            <div class='post-actions'>
                                                <div class='likes action'>
                                                    <img src='./img/heart.svg' alt='&#9825;'>
                                                    <span class='count-likes'>$postInfo[likes]</span>
                                                </div>
                                
                                                <div class='reposts action'>
                                                    <img src='./img/repost.svg' alt='&#8617;'>
                                                    <span class='count-reposts'>$postInfo[reposts]</span>
                                                </div>
                                
                                                <div class='comments action'>
                                                    <img src='./img/comment.svg' alt='&#9993;'>
                                                    <span class='count-comments'>$postInfo[comments]</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                                ";
                            }
                        }   else {
                            echo "<p>You have no publications</p>";
                        }
                    ?>
                </div>
            </section>
        </section>
    </main>

    <!-- Скрипт для добавления поста -->
    <script src="./js/addPost.js"></script>

    <!-- <?if ($_SESSION['logged_user']->id == $id):?> -->
    <!-- Скрипт изменения статуса и аватарки -->
    <script src="./js/editAva_Status.js"></script>
    <!-- <?endif;?> -->
</body>

</html>