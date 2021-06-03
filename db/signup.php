<?
    require_once './libs/rb-mysql.php';

    require_once "./db.php";

    $email = filter_var(trim($_POST['regEmail']), FILTER_SANITIZE_EMAIL);
    $pass = filter_var(trim($_POST['regPass']), FILTER_SANITIZE_STRING);
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
    $birthday = filter_var(trim($_POST['date']), FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($pass) && !empty($name) && !empty($surname) && !empty($birthday)) {
        // Разбиваем email на массив
        $check_email = preg_split("/[\@]/", $email);
        // Массив разрешенных почт
        $access_email = ["mail.ru", "gmail.com", "ya.ru", "yandex.ru", "bk.ru"];
        // Проверяем на разрешенность почты
        if (in_array($check_email[1], $access_email)) {
            $user = R::count('users', "email=?", [$email]);
            if ($user < 1) {
                // Создаем таблицу users
                $users = R::dispense('users');

                // Добавляем в таблицу записи
                $users->email = $email;
                $users->name = $name;
                $users->surname = $surname;
                $users->birthday = date("d.m.y", strtotime($birthday));
                $users->online = "Online";
                $users->status = "It's my status";
                $users->ava = "./img/avatars/1sQrhJTnWgU.jpg";

                // Хешируем пароль
                $users->password = password_hash($pass, PASSWORD_DEFAULT);

                $_SESSION['logged_user'] = $users;

                // Сохраняем таблицу
                R::store($users);

                echo "succcess";
            } else {
                echo "User with this email is already registered";
            }
        } else {
            echo "Email is incorrect! (Supported types(mail.ru, gmail.com, ya.ru, yandex.ru, bk.ru)";
        }
    } else {
        echo "All inputs are required!";
    }
?>