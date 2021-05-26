function login(form) {
    console.log("Logging in..");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "/auth/login", true);
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            loginResults(xmlhttp);
        } else {
            console.log("Login error");
        }
    }
}

function doLogin() {
    var loginForm = document.getElementById("loginForm");
    login(loginForm);
}

function loginResults(response) {
    console.log("login");
}
