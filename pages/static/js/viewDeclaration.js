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

function toggle_phys(select, sexeNode) {
    if (select.value == "1") {
        document.getElementById(sexeNode).innerHTML = `
    <select class="form-select" aria-label="user" name="old_sex" id="old_sex" required>
        <option disabled selected>Sexe</option>
        <option value="1">Homme</option>
        <option value="0">Femme</option>
    </select>
        `;
    } else {
        document.getElementById(sexeNode).innerHTML = "";
    }
}

function toggle_cert(checkbox) {
    if (checkbox.checked) {
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

function toggle_VHU(checkbox) {
    if (checkbox.checked) {
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
            if ($node = document.getElementById(key) !== null) {
                document.getElementById(key).value = val;
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
