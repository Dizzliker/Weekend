const btnPause = document.querySelector(".player-pause-track"),
btnNext = document.querySelector(".player-arrow-next-track"),
btnLast = document.querySelector(".player-arrow-last-track"),
timeCon = document.querySelector(".track-time"),
inputVolume = document.querySelector(".track-volume"),
inputTime = document.querySelector(".track-duration");

let trackSrc;
if (localStorage.getItem("trackSrc")) {
    trackSrc = localStorage.getItem("trackSrc");
} else {
    trackSrc = trackList[0]["src"];
}

let track = new Audio(trackSrc);

function newTrack(newSrc) {
    trackSrc = newSrc;
    track = new Audio(newSrc);
}

let trackEnd = () => {
    if (track.ended) {nextTrack();}
}

function playMusic() {
    const artistCon = document.querySelector(".player_app .track-artist"),
    nameCon = document.querySelector(".player_app .track-name"),
    coverCon = document.querySelector(".player_app .track-cover"),
    getTrackInfo = searchTrackInfo("src", trackSrc),
    trackInfo = getTrackInfo[0];
    
    inputVolume.value = localStorage.getItem("trackVolume");
    track.currentTime = localStorage.getItem("trackTime");
    track.volume = localStorage.getItem("trackVolume");

    artistCon.textContent = trackInfo["author"];
    nameCon.textContent = trackInfo["name"];
    coverCon.src = trackInfo["cover"];

    let trackPause = localStorage.getItem("trackPause");
    if (!trackPause) {track.play()}
}

playMusic();

function searchTrackInfo(searchPropery, searchItem) {
    for (let i = 0; i < trackList.length; i++) {
        if (trackList[i][searchPropery] == searchItem) {
            return [trackList[i], i];
        }
    }
}

const nextTrack = () => {
    const getTrackInfo = searchTrackInfo("src", trackSrc);
    let trackId = getTrackInfo[1];
    trackId += 1
    trackId >= trackList.length ? trackId = 0 : trackId = trackId;

    newTrackInfo = trackList[trackId];

    localStorage.setItem("trackSrc", newTrackInfo["src"]);
    localStorage.setItem("trackTime", 0);

    track.pause();

    newTrack(newTrackInfo["src"]);
    playMusic();

    track.play();
}

const lastTrack = () => {
    const getTrackInfo = searchTrackInfo("src", trackSrc);
    let trackId = getTrackInfo[1];

    trackId -= 1
    trackId <= trackList.length ? trackId = 0 : trackId = trackId;

    newTrackInfo = trackList[trackId];

    localStorage.setItem("trackSrc", newTrackInfo["src"]);
    localStorage.setItem("trackTime", 0);

    track.pause();

    newTrack(newTrackInfo["src"]);
    playMusic();

    track.play();
}

function getTrackTime() {
    // Ф-ия к-ая возвращает текущее время трека
    min = Math.floor(inputTime.value / 60);
    sec = inputTime.value % 60;
    sec < 10 ? sec = "0"+sec : sec = sec
    return min+":"+sec;
}

// Обновляем время трека
setInterval(() => {
    inputTime.value = track.currentTime;

    inputTime.min = 0;
    inputTime.max = track.duration;

    trackEnd();

    localStorage.setItem("trackTime", inputTime.value);
    timeCon.textContent = getTrackTime();
}, 100);

function trackPlayPause() {
    // Функция паузы и воспроизведения аудио
    track.paused ? track.play() : track.pause();
    localStorage.setItem("trackPause", track.paused);
}

function trackTime() {
    // Ф-ия перемотки аудио
    track.currentTime = inputTime.value;
    localStorage.setItem("trackTime", inputTime.value);
}

function trackVolume() {
    // Ф-ия громкости аудио
    track.volume = inputVolume.value;
    localStorage.setItem("trackVolume", inputVolume.value);
}

btnPause.onclick = trackPlayPause;
inputTime.oninput = trackTime;
inputVolume.oninput = trackVolume;

btnNext.onclick = nextTrack;
btnLast.onclick = lastTrack;