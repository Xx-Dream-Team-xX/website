function showError(error) {
    document.getElementById("errors").innerText = error;
    document.getElementById("addbutton").disabled = true;
}

function removeError() {
    document.getElementById("errors").innerText = "";
    document.getElementById("addbutton").disabled = false;
}

function showPass() {
    document.getElementById("created_password").type = "text";
}

function showErrors(e){
    switch (e) {
        case 1:
            showError("Erreur serveur -  Champ Téléphone");
            break;
        case 2:
            showError("Erreur serveur -  Champ Adresse");
            break;
        case 3:
            showError("Erreur serveur -  Champs Nom / Prénom");
            break;
        case 4:
            showError("Erreur serveur -  Champ email");
            break;
        case 5:
            showError("Erreur serveur -  Adresse email déjà enregistrée");
            break;
        case 6:
            showError("Erreur serveur -  Le mot de passe n'est pas assez fort");
            break;
        case 7:
            showError("Erreur serveur -  Veuillez remplir tous les champs correctement");
            break;
        default:
        
    }
}

function testValue(r, v, e){
    let p = new RegExp(r);
    if (!(p.test(v))){
        showError(e);
    } else {
        removeError();
    }
}

function check(ele, type, error) {

    switch (type) {
        case 'phone':
            testValue("^[0-9]{9,14}", ele.value, error);
            break;
        case 'zip':
            testValue("(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?", ele.value, error);
            break;
        case 'name':
            testValue("^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$", ele.value, error);
            break;
        case 'street':
            // Not working, possibly due to \- at end ?
            //testValue("^([0-9A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ \-])*", ele.value, error);
            testValue(".*", ele.value, error);
            break;
        case 'email':
            testValue("^\\S+@\\S+\\.\\S+$", ele.value, error);
        
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
                showErrors(j['message'])
            }
        }
    }
}

function showAddedUser(surname, name, login, password) {
    document.getElementById("form").hidden = true;
    document.getElementById("subtitle").innerText = "Identifiants de " + surname + " " + name;
    document.getElementById("results").hidden = false;
    document.getElementById("created_email").value = login;
    document.getElementById("created_password").value = password;
}
