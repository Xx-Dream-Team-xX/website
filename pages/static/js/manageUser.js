function onLoad() {
    if (!isID('/user/')) {
        window.location.href="/404";
    }

    let userId = getTarget('/user/');

    let p = new FormData();
    p.append("id", userId);
    
    let req = new XMLHttpRequest();
    req.open("POST", "/users/get");
    req.send(p);
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(JSON.parse(this.responseText));
            addUserInfo(JSON.parse(this.responseText));
        } else {
            console.log("Server Error");
        }
    }
}

function getFormatDate(d) {
    let a = d.toJSON();
    return a.split('T')[0];
}

function addInfo(id, text) {
    let t = document.getElementById("userInfo");

    let r = document.createElement("tr");
    t.appendChild(r);
    let c1 = document.createElement("th");
    c1.setAttribute("scope", "col");
    c1.innerText = id;
    r.appendChild(c1);
    let c2 = document.createElement("th");
    c2.setAttribute("scope", "col");
    c2.innerText = text;
    r.appendChild(c2);
}

function addUserInfo(USER) {
    addInfo("Nom", USER["last_name"]);
    addInfo("Prenom", USER["first_name"]);
    addInfo("Adress", USER["address"]);
    addInfo("Code Postal", USER["zip_code"]);
    addInfo("Mail", USER["mail"]);
    addInfo("Numero", USER["phone"]);
    addInfo("Date de Naissace", getFormatDate(new Date(USER["birth"])));
}
