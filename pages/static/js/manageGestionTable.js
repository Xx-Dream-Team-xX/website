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

function getData() {
    let r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            addUsersToTable(JSON.parse(this.responseText));
            TEMP = JSON.parse(this.responseText);
            sortby("name");
        }
    }
    r.open("POST", "/users/list", true);
    r.send();
}

function addCol(table, text, type){
    let c = document.createElement('td');
    c.setAttribute("scope", "col");
    c.setAttribute("class", "text-dark");
    c.innerHTML = show(type, text);
    table.appendChild(c);
}

function clearTables() {
    Array.prototype.slice.call(document.getElementsByTagName("tbody")).map(e => e.innerHTML = "");
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

    clearTables()

    Array.prototype.slice.call(document.getElementsByTagName("td")).map(e => {if ((e.onclick.toString()).includes(key)) ((!actualsort.order) ? e.setAttribute("class", 'text-info') : e.setAttribute("class", "text-danger")); else e.setAttribute("class", "")})

    addUsersToTable(TEMP);
}

function filterTable() {
    f = document.getElementById("filter").value;
    filtered = [];
    if (f.length > 0) {
        filtered = TEMP.filter(e => {
            keep = false;
            for ([k, v] of Object.entries(e)) {

                if (("" + v).toLowerCase().includes(f.toLowerCase())) {
                    keep = true;
                }
            }

            return keep;
        })
    } else {
        filtered = TEMP;
    } 
    clearTables();
    addUsersToTable(filtered);
}

function addUserToTable(USER) {
    let table;
    let row = document.createElement('tr');
    if (USER.type === 1) row.setAttribute("onclick", "window.location='/user/"+USER["id"]+"';");

    table = USER.type;

    if (!document.getElementById("table" + table)) {
        document.getElementById("tables").innerHTML += `<table class="table p-3"><thead class="table-dark"><tr class="mouse-cursor">${Object.keys(USER).filter((a) => {return cols[a] && true}).map((a) => `<td onclick='sortby("${a}")'>${cols[a]}</td>`).join("")}</tr></thead><tbody id='table${table}' ></tbody></table>`;
    }

    for ([i, k] of Object.entries(USER)) {
        if (cols[i]) addCol(row, USER[i] ?? "", i);
    }
    
    table = document.getElementById("table" + table);
    table.appendChild(row);
}

function addUsersToTable(USERS) {

    document.getElementById("search").hidden = (TEMP.length == 1)
    for (let i=0; i<USERS.length;i++){

        addUserToTable(USERS[i]);
    }
}


