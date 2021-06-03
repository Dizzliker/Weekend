<?
    require_once './libs/rb-mysql.php';

    // Подключаем в бд
    require_once "./db.php";

    // Берем id поста, который мы передаем в ссылке, с помощью гиперссылки
    $id = $_GET['id'];

    // Удаляем пост с определенным id
    R::hunt( 'posts',' id IN ( '.$id.')');

    // Перенаправляемся обратно на страницу
    header("Location: ../Profile.php");
?>