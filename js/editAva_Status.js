const body = document.querySelector("body"),
popupForm = document.querySelector(".popup-form-ava");

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
            body.classList.toggle("popup-active");
        },

        hideStatus(){
            // Скрываем текст/форму
            this.statusText = !this.statusText;
            this.statusForm = !this.statusForm; 

            this.iconEdit = !this.iconEdit;
            this.iconClose = !this.iconClose;
        },
        editAva() {
            let inputFile = this.$refs.inputFile;
            this.sendFile(inputFile.files[0]);
        },
        sendFile(file) {
            const popupError = this.$refs.popupError;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../db/editAva.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    let data = xhr.response;
                    if (data == "success") {
                        popupError.textContent = "Avatar uploaded successfully";
                        popupError.classList.add("success");
                        reloadPage();
                    } else {
                        popupError.textContent = data;
                        popupError.classList.add("active");
                    }
                } else {
                    console.error("Ошибка: не удалось отправить данные");
                }
            }
            const fd = new FormData();
            fd.append('avatar', file);
            // Initiate a multipart/form-data upload
            xhr.send(fd);
        }
    },

    mounted() {
        const dropzone = this.$refs.dropzone; 
        const dropzoneImg = this.$refs.dropzoneImg;
        const dropzoneText = this.$refs.dropzoneText;

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
            myAva.sendFile(filesArray[0]);
        }
    },
}

const myAva = Vue.createApp(ava).mount(".user-page-body_con");

popupForm.onsubmit = e => {
    e.preventDefault();
}

function reloadPage() {
    location.reload();
}