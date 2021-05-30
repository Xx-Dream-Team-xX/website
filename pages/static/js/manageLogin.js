function login(form) {
    let d = new FormData();
    d.append("login", form.email.value);
    d.append("password", form.password.value);
    var req= new XMLHttpRequest();
    req.open("POST", "/auth/login");
    req.send(d);
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (JSON.parse(this.responseText) === true) {
                manageLogin();
            } else {
                updatePasswordhelp("Your email or password is incorrect");
            }
        }
    }
}

function logout() {
    var req= new XMLHttpRequest();
    req.open("GET", "/auth/logoff");
    req.send();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = "/";
        }
    }
}

function updatePasswordhelp(mess) {
    document.getElementById("passwordHelpBlock").innerText = mess;
}

function doLogin() {
    var loginForm = document.getElementById("loginForm");
    login(loginForm);
}

function manageLogin() {
    window.location.reload();
}

function b(a) {
    console.log(a);
}