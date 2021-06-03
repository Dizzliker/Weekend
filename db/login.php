<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    $email = filter_var(trim($_POST['logEmail']), FILTER_SANITIZE_EMAIL);
    $pass = filter_var(trim($_POST['logPass']), FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($pass)) {
        $user = R::findOne('users', "email=?", [$email]);
        if ($user) {
            if (password_verify($pass, $user->password)) {
                $_SESSION['logged_user'] = $user;

                // Меняем онлайн статус пользователя
                R::exec("UPDATE users SET online = 'Online' WHERE id = ?", [$_SESSION['logged_user']->id]);

                echo "success";
            } else {
                echo "Password is incorrect";
            }
        } else {
            echo "E-mail not found";
        }
    } else {
        echo "All inputs fields are required!";
    }
?>