<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    $id = $_SESSION['logged_user']->id;
    $output = "";

    // Запрос на людей, с кем есть хоть одно сообщение
    $sql = "SELECT * FROM messages
    JOIN users ON users.id = messages.outgoing_msg_id
    WHERE messages.incoming_msg_id = '$id' 
    GROUP BY users.id UNION ALL
    (SELECT * FROM messages
    JOIN users ON users.id = messages.incoming_msg_id
    WHERE messages.outgoing_msg_id = '$id'
    GROUP BY users.id)
    ";

    // Массив с людьми хотя бы с одним сообщением
    $rows = R::getAll($sql);

    // echo "<pre>".print_r($rows,true)."</pre>";

    if ($rows) {
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = $rows[id] 
        OR outgoing_msg_id = $rows[id]) AND (incoming_msg_id = $_GET[id] 
        OR outgoing_msg_id = $_GET[id]) ORDER BY msg_id DESC LIMIT 1";

        // $msg = R::getAll($sql2);

        foreach($rows as $row) {
            $output .= "
            <a href='./MessagesPage.php?id=$row[id]' class='user-msg_con'>
                <div class='user-msg'>
                    <img src='$row[ava]'>
                    <p class='user-nickname'>$row[name] 
                        <span class='last-msg'>$row[msg]</span></p>
                    <p class='time-last-msg'>$row[msg_time]</p>
                </div>
            </a>
            ";
        }
    }
    echo $output;
?>