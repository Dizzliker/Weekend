<?
    require_once "./libs/rb-mysql.php";

    require_once "./db.php";

    $searchTerm = filter_var(trim($_POST['searchTerm']), FILTER_SANITIZE_STRING);
    $output = "";

    $sql = "SELECT * FROM musics 
    WHERE (name LIKE '%{$searchTerm}%' OR author LIKE '%{$searchTerm}%')";

    $rows = R::getAll($sql);

    if ($rows) {
        foreach($rows as $track) {
            $output .= "
            <div class='user-playlist-track_app play-track' data-audio-src='$track[src]' title='Click to play'>
                <div class='user-playlist-track_con play-track' data-audio-src='$track[src]'>
                    <img src='$track[cover]' alt='' class='imgOfNowPlayingMusic play-track' data-audio-src='$track[src]'>
                    
                    <div class='track-details'>
                        <a href='#' class='play-audio'>
                            <p class='artist play-track' data-audio-src='$track[src]'>
                                $track[author]
                            </p>
                        </a>
                        <a href='#' class='play-audio'>
                            <p class='track-name play-track' data-audio-src='$track[src]'>
                                $track[name]
                            </p>
                        </a>
                    </div>
                    <div class='track-actions'>
                        <a href='#'>
                            <img src='./img/iconVolume.svg' alt=''>
                        </a>
                        <a href='#'>
                            <img src='./img/iconReplay.svg' alt=''>
                        </a>
                        <a href='#'>
                            <img src='./img/iconRepost.svg' alt=''>
                        </a>
                        <div class='kebab'>
                            <div class='circle'></div>
                            <div class='circle'></div>
                            <div class='circle'></div>
                        </div>
                    </div>
                </div>
            </div>
        ";
        }
    } else {
        $output .= "<div class='search-not-found-text'>No user found related to your search term</div>";
    }
    echo $output;
?>