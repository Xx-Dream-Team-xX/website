function getData() {
    let r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            addUsersToTable(JSON.parse(this.responseText));
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
    row.setAttribute("onclick", "window.location='/user?user="+user["id"]+"';");
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
    
    table.appendChild(row);
}

function addUsersToTable(USERS) {
    for (let i=0; i<USERS.length;i++){
        console.log(USERS[i]);
        addUserToTable(USERS[i]);
    }
}


