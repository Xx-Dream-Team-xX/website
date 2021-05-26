Users = [
    {
        "id": "12345678987654",
        "name": "Alex",
        "mail": "alex@g.com",
        "type": 1,
        "birth": 234567123,
        "declarations": 0,
        "contracts": 0,
        "sinisters": 0,
        "actions": 0
    },
    {
        "id": "12345678987654",
        "name": "Me",
        "mail": "moi@m.com",
        "type": 1,
        "birth": 2234123,
        "declarations": 5,
        "contracts": 1,
        "sinisters": 1,
        "actions": 0
    }
]

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
    declarations.innerText = user["declarations"];
    row.appendChild(declarations);
    let contracts = document.createElement('td');
    contracts.setAttribute("scope", "col");
    contracts.innerText = user["contracts"];
    row.appendChild(contracts);
    let sinisters = document.createElement('td');
    sinisters.setAttribute("scope", "col");
    sinisters.innerText = user["sinisters"];
    row.appendChild(sinisters);
    let actions = document.createElement('td');
    actions.setAttribute("scope", "col");
    actions.innerText = user["actions"];
    row.appendChild(actions);
    
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
