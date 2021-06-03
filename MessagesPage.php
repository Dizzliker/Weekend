<?
    // Подключаем библиотку RedBeanPHP
    require_once "./db/libs/rb-mysql.php";

    // Подключаемся к бд
    require_once './db/db.php';

    // Если пользователь не авторизован, редиректим его на страницу авторизации
    require_once "./db/redirect.php";

    // Название страницы
    $title = "Weekend | messages";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Подключаем общие теги в head -->
    <?require_once "./views/partials/head.php";?>
    <link rel="stylesheet" href="./css/MessagesCss.css">
</head>

<body>
    <main>
        <!-- Подключаем боковое меню aside -->
        <?require_once "./views/partials/aside.php";?>

        <section id="msgs_app">
            <div class="search-bar">
                <input type="text" class="input-search" placeholder="Search user"> 
                <div class="search-btn">
                    <img src="./img/Search.svg" alt="Search" class="icon-search">
                </div>
            </div>

            <div class="users-msgs_con">

            </div>
        </section>
        
        <?if (!empty($_GET['id'])):
            $user = R::findOne("users", "id=?", array($_GET['id']));
        ?>
            <section class='chat_app'>
                <header class='chat-title'>
                    <div class='chat-title-header'>
                        <div class='chat-title-user'>
                            <a href="./Profile.php?id=<?=$user->id?>">
                                <img src='<?=$user->ava?>' alt=''>
                            </a>
                            <a href="./Profile.php?id=<?=$user->id?>">
                                <h3 class='chat-title-name'><?=$user->name." ".$user->surname?></h3>
                            </a>
                            
                            <p class='chat-title-online'><?=$user->online?></p>
                        </div>

                        <a href='#' class='searchMessage'>
                            <img src='Search.svg' alt="">
                        </a>

                        <a href='#' class="kebab-link">
                            <div class="kebab">
                                <div class='circle'></div>
                                <div class='circle'></div>
                                <div class='circle'></div>
                            </div>
                        </a>
                    </div>
                </header>

                <div class='chat-box'></div>

                <div class='form-alert-msg'>
                    <form action="#" name='form' class='form' id='form-send-msg' method='POST'>
                    <input type="text" name="outgoing_id" value="<?=$_SESSION['logged_user']->id?>" hidden>
                    <input type="text" name="incoming_id" value="<?=$_GET['id']?>" hidden>

                        <textarea type='text' name='message' cols='30' rows='10' autocomplete='off' class='input-field'
                            placeholder='Send your message' focus='focus' tabindex='1'></textarea>

                        <div>
                            <a href='#'><img src='./img/music.svg' class='form-icon-music'></a>
                            <a href='#'><img src='./img/Photo.svg' class='form-icon-photo'></a>
                            <a href='#'><img src='./img/Video.svg' class='form-icon-video'></a>
                        </div>

                        <button class='send-msg-btn'>
                            <img src='./img/iconSendMessage.svg' alt=''>
                        </button>
                    </form>
                </div>
            </section>
        <?else:?>
            <div class="select-user_con">
                <p>Select a user to start chating</p>
            </div>
        <?endif;?>
    </main>

    <script src="./js/chat.js"></script>
    <script src="./js/getUsers.js"></script>
</body>

</html>