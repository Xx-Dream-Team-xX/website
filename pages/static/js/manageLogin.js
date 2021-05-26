function login(form) {
    console.log("Logging in..");
    let d = new FormData();
    d.append("login", form.email.value);
    d.append("password", form.password.value);
    var req= new XMLHttpRequest();
    req.open("POST", "/auth/login");
    req.send(d);
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (JSON.parse(this.responseText) === true) {
                // redirect
                console.log("good");
            } else {
                updatePasswordhelp("Your email or password is incorrect");
            }
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

function loginResults(response) {
    console.log("login");
}
