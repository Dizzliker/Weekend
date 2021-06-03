const time = document.querySelector(".player-now-track-time"),
inputDuraion = document.querySelector(".player-input-time"),
btnPauseMusic = document.querySelector(".player-now-track_con .btn-pause-track"),
btnLastMusic = document.querySelector(".player-now-track_con .icon-last-track"),
btnNextMusic = document.querySelector(".player-now-track_con .icon-next-track"),
inputSearch = document.querySelector(".input-search"),
trackContainer = document.querySelector(".user-playlist_wrapper");

// Плашки треков 
let unitTrack = document.querySelectorAll(".user-playlist-track_app");

// Поиск по музыке
inputSearch.onkeyup = () => {
    let searchTerm = inputSearch.value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/searchMusic.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let data = xhr.response;
            trackContainer.innerHTML = data;
            unitTrack = document.querySelectorAll(".user-playlist-track_app");
            playUnitTrack();
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}

function playUnitTrack() {
// Отслеживаем клик по плашке, если человек кликнул в нужное место, помещаем аудио в плеер
for (i = 0; i < unitTrack.length; i++) {
    unitTrack[i].addEventListener("click", e => { 
        if (e.target.classList.contains("play-track")) {
            const audioSrc = e.target.dataset.audioSrc,
            trackSrc = audioSrc;

            localStorage.setItem("trackTime", 0);
            localStorage.setItem("trackSrc", trackSrc);

            // Ставим предыдущий трек на паузу
            track.pause();
            // Обвовляет путь к треку и сам audio элемент
            newTrack(audioSrc);
            // Включаем новый трек
            track.play();
            // Меняем ин-фу о треке в плеере aside
            playMusic();
            // Меняем ин-фу о треке в плеере на странице музыки
            playTrack();
        }
    })
}
}

playUnitTrack();

function playTrack() {
    // Ф-ия меняющая трек только на странице музыки
    const cover = document.querySelector(".player-now-track-cover"),
    artist = document.querySelector(".player-now-track-artist"),
    name = document.querySelector(".player-now-track-name"),

    getTrackInfo = searchTrackInfo("src", trackSrc),
    trackInfo = getTrackInfo[0];

    cover.src = trackInfo["cover"];
    artist.textContent = trackInfo["author"];
    name.textContent = trackInfo["name"];
}

playTrack();

// Перезаписываем ф-ию концовки трека
// для того, чтобы ин-фа обновлялась в обоих плеерах
trackEnd = () => {
    if (track.ended) {
        nextTrack();
        playTrack();
    }
}

// Обновляем время трека и передвигаем ползунок в интервале
setInterval(() => {
    inputDuraion.value = track.currentTime;

    inputDuraion.min = 0;
    inputDuraion.max = track.duration;

    time.textContent = getTrackTime();
}, 100);

function musicTime() {
    // Ф-ия перемотки трека на странице музыки
    track.currentTime = inputDuraion.value;
    localStorage.setItem("trackTime", inputDuraion.value);
}

inputDuraion.oninput = musicTime;
btnPauseMusic.onclick = trackPlayPause;
btnNextMusic.addEventListener("click", () => {
    nextTrack();
    playTrack();
});
btnLastMusic.addEventListener("click", () => {
    lastTrack();
    playTrack();
});
// Добавляем прослушивание событий для перелистывания
// трека ещё и на плашке на странице музыки
btnNext.addEventListener("click", () => {
    playTrack();
});
btnLast.addEventListener("click", () => {
    playTrack();
});
