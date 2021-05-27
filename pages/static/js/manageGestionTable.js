Users = [
    {
        "id": "60aec6503bc74",
        "type": 1,
        "mail": "salut@falut.com",
        "first_name": "Robert",
        "last_name": "Michel",
        "phone": "33606061206",
        "conversations": [],
        "notifications": [],
        "password_hash": "$2y$10$CVn1H7d.2TBUtUAJAQ7aNOy72v.UeYx7rmpjt4TitNCPfZDLpmd.K",
        "contracts": [
            "12432534588"
        ],
        "declarations": [],
        "sinisters": [],
        "zip_code": "33390",
        "address": "jsp",
        "birth": 0,
        "assurance": "234575421",
        "rep": "60acf3e57c1cf"
    }
]

function getData() {
    let r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            console.log(JSON.parse(this.responseText));
        } else {
            console.log("Server Error");
        }
    }
    r.open("POST", "/users/list", true);
    r.send();
}


function getBirthDate(date) {
    let d = new Date(date);
    return d.toLocaleDateString();
}

function addUserToTable(user) {
    let table = document.getElementById("users");

    let row = document.createElement('tr');
    let name = document.createElement('td');
    name.setAttribute("scope", "col");
    name.innerText = user["name"];
    row.appendChild(name);
    let mail = document.createElement('td');
    mail.setAttribute("scope", "col");
    mail.innerText = user["mail"];
    row.appendChild(mail);
    let birth = document.createElement('td');
    birth.setAttribute("scope", "col");
    birth.innerText = getBirthDate(user["birth"]);
    row.appendChild(birth);
    let declarations = document.createElement('td');
    declarations.setAttribute("scope", "col");
    declarations.innerText = user["declarations"].length;
    row.appendChild(declarations);
    let contracts = document.createElement('td');
    contracts.setAttribute("scope", "col");
    contracts.innerText = user["contracts"];
    row.appendChild(contracts);
    let sinisters = document.createElement('td');
    sinisters.setAttribute("scope", "col");
    sinisters.innerText = user["sinisters"].length;
    row.appendChild(sinisters);
    let actions = document.createElement('td');
    actions.setAttribute("scope", "col");
    actions.innerText = user["actions"];
    //row.appendChild(actions);
    
    table.appendChild(row);
}

function addUsersToTable(USERS) {
    for (let i=0; i<USERS.length;i++){
        addUserToTable(USERS[i]);
    }
}


function load() {
    // sort array to fit ??
    addUsersToTable(Users);
}
