<?
    if (!isset($_SESSION['logged_user'])) {
        header("Location: index.php");
    }
?>