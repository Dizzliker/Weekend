<script>
    let trackList = <?
                $tracks = R::findAll("musics");
                echo "[";
                foreach($tracks as $track) {
                    // var_dump(json_decode($track,true));
                    echo "
                        {
                            'id': $track[id],
                            'author': '$track[author]',
                            'name': '$track[name]',
                            'src': '$track[src]',
                            'cover': '$track[cover]',
                            'duration': $track[duration],
                        },
                    ";
                }
                echo "];";
            ?>
</script>

<aside>
    <img src="./img/logo.svg" class="weekend-logo">
    <div class="my-profile_con">
        <a href="./Profile.php?id=<?=$_SESSION['logged_user']->id?>">
            <img src="<?=$_SESSION['logged_user']->ava?>" class="my-profile-ava">
        </a>
        <div class="my-profile-info">
            <a href="./Profile.php?id=<?=$_SESSION['logged_user']->id?>" class="my-profile-name">
                <?=$_SESSION['logged_user']->name." ".$_SESSION['logged_user']->surname;?>
            </a>
            <p class="my-profile-text">My profile</p>
        </div>
        <a href="#"><img src="./img/Settings.svg" class="my-profile-settings"></a>
        <a href="./db/logout.php" title="Logout"><img src="../img/Logout.svg" class="my-profile-logout"></a>
    </div>
    <ul class="menu">
        <li><img src="../img/News.svg" alt="" class="menu-icon"><a href="#">News</a></li>
        <li><img src="../img/Message.svg" class="menu-icon"><a
                href="./MessagesPage.php">Messages</a></li>
        <li><img src="../img/Friends.svg" class="menu-icon"><a
                href="./FriendsPage.php">Friends</a></li>
        <li><img src="../img/Communities.svg" class="menu-icon"><a href="#">Communitites</a></li>
        <li><img src="../img/Music.svg" class="menu-icon"><a href="./MusicPage.php">Music</a></li>
        <li><img src="../img/Photo.svg" class="menu-icon"><a href="#">Photos</a></li>
        <li><img src="../img/Video.svg" class="menu-icon"><a href="#">Videos</a></li>
    </ul>
    <div class="player_app">
        <div class="player-input">
            <input type="range" min="0" max="1" step="0.1" class="track-volume">
        </div>
        <div class="player_con">
            <img src="./img/Audio.jpg" class="track-cover">
            <div class="track-info">
                <p class="track-artist">unxknow</p>
                <p class="track-name">На корвалоле</p>
            </div>
            <img src="./img/Arrow-left.svg" class="player-arrow-last-track">
            <img src="./img/Pause.svg" class="player-pause-track">
            <img src="./img/Arrow-right.svg" class="player-arrow-next-track">
        </div>
        <div class="player-input">
            <input type="range" min="" max="" class="track-duration">
        </div>
        <p class="track-time"></p>
    </div>
</aside>

<script src="./js/track.js"></script>