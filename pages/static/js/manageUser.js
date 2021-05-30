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
            addUserToTable(JSON.parse(this.responseText));
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
    console.log(USER);
    addInfo("Nom", USER["last_name"]);
    addInfo("Prénom", USER["first_name"]);
    addInfo("Adresse", USER["address"]);
    addInfo("Code Postal", USER["zip_code"]);
    addInfo("Mail", USER["mail"]);
    addInfo("Numéro de Téléphone", USER["phone"]);
    let d = new Date(USER["birth"]);
    addInfo("Date de Naissance", getFormatDate(new Date(USER["birth"])));
}


const cols = {
    "name": "Nom",
    "mail": "Mail",
    "birth": "Date de Naissance",
    "phone": "Téléphone",
    "zip_code": "Code Postal",
    "address": "Adresse",
    "declarations": "Déclarations",
    "assurance": "ID assurance",
    "contracts": "Contrats",
    "sinisters": "Sinistres",
    "type": "Type"
};

function show(k, v) {
    let specials = {
        "type": function() {
            return types[v]
        },
        "birth": function() {
            return getDate(v)
        },
        "mail": function() {
            return (v ? v : "");
        }
    };

    if (specials[k]) {
        return specials[k](v);
    } else {
        return v;
    }
}

let TEMP = [];
let actualsort = {
    "key": null,
    "order": 0
};


function addCol(table, text, type){
    let c = document.createElement('td');
    c.setAttribute("scope", "col");
    c.setAttribute("class", "text-dark");
    c.innerHTML = show(type, text);
    table.appendChild(c);
}

function sortby(key) {

    if (actualsort.key === key) {
        actualsort.order ^= true;
    } else {
        actualsort.order = 0;
    }
    actualsort.key = key;

    TEMP.sort((a, b) => {
        if (!actualsort.order) {
            return ('' + a[key]).localeCompare(b[key]);
        } else {
            return ('' + b[key]).localeCompare(a[key]);
        }
    });
    document.getElementById("tables").innerHTML = "";
    addUsersToTable(TEMP);
}

function addUserToTable(USER) {
    let table;
    let row = document.createElement('tr');
    table = USER.type;

    if (!document.getElementById("table" + table)) {
        document.getElementById("tables").innerHTML += `<table class="table p-3"><tbody>${Object.keys(USER).filter((a) => {return cols[a] && true}).map((a) => `<tr><td>${cols[a]}</td><td>${USER[a]}</td></tr>`).join("")}</tbody></table>`;
    }

    for ([i, k] of Object.entries(USER)) {
        if (cols[i]) addCol(row, USER[i] ?? "", i);
    }
}
