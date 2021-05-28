function showError(error, id="error") {
    document.getElementById(id).innerText = error;
    document.getElementById("addbutton").disabled = true;
}

function removeError() {
    document.getElementById("errors").innerText = "";
    document.getElementById("addbutton").disabled = false;
}

function showPass(id) {
    (document.getElementById(id).type === "text") ? document.getElementById(id).type = "password" : document.getElementById(id).type = "text";
}

function onLoad() {
    updateMe(() => {
        me['birth'] = getDate(me['birth']);
        for ([i, k] of Object.entries(me)) {
            if (document.getElementById(i)) document.getElementById(i).value = k;
        }
    });
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
            showError("Erreur serveur -  Mauvaise adresse mail ou adresse déjà utilisée");
            break;
        case 5:
            showError("Erreur serveur -  Mauvais mot de passe");
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
    var p;
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

function submitVerification() {
    let f = document.getElementById("details");
    let p = new FormData();
    p.append("first_name", f["first_name"].value);
    p.append("last_name", f["last_name"].value);
    p.append("phone", f["phone"].value);
    p.append("address", f["address"].value);
    p.append("zip_code", f["zip_code"].value);

    let files = document.getElementById("files").files;
    for (let i = 0; i < files.length; i++) {
        p.append("files" + i, files[i], files[i].name);
    }

    let d = new Date(f["birth"].value);
    p.append("birth", d/1000);
    let r = new XMLHttpRequest();

    r.open("POST", "/account/set");
    r.send(p);
    r.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let j = JSON.parse(this.responseText);
            if (j){
                window.location.href = "/verifications/" + j;
            }else{
                showError("Veuillez respecter le formattage et vous assurer de bien attacher vos justificatifs.", "errors");
            }
        }
    }
}

function changeAccountData() {
    r = new XMLHttpRequest();
    d = new FormData();
    r.open("POST", "/auth/changepassword");
    d.append("mail", document.getElementById("mail").value);
    d.append("password", document.getElementById("password").value);
    if (document.getElementById("new_password").value.length > 0) d.append("new", document.getElementById("new_password").value);
    r.send(d);
    r.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let j = JSON.parse(this.responseText);
            if (j["success"]) {
                window.location.reload();
            } else {
                showErrors(j.message)
            }
        }
    }
}