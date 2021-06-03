<?
    // Подключаем библиотеку RedBeanPHP
    require_once './db/libs/rb-mysql.php';

    // Подключаемся к бд
    require_once './db/db.php';

    // Если пользователь не авторизован, редиректим его на страницу авторизации
    require_once "./db/redirect.php";

    // Название страницы
    $title = "Weekend | music page";

    // Скрипт для добавления музыки 
    
    // Создаем таблицу musics
    // $musics = R::dispense("musics");

    // $musics->cover = "./img/musics/3daysrain.jpg";
    // $musics->author = "Роки";
    // $musics->name = "Малышка";
    // $musics->duration = 142;
    // $musics->src = "./audio/Роки-Малышка -kissvk.com.mp4";
    // // Сохраняем таблицу
    // R::store($musics);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Подключаем общие теги в head -->
    <?require_once './views/partials/head.php';?>
    <link rel="stylesheet" href="./css/MusicCss.css">
</head>

<body>
    <main>
        <!-- Подключаем боковое меню -->
        <?require_once './views/partials/aside.php'?>

        <section id="user-musics_app">
            <div class="search-bar">
                <input type="text" placeholder="Search" class="input-search">
                <img src="./img/Search.svg" alt="" class="icon-search">
            </div>

            <div class="user-musics_head">
                <p class="now-playing-text">
                    Now Playing
                </p>

                <div class="user-musics-add-track">
                    <img src="./img/Plus.svg" alt="" class="icon-plus">
                    <p>
                        <a href="#" class="link-add-track">
                            Add your music
                        </a>
                    </p>
                </div>

                <p>
                    <a href="#" class="link-friends-musics">
                        Friends music
                    </a>
                </p>
            </div>


            <div class="player-now-track_app">
                <div class="player-now-track_con">
                    <a href="#">
                        <img src="./img/Arrow-left.svg" alt="" class="icon-last-track">
                    </a>

                    <a href="#">
                        <img src="./img/pause.svg" alt="" class="btn-pause-track">
                    </a>

                    <a href="#">
                        <img src="./img/Arrow-right.svg" alt="" class="icon-next-track">
                    </a>

                    <img src="./img/Audio.jpg" alt="" class="player-now-track-cover">
                    <div class="player-now-track_info">
                        <div class="player-now-track_head">
                            <div class="player-now-track_info_con">
                                <p class="player-now-track-artist">
                                    uxknow
                                </p>
                                <p class="player-now-track-name">
                                    На корвалоле
                                </p>
                            </div>
                            <p class="player-now-track-time">
                                0:00
                            </p>
                        </div>
                        <input type="range" class="player-input-time">

                    </div>
                    <div class="player-now-track_actions">
                        <a href="#">
                            <img src="./img/iconVolume.svg" alt="">
                        </a>

                        <a href="#">
                            <img src="./img/iconReplay.svg" alt="">
                        </a>

                        <a href="#">
                            <img src="./img/iconRepost.svg" alt="">
                        </a>
                        <div class="kebab">
                            <div class="circle"></div>
                            <div class="circle"></div>
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-playlist_con">
                <p class="user-playlist-text">
                    Your playlist
                </p>
            </div>

            <div class="user-playlist_app">
                <div class="user-playlist_wrapper">
                    <?
                        // Ищем треки в бд
                        $tracks = R::find('musics');

                        foreach ($tracks as $track) {
                            echo "
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
                    ?>
                </div>
            </div>

        </section>

        <section class="right-side">
            <div class="search-bar">
                <input type="text" placeholder="Search" class="input-search">
                <img src="./img/Search.svg" alt="" class="icon-search">
            </div>

            <p class="right-side-text">
                Albums
            </p>

            <div class="albums_app">
                <div class="album_con">
                    <div class="album-cover">
                        <div class="shadow40Percent">
                            <div class="album-info">
                                <p class="album-name">
                                    Киндерхор
                                </p>
                                <p class="album-artist">
                                    playingtheangel & Adamant
                                </p>
                                <p class="album-year">
                                    2020
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="album_con">
                    <div class="album-cover">
                        <div class="shadow40Percent">
                            <div class="album-info">
                                <p class="album-name">
                                    Делаю любовь
                                </p>
                                <p class="album-artist">
                                    aikko
                                </p>
                                <p class="album-year">
                                    2020
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="album_con">
                    <div class="album-cover">
                        <div class="shadow40Percent">
                            <div class="album-info">
                                <p class="album-name">
                                    мои друзья не должны умирать
                                </p>
                                <p class="album-artist">
                                    aikko
                                </p>
                                <p class="album-year">
                                    2020
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="album_con">
                    <div class="album-cover">
                        <div class="shadow40Percent">
                            <div class="album-info">
                                <p class="album-name">
                                    В моём доме только ты и пистолет
                                </p>
                                <p class="album-artist">
                                    inspace
                                </p>
                                <p class="album-year">
                                    2020
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="./js/music.js"></script>
</body>

</html>