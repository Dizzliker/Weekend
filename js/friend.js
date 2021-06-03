const inputSearch = document.querySelector(".input-search"),
friendContainer = document.querySelector(".friends_con");

// Поиск по друзьям
inputSearch.onkeyup = () => {
    let searchTerm = inputSearch.value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../db/searchFriend.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                friendContainer.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}