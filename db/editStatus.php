<?
    require_once './libs/rb-mysql.php';

    // Подключаемся к бд
    require_once './db.php';

    // Текст с формы нового статуса
    $textStatus = trim($_POST['status-new-text']);

    // Обновляем поле status в таблице users
    R::exec('UPDATE users SET status= :textStatus WHERE id = :id', [':textStatus'=>$textStatus,':id'=>$_SESSION['logged_user']->id]);

    // Ищем информацию о пользователе
    $user = R::findOne("users", "id=?", array($_SESSION['logged_user']->id));

    // Обновляем информацию в сессии 
    $_SESSION['logged_user'] = $user;

    // Перенаправление на страницу профиля
    header("Location: ../Profile.php");
?>