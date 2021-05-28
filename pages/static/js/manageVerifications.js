let TEMP = [];
let USERS = {};
let actualsort = {
    "key": null,
    "order": 0
};
let chosen = null;
let loadedid = false;


const cols = {
    "status": "Status",
    "owner": "Client",
    "modified": "Dernière modification",
    "comment": "Commentaire de l'assurance",
    "mod": "Pris en charge par"
};


function toggleModal() {
    let m = document.getElementById("modal");
    if (m.classList.contains("show")) {
        m.classList.remove("show");
        m.setAttribute("style", "display: none;");
    } else {
        m.classList.add("show");
        m.setAttribute("style", "display: block;");
        setFakeURL("Vérifications", '/verifications');
    }
}

function show(k, v) {
    let specials = {
        "owner": function() {
            getNameFromId(USERS, v, (u) => {
                document.getElementById("tables").innerHTML = document.getElementById("tables").innerHTML.replace(v, u["name"]);
            });
            return USERS[v] ? USERS[v].name : v;
        },
        "mod": function() {
            getNameFromId(USERS, v, (u) => {
                document.getElementById("tables").innerHTML = document.getElementById("tables").innerHTML.replace(v, u["name"]);
            });
            return USERS[v] ? USERS[v].name : v;
        },
        "modified": function() {
            return getDate(v);
        },
        "status": function() {
            switch (v) {
                case -1:
                    return "Rejeté"
                    break;
                case 0:
                    return "En cours"
                    break;
                case 1:
                    return "Validé"
                    break;
                default:
                    return "Erronné"
                    break;
            }
        },
        "birth": function() {
            return getDate(v);
        }
    };

    if (specials[k]) {
        return specials[k](v);
    } else {
        return v;
    }
}


function showVerification(id) {
    found = false;
    TEMP.forEach((v) => {
        if (v.id === id) {
            found = v;
        }
    });

    if (found) {
        if (loadedid) clearInterval(loadedid);
        toggleModal();
        chosen = found.id;
        for ([k,e] of Object.entries(found.content.raw)) {
            if (document.getElementById(k)) {
                document.getElementById(k).value = show(k, e);
            }
        }

        for ([k,e] of Object.entries(USERS[found.owner])) {
            if (document.getElementById("current_" + k)) {
                document.getElementById("current_" + k).value = show(k, e);

                if (document.getElementById(k).value !== document.getElementById("current_" + k).value) {
                    document.getElementById("current_" + k).setAttribute("class", "form-control bg-danger text-white");
                    document.getElementById(k).setAttribute("class", "form-control bg-success text-white");
                } else {
                    document.getElementById("current_" + k).setAttribute("class", "form-control");
                    document.getElementById(k).setAttribute("class", "form-control");
                }
            }
        }

        document.getElementById("justification").value = found.content.justification;

        document.getElementById("commentaires").hidden = document.getElementById("choix").hidden = (found.status || (me.type < 3))

        let list = document.getElementById("documents");
        list.innerHTML = "";
        found.content.files.forEach(f => {
            list.innerHTML += `<li><a class="text-dark" target="_blank" href="/useruploadedcontent/${f}">${f}</a></li>\n`;
        });
        
    }
}

function getData() {
    let r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            addVerificationsToTable(JSON.parse(this.responseText));
            TEMP = JSON.parse(this.responseText);
        }
    }
    r.open("POST", "/verification/list", true);
    r.send();
    if (isID('/verifications/')) {
        loadedid = setInterval(() => {
            showVerification(getTarget('/verifications/'))
        }, 500);
    }
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
        if (actualsort.order) {
            return ('' + a[key]).localeCompare(b[key]);
        } else {
            return ('' + b[key]).localeCompare(a[key]);
        }
    });
    document.getElementById("tables").innerHTML = "";
    addVerificationsToTable(TEMP);
}

function addVerificationToTable(V) {
    let table;
    let row = document.createElement('tr');
    row.setAttribute("onclick", "showVerification('"+V["id"]+"');");

    if (!document.getElementById("table")) {
        document.getElementById("tables").innerHTML += `<table class="table p-3"><thead><tr>${Object.keys(V).filter((a) => {return cols[a] && true}).map((a) => `<td onclick='sortby("${a}")'>${cols[a]}</td>`).join("")}</tr></thead><tbody id='table' ></tbody></table>`;
    }

    for ([i, k] of Object.entries(V)) {
        if (cols[i]) addCol(row, V[i] ?? "", i);
    }
    
    table = document.getElementById("table");
    table.appendChild(row);
}

function addVerificationsToTable(V) {
    for (let i=0; i<V.length;i++){
        addVerificationToTable(V[i]);
    }
}

function accept() {
    if (chosen) {
        let r = new XMLHttpRequest();
        let d = new FormData();
        d.append("id", chosen);
        if (document.getElementById("com").value.length > 0) d.append("comment", document.getElementById("com").value);
        r.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                window.location.reload()
            }
        }
        r.open("POST", "/verification/accept", true);
        r.send(d);
    }
}


function reject() {
    if (chosen) {
        let r = new XMLHttpRequest();
        let d = new FormData();
        d.append("id", chosen);
        if (document.getElementById("com").value.length > 0) d.append("comment", document.getElementById("com").value);
        r.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                window.location.reload()
            }
        }
        r.open("POST", "/verification/reject", true);
        r.send(d);
    }
}

