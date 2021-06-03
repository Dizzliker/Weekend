<?
    require_once './libs/rb-mysql.php';

    // Подключаемся к БД 
    require_once 'db.php';

    // Обновляем онлайн статус пользователя
    R::exec('UPDATE users SET online= "Offline" WHERE id = :id', [':id'=>$_SESSION['logged_user']->id]);

    // Производим выход пользователя
    unset($_SESSION['logged_user']);

    // Редирект на авторизацию
    header('Location: ../index.php');
?>