<?
    require_once './libs/rb-mysql.php';

    // Подключаем в бд
    require_once './db.php';

    $text_post = filter_var(trim($_POST['txtarea-post']), FILTER_SANITIZE_STRING);

    if (!empty($text_post)) {
        // Создаем таблицу posts
        $posts = R::dispense('posts');

        // Заполняем таблицу данными
        $posts->user_id = $_SESSION['logged_user']->id;
        $posts->date = date('d F Y \a\t H:m');
        $posts->text = $text_post;
        $posts->likes = "0";
        $posts->reposts = "0";
        $posts->comments = "0";

        // Сохраняем таблицу
        R::store($posts);

        header("Location: ../Profile.php");
    } else {
        echo "Error";
    }

    
?>