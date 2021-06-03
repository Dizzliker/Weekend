<?
    require_once './libs/rb-mysql.php';

    // Подключаемся к бд
    require_once './db.php';

    $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
    $status = filter_var(trim($_POST['status']), FILTER_SANITIZE_STRING);
    $ava = filter_var(trim($_POST['ava']), FILTER_SANITIZE_STRING);

    function valueIsEmpty($value, $defaultValue) {
        return $value = isset($value) ? $value : $defaultValue;
    }

    $user = R::findOne("users", "id=?", [$id]);

    $name = valueIsEmpty($name, $user['name']);
    $surname = valueIsEmpty($surname, $user['surname']);
    $status = valueIsEmpty($status, $user['status']);
    $ava = valueIsEmpty($ava, $user['ava']);

    R::exec("UPDATE users 
    SET name = '{$name}', 
    surname = '{$surname}', 
    status = '{$status}', 
    ava = '{$ava}'
    WHERE id = '{$id}'");

    header("Location: ../adminPanel.php");
?>