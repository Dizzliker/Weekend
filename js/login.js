const form = document.querySelector(".log-con form"),
btnSend = form.querySelector("button"),
error = form.querySelector(".log-error");

form.onsubmit = (e) => {
    e.preventDefault();
}

btnSend.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/login.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data === "success") {
                    location.href = "../Profile.php";
                } else {
                    error.style.display = "flex";
                    error.textContent = data;
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}