const ava = {
    data() {
        return {
            // Всплывающее окно замены аватарки
            popupAvaApp: false,

            // Плашка текста статуса
            statusText: true,
            // Форма редактирования статуса
            statusForm: false,

            iconEdit: true,
            iconClose: false,
        }
    },

    methods: {
        showPopupAva() {
            this.popupAvaApp = !this.popupAvaApp;
        },

        hideStatus(){
            // Скрываем текст/форму
            this.statusText = !this.statusText;
            this.statusForm = !this.statusForm; 

            this.iconEdit = !this.iconEdit;
            this.iconClose = !this.iconClose;
            
            // Скрываем/показываем иконку карандашика(редактирования)
            // this.$refs.iconEdit.classList.toggle("active");

            // const newTextStatus = this.$refs.inputEditStatus;
            // newTextStatus.focus();

            // console.log(this.$refs.inputEditStatus);
        },
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
