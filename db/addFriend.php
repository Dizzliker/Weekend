<?
    // Подключаем библиотеку RedBeanPHP
    require_once "./libs/rb-mysql.php";

    // Подключаемся к бд
    require_once "./db.php";

    // Исходящий id(залогиненный пользователь)
    $outgoing_id = $_SESSION['logged_user']->id;
    // Входящий id (кому отправляется запрос)
    $incoming_id = $_GET['id'];
    
    // Проверяем не отправлялся ли запрос до этого
    $rqst = R::findOne("requests", "(outgoing_rqst_id = ? AND incoming_rqst_id = ?) OR (incoming_rqst_id = ? AND outgoing_rqst_id = ?)",
                    [$outgoing_id, $incoming_id, $outgoing_id, $incoming_id]);

    // Функция добавления в друзья
    function addFriend($user_id, $new_friend_id) {
        // Ищем пользователя в бд
        $user = R::findOne("users", "id = ?", [$user_id]);

        // Берём друзей залогиненного пользователя
        $friend = $user->friend;
        $friends = explode(",",$friend);
        array_push($friends, $new_friend_id);
        $new_friends = implode(",", $friends);

        // Меняем список друзей, добавляя нового друга
        R::exec('UPDATE users SET friend = ? WHERE id = ?', [$new_friends, $user_id]);
    }

    // Если запрос не пустой, пытаемся отправить запрос 
    if (!empty($rqst)) {
        // Проверяем, нет запроса в друзья от этого пользователя нам, если есть - добавляем его в друзья
        if ($outgoing_id == $rqst->incoming_rqst_id) {
            addFriend($outgoing_id, $rqst->outgoing_rqst_id);
            addFriend($incoming_id, $rqst->incoming_rqst_id);

            R::hunt("requests", "id IN ($rqst->id)");
        } else {
            // Если запрос есть, но отправили его мы - ничего не делаем 
        }
        // Если запроса в базе нет - добавляем его
    } else if (empty($rqst)) {
        $requests = R::dispense("requests");

        $requests->outgoing_rqst_id = $outgoing_id;
        $requests->incoming_rqst_id = $incoming_id;

        R::store($requests);
    }

    header("Location: ../Profile.php?id=$incoming_id");
?>