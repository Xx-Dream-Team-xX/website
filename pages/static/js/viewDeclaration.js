function fillOptionDeclaration() {
    let req = new XMLHttpRequest();
    req.open("POST", "/declaration/getList");
    req.send();
    req.onreadystatechange = function () {

        if (this.status === 200 && this.readyState === 4) {
            let delcarations = JSON.parse(this.responseText);
            let declarationNode = document.getElementById("contrat_sinistre");
            delcarations.forEach(declaration => {
                let option = document.createElement("option");
                option.value = declaration.id;
                option.innerText = `${declaration.manufacturer} (${declaration.contract})`;
                declarationNode.appendChild(option);
            });
        }
    }
}

function toggle_cert(checked) {
    if (checked) {
        document.getElementById('formule').innerHTML = `
        <div class="col-sm-6 mt-0">
            <p class="h6 mt-0 text-dark">Numéro de formule</p>
            <input type="text" pattern="[0-9]{11}" class="form-control p-1" name="ima_cert_id" id="ima_cert_id">
        </div>`;
    } else {
        document.getElementById('formule').innerHTML = `
        <p class="h6 mt-0 text-dark"> Motif d’absence de certificat d’immatriculation :</p>
        <textarea id="ima_missing_cert_desc" name="ima_missing_cert_desc" type="text" aria-describedby="button-addon2" class="form-control rounded border bg-light" required></textarea>`;
    }
}

function toggle_VHU(checked) {
    if (checked) {
        document.getElementById('VHU').innerHTML = `
        <input type="text" placeholder="VHU" pattern="[0-9]*" class="form-control" name="VHU_id" id="VHU_id" required>`;
    } else {
        document.getElementById('VHU').innerHTML = ``;
    }
}

function showDeclaration(declaration) {
    for (const key in declaration) {
        if (Object.hasOwnProperty.call(declaration, key)) {
            const val = declaration[key];
            switch (key) {
                case 'old_sex':
                case 'new_sex':
                    if (val) {
                        document.getElementById(key).value = 'Homme'
                    } else {
                        document.getElementById(key).value = 'Femme'
                    }
                    break;
                case 'old_physical':
                case 'new_physical':
                    if (!val) {
                        document.getElementById(key).value = 'Morale'
                    } else {
                        document.getElementById(key).value = 'Physique'
                    }
                    break;
                case 'imaDate':
                case 'birthdate':
                    document.getElementById(key).value = getDate(declaration.imaDate);
                    break;
                case 'for_destruction':
                    if (val) {
                        document.getElementById(key).value = 'Céder'
                    } else {
                        document.getElementById(key).value = 'Céder pour destruction'
                    }
                    break;
                case 'old_agree_1':
                case 'old_agree_2':
                case 'old_agree_destruction':
                case 'new_agree_date':
                case 'ima_cert':
                case 'new_agree_vState':
                    document.getElementById(key).checked = val;
                    break;
                default:

                    if ($node = document.getElementById(key) !== null) {
                        document.getElementById(key).value = val;
                    }
                    break;
            }
        }
    }
}

function querryDeclaration(id) {
    let req = new XMLHttpRequest();
    req.open("POST", "/declaration/get");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(`id=${id}`);
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            declaration = JSON.parse(this.responseText);
            showDeclaration(declaration);
        }
    }
}

function onLoad() {
    fillOptionDeclaration();
}
