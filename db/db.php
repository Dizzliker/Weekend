<?
    // Подключаем библиотку RedBeanPHP
    // include './libs/rb-mysql.php';

    // Подключаемся к БД 
    R::setup('mysql:host=localhost;dbname=weekend;', 'root', '');

    // Проверка на подключение к БД
    if (!R::testConnection()) die('No DB connection!');

    // Создаем сессию для авторизации
    session_start();
?>