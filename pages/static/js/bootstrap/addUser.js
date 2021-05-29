function create() {
    let r = new XMLHttpRequest();
    let d = new FormData();

    d.append("type", document.getElementById("type").value);
    d.append("assurance", document.getElementById("assurance").value);
    d.append("mail", document.getElementById("mail").value);
    d.append("first_name", document.getElementById("first_name").value);
    d.append("last_name", document.getElementById("last_name").value);
    d.append("phone", document.getElementById("phone").value);



    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            r = JSON.parse(this.responseText);
            if (r.success) {
                document.getElementById("new_mail").value = document.getElementById("mail").value;
                document.getElementById("new_password").value = r.password;
            } else {
                document.getElementById("error").hidden = false;
            }
        }
    }

    r.open("POST", "/auth/register", true);
    r.send();
}

function loadAssurances() {
    let ass = document.getElementById("assurances");
    let r = new XMLHttpRequest();
    r.open("GET", '/assurance/list');
    r.send();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            r = JSON.parse(this.responseText);
            r.forEach(a => {
                ass.innerHTML += `<option value="${a.id}">${a.name}</option>`;
            });
        }
    }
}