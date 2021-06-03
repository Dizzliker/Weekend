<?
    session_start();

    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    if (isset($_SESSION['logged_user'])) {
        $outgoing_id = filter_var(trim($_POST['outgoing_id']), FILTER_SANITIZE_NUMBER_INT);
        $incoming_id = filter_var(trim($_POST['incoming_id']), FILTER_SANITIZE_NUMBER_INT);
        $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);
        $msg_time = date("H:i");

        // $tz = 'America/New_York';
        // $tz_obj = new DateTimeZone($tz);
        // $today = new DateTime("now", $tz_obj);
        // $msg_time = $today->format('H:i');

        

        if (!empty($message)) {
            R::exec("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, msg_time) 
                    VALUES ('$incoming_id','$outgoing_id','$message', '$msg_time')");
        }
    } else {
        header("Location: ../index.php");
    }
?>