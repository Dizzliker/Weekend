const userList = document.querySelector("#msgs_app .users-msgs_con"),
searchBtn = document.querySelector(".search-btn"),
inputSearch = document.querySelector(".input-search"),
iconSearch = document.querySelector(".icon-search");

inputSearch.onkeyup = () => {
    let searchTerm = inputSearch.value;
    if (searchTerm != "") {
        inputSearch.classList.add("active");
    } else {
        inputSearch.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/searchUser.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                userList.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}


userList.onmouseenter = () => {
    userList.classList.add("active");
}

userList.onmouseleave = () => {
    userList.classList.remove("active");
}

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/getUsers.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!userList.classList.contains("active") &&
                    !inputSearch.classList.contains("active")) {
                    userList.innerHTML = data;
                }
            }
        }
    }
    xhr.send();
}, 500);