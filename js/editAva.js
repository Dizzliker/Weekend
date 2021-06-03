const ava = {
    data() {
        return {
            popupAvaApp: false,
        }
    },

    methods: {
        showPopupAva() {
            this.popupAvaApp = !this.popupAvaApp;
        }
    },
}

Vue.createApp(ava).mount(".Info");

function sendFile(file) {
    const uri = "./Profile.php";
    const xhr = new XMLHttpRequest();
    const fd = new FormData();

    xhr.open("POST", uri, true);
    fd.append('avatar', file);
    // Initiate a multipart/form-data upload
    xhr.send(fd);
}


const dropzone = document.getElementById("dropzone");
const dropzoneImg = document.querySelector(".dropzone-img");
const dropzoneText = document.querySelector(".dropzone-text");

dropzone.ondragover = dropzone.ondragenter = function(event) {
    event.stopPropagation();
    event.preventDefault();
    dropzoneText.style.color = "#B60F46";
    dropzone.classList.add('drag-enter');
    // dropzoneImg.setAttribute("src", "../img/iconImg(purple).svg");
    dropzoneImg.src = "../img/iconImg(purple).svg";
}

dropzone.ondragleave = function(event) {
    event.stopPropagation();
    event.preventDefault();
    dropzoneText.style.color = "#000";
    dropzone.classList.remove('drag-enter');
    // dropzoneImg.setAttribute("src", "../img/iconImg.svg");
    dropzoneImg.src = "../img/iconImg.svg";
}

dropzone.ondrop = function(event) {
    event.stopPropagation();
    event.preventDefault();
    let filesArray = event.dataTransfer.files;
    sendFile(filesArray[0]);
}
