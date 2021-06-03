<?
    // Подключаем библиотеку RedBeanPHP
    require_once './db/libs/rb-mysql.php';

    // Подключаемся к бд
    require_once './db/db.php';

    // Если пользователь не авторизован, редиректим его на страницу авторизации
    require_once "./db/redirect.php";

    // Название страницы
    $title = "Weekend | friends page";

    $allUsers = $_GET['allUsers'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Подключаем общие теги в head -->
    <?require_once './views/partials/head.php';?>
    <link rel="stylesheet" href="./css/FriendsCss.css">
</head>

<body>
    <main>
        <!-- Подключаем боковое меню aside -->
        <?require_once './views/partials/aside.php';?>

        <section class="user-friends_app">
           <div class="search-bar">
                <input type="text" placeholder="Search" class="input-search">
                <img src="./img/Search.svg" alt="" class="icon-search">
            </div>
            <div class="friends_app">
                <div class="friends_con">
                    <?  
                        // Проверка, выводим ли всех пользователей 
                        if (!$allUsers) {
                            // Ищем всех друзей пользователя
                            $friends = R::findOne("users", "id=?", array($_SESSION['logged_user']->id));

                            // Разбиваем всех друзей на отдельные плашки
                            $friend = explode(",", $friends->friend);

                            // Выводим всех друзей пользователя
                            if (!empty($friend)) {
                                for ($i = 0; $i < count($friend); $i++) {
                                    if ($friend[$i] != "") {
                                        $user = R::findOne("users", "id=?", array($friend[$i]));
                                        include "./db/dataFriend.php";
                                    }
                                }   
                            }
                        } else {
                            // Ищем всех пользователей
                            $users = R::findAll("users");

                            // Выводим всем пользователей
                            if ($users) {
                                foreach ($users as $user) {
                                    include "./db/dataFriend.php";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </section>

        <section class="right-side">
            <h2 class="user-action_head">
                Users actions
            </h2>

            <p>
                <a href="./FriendsPage.php?allUsers=true" class="link-all-users">
                    All users
                </a>
            </p>

            <div class="friends-request_con">
                <div class="friends-request_head">
                    <p class="count-add-friend">
                        <?
                            $id = $_SESSION['logged_user']->id;

                            $sql = "SELECT * FROM requests
                                    JOIN users ON requests.outgoing_rqst_id = users.id
                                    WHERE incoming_rqst_id = '$id'";
    
                            $possible_friends = R::getAll($sql);

                            $count_friends = count($possible_friends);
    
                            if ($count_friends) {
                                echo "+".$count_friends;
                            }
                        ?>
                    </p>

                    <p>
                        <a href="#" class="friends-request-text">
                            Friend requests
                        </a>
                    </p>

                    <img src="./img/arrowFriendsRequests.svg" alt=""  id = "icon-arrow" class="">
                </div>

                <div class="possible-friends_app">
                    <?
                        foreach($possible_friends as $friend) {
                            echo "
                            <div class='possible-friends_con'>
                                <div class='possible-friends-ava'>
                                    <a href='./Profile.php?id=$friend[id]'>
                                        <img src='$friend[ava]' alt='' class='friend-ava'>
                                    </a>
                                    <p class='friend-name'>
                                        <a href='./Profile.php?id=$friend[id]'>
                                            $friend[name]
                                        </a>
                                    </p>
                                </div>

                                <div class='details'>
                                    <a href='./db/addFriend.php?id=$friend[id]' title='Add to friend list'>
                                        <img src='./img/plus.svg' alt='Add' class='icon-add'>
                                    </a>
                                </div>

                                <div class='kebab'>
                                    <div class='circle'></div>
                                    <div class='circle'></div>
                                    <div class='circle'></div>
                                </div>
                            </div>
                            ";
                        }
                    ?>

                    
                </div>
            </div>
        </section>
    </main>

    <script src="./js/showFriends.js"></script>
    <script src="./js/friend.js"></script>
</body>
</html>