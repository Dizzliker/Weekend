const regForm = document.querySelector(".reg-con form"),
regBtnSend = regForm.querySelector("button"),
regError = regForm.querySelector(".reg-error"),
inputName = regForm.querySelector("fieldset input[type='text']:nth-child(4)"),
inputSurname = regForm.querySelector("fieldset input[type='text']:nth-child(5)");

// Регулярное выражение русских и английсвих букв
const regex = /[^A-Za-zА-Яа-яЁё]/g;
 
// Не даем пользователю водить ничего, кроме букв
inputName.oninput = function(){
    if(this.value.match(regex)){
        this.value = this.value.replace(regex, "");
    }
    // Ограничение символов в инпуте
    if (this.value.length >= 20) {
        this.value = this.value.substring(0, 20);
    }
}
inputSurname.oninput = function(){
    if(this.value.match(regex)){
        this.value = this.value.replace(regex, "");
        
    }
    // Ограничение символов в инпуте
    if (this.value.length >= 20) {
        this.value = this.value.substring(0, 20);
    }
}

regForm.onsubmit = (e) => {
    e.preventDefault();
}

regBtnSend.onclick = () => {
    let xhr = new XMLHttpRequest;
    xhr.open("POST", "../db/signup.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data == "succcess") {
                    location.href = "../Profile.php";
                } else {
                    regError.style.display = "flex";
                    regError.textContent = data;
                }
            }
        }
    }
    let formData = new FormData(regForm);
    xhr.send(formData);
}