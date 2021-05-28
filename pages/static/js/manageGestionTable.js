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

function addCol(table, text){
    let c = document.createElement('td');
    c.setAttribute("scope", "col");
    c.innerText = text;
    table.appendChild(c);
}

function addUserToTable(USER) {
    let table = document.getElementById("users");

    let row = document.createElement('tr');
    row.setAttribute("onclick", "window.location='/user/"+USER["id"]+"';");

    addCol(row, USER['name']);
    addCol(row, USER['mail']);
    
    table.appendChild(row);
}

function addUsersToTable(USERS) {
    for (let i=0; i<USERS.length;i++){
        console.log(USERS[i]);
        addUserToTable(USERS[i]);
    }
}


