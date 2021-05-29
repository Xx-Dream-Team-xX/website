function create() {
    let r = new XMLHttpRequest();
    let d = new FormData();

    d.append("type", document.getElementById("type").value);
    d.append("assurance", document.getElementById("assurance").value);
    d.append("mail", document.getElementById("mail").value);
    d.append("first_name", document.getElementById("first_name").value);
    d.append("last_name", document.getElementById("last_name").value);
    d.append("phone", document.getElementById("phone").value);



    r.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            addUsersToTable(JSON.parse(this.responseText));
            TEMP = JSON.parse(this.responseText);
        }
    }
    r.open("POST", "/auth/register", true);
    r.send();
}

function loadAssurances() {
    document.getElementById("assurances");
}