const cols = {
    "type": "Type",
    "name": "Nom",
    "mail": "Mail",
    "birth": "Date de Naissance",
    "declarations": "Déclarations",
    "phone": "Téléphone",
    "zip_code": "Code Postal",
    "address": "Adresse",
    "assurance": "ID assurance",
    "contracts": "Contrats",
    "sinisters": "Sinistres"
};

function show(k, v) {
    let specials = {
        "type": function() {
            return types[v]
        },
        "birth": function() {
            return getDate(v)
        }
    }

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

function getData() {
    let r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            addUsersToTable(JSON.parse(this.responseText));
            TEMP = JSON.parse(this.responseText);
        }
    }
    r.open("POST", "/users/list", true);
    r.send();
}


function getBirthDate(date) {
    let d = new Date(date);
    return d.toLocaleDateString();
}

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
        console.log(`a: ${a[key]} b: ${b[key]} \n`);
        if (actualsort.order) {
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
    row.setAttribute("onclick", "window.location='/user/"+USER["id"]+"';");

    table = USER.type;

    if (!document.getElementById("table" + table)) {
        document.getElementById("tables").innerHTML += `<table class="table p-3"><thead><tr>${Object.keys(USER).filter((a) => {return cols[a] && true}).map((a) => `<td onclick='sortby("${a}")'>${cols[a]}</td>`).join("")}</tr></thead><tbody id='table${table}' ></tbody></table>`;
    }

    for ([i, k] of Object.entries(USER)) {
        if (cols[i]) addCol(row, USER[i] ?? "", i);
    }
    
    table = document.getElementById("table" + table);
    table.appendChild(row);
}

function addUsersToTable(USERS) {
    for (let i=0; i<USERS.length;i++){

        addUserToTable(USERS[i]);
    }
}


