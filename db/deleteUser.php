<?
    require_once './libs/rb-mysql.php';

    // Подключаем в бд
    require_once "./db.php";

    // id пользователя, которого будем удалять 
    $id = $_GET['id'];

    // Удаляем пользователя по id
    
    R::hunt( 'users',' id IN ( '.$id.')');

    header("Location: ../adminPanel.php");
?>