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
        }
    }

    updateMe(() => {

        getContrats(userId);
        getSinistres(userId);
        getVentes(userId);

    });
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

function addUserToTable(USER) {
    let table;

    table = USER.type;

    if (!document.getElementById("table" + table)) {
        document.getElementById("tables").innerHTML += `<table class="table p-3"><tbody>${Object.keys(USER).filter((a) => {return cols[a] && true}).map((a) => `<tr><td>${cols[a]}</td><td>${show(a, USER[a])}</td></tr>`).join("")}</tbody></table>`;
    }

    if (USER.type === 1) {

    }

}

function dorequest(url, fct) {
    let r = new XMLHttpRequest();
    r.open("POST", url);

    // if (id) {
    //     let d = new FormData();
    //     d.append("id", id);
    //     r.send(d);
    // } else {
    //     r.send()
    // }

    r.send();

    r.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            fct(JSON.parse(this.responseText));
        }
    }
}

function getContrats(id) {
    {   
        dorequest("/contract/getList", (d) => {
            let target = document.getElementById("contrats");
            d.forEach((f) => {
                if (!f.owners || f.owners.includes(id)) {
                    target.innerHTML += `<li><a class="text-dark small" target="_blank" href="/view/${f.id}">${f.vID}</a></li>\n`;
                     document.getElementById("contrats_info").hidden = false;
                }
            });
        })
    }
}

function getSinistres(id) {
    {   
        dorequest("/sinistre/getList", (d) => {
            let target = document.getElementById("sinistres");
            d.forEach((f) => {
                if (f.user === id) {
                    target.innerHTML += `<li><a class="text-dark small" target="_blank" href="/sinistres/${f.id}">${f.id}</a></li>\n`;
                    document.getElementById("sinistres_info").hidden = false;
                }
            });
        })
    }
}

function getVentes(id) {
    {   
        dorequest("/declaration/getList", (d) => {
            let target = document.getElementById("declarations");
            d.forEach((f) => {
                if (f.user === id) {
                    target.innerHTML += `<li><a class="text-dark small" target="_blank" href="/declaration/${f.id}">${f.id}</a></li>\n`;
                    document.getElementById("declarations_info").hidden = false;
                }
            });
        })
    }
}