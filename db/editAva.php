<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";
    
    $ava = $_FILES['avatar'];

    // echo var_dump($ava);

    if ($ava['name'] != "") {
        if ($ava['size'] != 0) {
            // разбиваем имя файла по точке и получаем массив
            $getMime = explode('.', $ava['name']);
            // нас интересует последний элемент массива - расширение
            $mime = strtolower(end($getMime));
            // объявим массив допустимых расширений
            $types = array('jpg', 'png', 'jpeg', 'svg');

            if (in_array($mime, $types)) {
                // Example:
                $filename = $_FILES['avatar']['name'];
                // Директорая файла после загрузки с инпута
                $path = $_FILES['avatar']["tmp_name"];
                // Новая директория файла, где он будет храниться
                $newPath = "../img/avatars/".$filename;
                
                // Путь для сервера
                $serverPath = "./img/avatars/".$filename;
                
                // Перемещаем файл из старой директории в новую 
                move_uploaded_file($path, $newPath);

                // Меняем путь к аватарке
                R::exec('UPDATE users SET ava= :src WHERE id = :id', [':src'=>$serverPath,':id'=>$_SESSION['logged_user']->id]);

                // Ищем информацию пользователя
                $user = R::findOne('users', "id=?", array($_SESSION['logged_user']->id));

                session_reset();

                // Обновляем информацию в сессии
                $_SESSION['logged_user'] = $user;

                echo "success";
            } else {
                echo "Invalid file type. Available (jpg, png, jpeg, svg)";
            }
        } else {
            echo "File size is too large";
        }
    } else {
        echo "You haven't selected a file";
    }
?>