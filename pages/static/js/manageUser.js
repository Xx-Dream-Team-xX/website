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
            addUserToTable(JSON.parse(this.responseText));
        } else {
            console.log("Server Error");
        }
    }
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
        document.getElementById("tables").innerHTML += `<table class="table p-3"><tbody>${Object.keys(USER).filter((a) => {return cols[a] && true}).map((a) => `<tr><td>${cols[a]}</td><td>${show(a, USER[a])}</td></tr>`).join("")}</tbody></table>`;
    }

}
