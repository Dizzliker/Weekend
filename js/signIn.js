const container = {
    data() {
        return {
            logForm: true,
            regForm: false,
        }
    },
    methods: {
        showForms() {
            this.logForm = !this.logForm;
            this.regForm = !this.regForm;
        },

        checkEmpty(inputName, errorText, defaultText) {
            if (inputName.value.trim() == "") {
                inputName.setAttribute("placeholder", errorText);
                inputName.className = "empty";
            } else {
                inputName.setAttribute("placeholder", defaultText);
                inputName.classList.remove("empty");
            }
        },

        regValidation() {
            const email = document.getElementById("regEmail");
            const name = document.getElementById("name");
            const surname = document.getElementById("surname");
            const birthday = document.getElementById("date");
            const pass = document.getElementById("pass");

            // Проверка email на пустоту
            this.checkEmpty(email, "Enter email address", "Email");
            // Проверка инпута с именем на пустоту
            this.checkEmpty(name, "Enter your name", "First name");
            // Проверка инпута с фамилией на пустоту
            this.checkEmpty(surname, "Enter your surname", "Last name");
            // Проверка пароля на пустоту
            this.checkEmpty(pass, "Enter your password", "Password");

            // Проверка инпута с датой на пустоту
            if (birthday.value.trim() == "") {
                birthday.className = "emptyDate";
            } else {
                birthday.classList.remove("emptyDate");
            }
        },

        logValidation() {
            const email = document.getElementById("logEmail");
            const pass = document.getElementById("logPass");

            // Проверка email на пустоту
            this.checkEmpty(email, "Enter email address", "Email");
            // Проверка пароля на пустоту
            this.checkEmpty(pass, "Enter your password", "Password");
        }
    }
}

Vue.createApp(container).mount(".login-con");