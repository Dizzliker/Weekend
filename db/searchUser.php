<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    $searchTerm = filter_var(trim($_POST['searchTerm']), FILTER_SANITIZE_STRING);
    $output = "";

    $sql = "SELECT * FROM users 
    WHERE (name LIKE '%{$searchTerm}%' OR surname LIKE '%{$searchTerm}%')";

    $rows = R::getAll($sql);

    if ($rows) {
        foreach($rows as $row) {
            $output .= "
            <a href='./MessagesPage.php?id=$row[id]' class='user-msg_con'>
                <div class='user-msg'>
                    <img src='$row[ava]'>
                    <p class='user-nickname search'>$row[name] $row[surname]</p>
                </div>
            </a>
        ";
        }
    } else {
        $output .= "<div class='search-not-found-text'>No user found related to your search term</div>";
    }
    echo $output;
?>