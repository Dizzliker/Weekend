<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    // Проверка, залогинен ли пользователь
    if (isset($_SESSION['logged_user'])) {
        $outgoing_id = filter_var(trim($_POST['outgoing_id']), FILTER_SANITIZE_NUMBER_INT);
        $incoming_id = filter_var(trim($_POST['incoming_id']), FILTER_SANITIZE_NUMBER_INT);
        $output = "";

        // Запрос на получение сообщений
        $sql = "SELECT * FROM messages
                LEFT JOIN users ON users.id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id')
                OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY msg_id";

        // Массив со всеми сообщениями 2-х пользователей
        $rows = R::getAll($sql);

        if ($rows) {
            foreach ($rows as $row) {
                // Если пользователь является отправителем
                if ($row['outgoing_msg_id'] === $outgoing_id) {
                    $output .= 
                    '<div class="chat outgoing">
                            <time class="chat msg-time">'.$row['msg_time'].'</time>
                            <div class="details">
                                <p>'.$row['msg'].'</p>
                            </div>
                        </div>
                    ';
                // Если пользователь является получателем
                } else {
                    $output .= '
                    <div class="chat incoming">
                        <a href="../Profile.php?id='.$row['id'].'">
                            <img src="'.$row['ava'].'" alt="">
                        </a>
                        <div class="details">
                            <p>'.$row['msg'].'</p>
                        </div>
                        <time class="chat msg-time">'.$row['msg_time'].'</time>
                    </div>
                    ';
                }
            }
                
        }
        echo $output;

    } else {
        header("Location: ../login.php");
    }
?>