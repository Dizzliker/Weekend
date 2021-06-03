<?
    require_once "./db/libs/rb-mysql.php";

    require_once "./db/db.php";

    // Пользователь авторизован, редиректим его на свой профиль 
    if (isset($_SESSION['logged_user'])) {
        header("Location: ./Profile.php");
    }

    $title = "Weekend | login page";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Подключаем общие св-ва для тега head -->
    <?require_once "./views/partials/head.php"?>
    <link rel="stylesheet" href="../css/signIn.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="login-con">
        <transition name="custom-classes=transition" enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutLeft">
            <div class="log-con" v-show="logForm">
                <form action="#" method="POST">
                    <fieldset class="log-field">
                        <img src="../img/Logo.svg">

                        <div class="log-error"></div>

                        <input type="email" name="logEmail" placeholder="E-mail" id="logEmail" tabindex="1">

                        <input type="password" name="logPass" placeholder="Password" id="logPass" tabindex="2">

                        <button type="submit" name="btn-sign-in" @click="logValidation()">Sign in</button>

                        <a href="#" @click="showForms()">Not registered yet?</a>
                    </fieldset>
                </form>
            </div>
        </transition>
        
        <transition name="custom-classes-transition" enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutRight">
            <div class="reg-con" v-show="regForm">
                <form action="#" method="POST">
                    <fieldset class="reg-field">
                        <img src="../img/Logo.svg">

                        <div class="reg-error"></div>

                        <input type="email" name="regEmail" placeholder="E-mail" id="regEmail" tabindex="1" required>

                        <input type="text" name="name" placeholder="First name" id="name" tabindex="2" required>

                        <input type="text" name="surname" placeholder="Last name" id="surname" tabindex="3" required>

                        <input type="date" name="date" placeholder="Birthday" id="date" tabindex="4" required>

                        <input type="password" name="regPass" placeholder="Password" id="pass" tabindex="5" required>

                        <button type="submit" name="btn-sign-up" @click="regValidation()">Sign up</button>
                        <a href="#" @click="showForms()">Already signed up?</a>
                    </fieldset>
                </form>
            </div>
        </transition>
    </div>
    <script src="../js/signIn.js"></script>
    <script src="./js/login.js"></script>
    <script src="./js/signup.js"></script>
</body>

</html>