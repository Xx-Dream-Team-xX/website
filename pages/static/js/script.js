function check() {
    let p1 = document.getElementById('password_confirm').value;
    let p2 = document.getElementById('password_check').value;
    if (p1 == p2) {
        if (p1.length >= 8 && p1.length <= 64) {
            passwordStrong(p1);
        } else {
            document.getElementById("passwordHelpBlock").innerText = "The password must be longer than 8 characters and shorter that 64";
            document.getElementById("password-change-button").disabled = true; 
        }
    } else {
        document.getElementById("passwordHelpBlock").innerText = "The passwords do not match";
        document.getElementById("password-change-button").disabled = true; 
    }
}


function passwordStrong(password) {
    var pattern = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$");

    if (password) {
        if (pattern.test(password)) {
            document.getElementById("passwordHelpBlock").innerText = "";
            document.getElementById("password-change-button").disabled = false; 
        } else {
            document.getElementById("passwordHelpBlock").innerText = "Password must contain at least a lowercase, Uppercase and a Number";
            document.getElementById("password-change-button").disabled = true; 
        }
    }
}

