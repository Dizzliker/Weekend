const chatBox = document.querySelector(".chat-box"),
form = document.querySelector(".form-alert-msg #form-send-msg"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector(".send-msg-btn");

form.onsubmit = (e) => {
    e.preventDefault();
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/insertChat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // once message inserted into database then leave blank the input field
                inputField.value = "";
            }
        }
    }
    // We have to send the form data through ajax to php
    // creating new formData object
    let formData = new FormData(form);
    // sending the form data to php
    xhr.send(formData);
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/getChat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!chatBox.classList.contains("active")) {
                    chatBox.innerHTML = data;
                    scrollToBottom();
                }
            }
        }
    }
    // We have to send the form data through ajax to php
    // creating new formData object
    let formData = new FormData(form);
    // sending the form data to php
    xhr.send(formData);
}, 500);

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}