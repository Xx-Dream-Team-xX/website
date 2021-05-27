function showError(error) {
    document.getElementById("errors").innerText = error;
    document.getElementById("addbutton").disabled = true;
}

function removeError() {
    document.getElementById("errors").innerText = "";
    document.getElementById("addbutton").disabled = false;
}

function check(ele, type, error) {
    var p;
    switch (type) {
        case 'phone':
            p = new RegExp("^[0-9]{9,14}");
            if (!(p.test(ele.value))){
                showError(error);
            } else {
                removeError();
            }
            break;
        case 'zip':
            p = new RegExp("(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?");
            if (!(p.test(ele.value))){
                showError(error);
            } else {
                removeError();
            }
            break;
        
        default:
            break;            
    }
}

function addAssures() {
    let f = document.getElementById("form");
    let p = new FormData();
    p.append("mail", f["Email"].value);
    p.append("first_name", f["Name"].value);
    p.append("last_name", f["Surname"].value);
    p.append("phone", f["telephoneNumber"].value);
    p.append("address", f["Address"].value);
    p.append("zip_code", f["CodePostal"].value);
    console.log(f["birthdate"].value);
    let d = new Date(f["birthdate"].value);
    p.append("birth", d/1000);
    let r = new XMLHttpRequest();
    r.open("POST", "/auth/register");
    r.send(p);
    r.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let j = JSON.parse(this.responseText);
            if (j["success"] === true){
                showAddedUser(f["Surname"].value, f["Name"].value, f["Email"].value, j["password"]);
            }else{
                console.log("some error", j["success"]);
            }
        } else {
            console.log("server Error");
        }
    }
}

function showAddedUser(surname, name, login, password) {
    document.getElementById("form").style.visibility = "hidden";
    document.getElementById("subtitle").innerText = "Assures Ajouté";
    document.getElementById("table").style.visibility = "visible";
    document.getElementById("nom").innerText = surname;
    document.getElementById("pen").innerText = name;
    document.getElementById("log").innerText = login;
    document.getElementById("mdp").innerText = password;
}
